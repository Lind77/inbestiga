<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasEndLabel">
      <div class="offcanvas-header">
        <h3 id="offcanvasEndLabel" class="offcanvas-title">{{ project_selected.title }}<small class="text-primary h5" v-if="project_selected.team"> (Equipo {{ project_selected.team.name }})</small><router-link v-if="project_selected.customer" target="_blank" :to="{name:'ecard', params:{ id: project_selected.customer.id}}" class="btn btn-dark btn-sm"><i class='bx bx-credit-card-alt'></i></router-link></h3>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      
      <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <a href="javascript:void(0)">{{ sumTasksPercent }} %</a>
        <div class="progress mb-3">
          <div class="progress-bar" role="progressbar" :style="{width: sumTasksPercent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
          </div>
        </div>
        <h5 class="text-danger">Fecha de Culminación: {{ project_selected.deadline }}</h5>
        <div v-if="project_selected.activities == []">No hay actividades asignadas</div>
        <div v-else>
          <div v-for="activity in project_selected.activities">
          <div v-if="activity.type == 0">
          <div :class="`card ${activity.progress[0].percentage == 100 ? 'bg-success' : 'bg-danger'} text-white p-3 mb-1`" >
          <div class="card-title d-flex align-items-center justify-content-between mb-0">
            <h5 class="text-white mb-0">{{ activity.title }}</h5>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" v-bind:checked="activity.progress[0].percentage == 100" @click="selectActivity(activity)">
              
            </div>           
          </div>
          </div>
        </div>
        </div>
        </div>        
        <div class="row">
          <div class="col-lg-12 col-md-12 mt-2">
            <button class="btn btn-success w-100 p-3" @click="changeStatus" v-bind:disabled="sumTasksPercent != 100">Enviar a Dirección Académica</button>
          </div>
        </div>
        <h5 class="mt-4">Cliente</h5>
        <CardCustomer v-if="project_selected.customer" :customer="project_selected.customer"/>
      </div>
    </div>
    <ProgressModal :activity="activity_selected" :project_selected="project_selected" @getActivities="getActivities"/>
    <TeamModal :project="project_selected" :activity="activity_selected" @getActivities="getActivities"/>
</template>
<script>
//import moment from 'moment'
import ProgressModal from './ProgressModal.vue'
import CardTeam from './CardTeam.vue'
import CardCustomer from './CardCustomer.vue'
import TeamModal from './TeamModal.vue'

export default{
    name:'OffCanvas',
    components:{ CardTeam, CardCustomer, ProgressModal, TeamModal },
    emits:['getAllProjects'],
    props:{
        project_selected: Object,
        projectActivities: { 
          type: Array,
          default: []
        }
    },
    data(){
      return {
        fecha: new Date(),
        progress_selected: {},
        activity_selected: {},
        percentageActivities: 0,
        activities: []
      }
    },
    methods:{
        changeStatus(){
          const fd = new FormData()

            fd.append('status', 1)
            fd.append('project_id', this.project_selected.id)

            axios.post('https://jairpl.com/autoDeploy/public/api/changeStatusProject', fd)
            .then(res =>{
              $('#offcanvas').offcanvas('hide')
              this.$emit('getAllProjects')
            })
            .catch(err =>{
              console.log(err.response.data)
            })
        },
        getActivities(){
          axios.get(`/api/getActivitiesPerId/${this.project_selected.id}`)
          .then(res =>{
            this.project_selected.activities = res.data
          })
          .catch(err =>{
            console.log(err.response.data)
          })
        },
        sumTasks(project_selected){
          if(project_selected){
            var sumTasks = 0
          }
          this.percentageActivities = sumTasks
        },
        selectActivity(activity){
          if(activity.title == 'Reunión con dirección académica'){
            $('#progressModal').modal('show')
          }else if(activity.title == 'Asignar Equipo'){
            $('#teamModal').modal('show')
          }else{
            const fd = new FormData()
                fd.append('id', activity.id)
                fd.append('comment', 'Completado')
                fd.append('project_id', this.project_selected.id)

                axios.post('/api/updateProgress', fd)
                .then(res =>{
                    console.log(res)
                    this.getActivities()
                    this.comment = ''
                })
                .catch(err =>{
                    if(err.response){
                        console.log(err.response.data)
                    }
                })
          }
          this.activity_selected = activity
        },
        addProgress(progress, e){
            document.getElementById(e.target.id).indeterminate = true
            this.progress_selected = progress
        }
    },
    computed:{
      sumTasksPercent(){
        if(this.project_selected.activities){
          var sumTasks = 0
          var numTasks = 0
          this.project_selected.activities.forEach(activity => {
              if(activity.type == 0){
               sumTasks = sumTasks + parseFloat(activity.progress[0].percentage)
               numTasks = numTasks + 1
              }
          })
          if(isNaN(sumTasks/numTasks)){
            return 0
          }else{
            return sumTasks/numTasks
          }
        }else{
          return 0
        }
      }
      /* sumPercent(){
        if(this.project_selected.tasks){
          return this.project_selected.acttasks.reduce((acc, item) => acc + item.pivot.percent, 0)/this.project_selected.tasks.length;
        }
      } */
    },
    mounted(){
      this.getActivities(this.project_selected.id)
    }
} 
</script>