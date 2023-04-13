<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasEndLabel">
      <div class="offcanvas-header">
        <h3 id="offcanvasEndLabel" class="offcanvas-title">{{ project_selected.title }}</h3>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <p class="text-primary h5" v-if="project_selected.team"> (Equipo {{ project_selected.team.name }})</p>
        <a href="javascript:void(0)">{{ sumTasksPercent }} %</a>
        <div class="progress mb-3">
          <div class="progress-bar" role="progressbar" :style="{width: sumTasksPercent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
          </div>
        </div>
        <h5 class="text-danger">Fecha de Culminación: {{ project_selected.deadline }}</h5>
        <div v-if="project_selected.activities == []">No hay actividades asignadas</div>
        <div v-else>
          <div v-for="activity in project_selected.activities">
              <ActivityCard :project_selected="project_selected" :activity="activity" @selectActivity="selectActivity" @uncheckActivity="uncheckActivity" @checkActivity="checkActivity"/>
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
    <TeamModal :project="project_selected" :activity="activity_selected" @colorActivity="colorActivity" @updateProgress="updateProgress"/>
    <FirstModal :activity="activity_selected" @checkActivity="checkActivity" @colorActivity="colorActivity"/>
</template>
<script>
import { userStore } from '../../../stores/UserStore'
import ProgressModal from './ProgressModal.vue'
import CardTeam from './CardTeam.vue'
import CardCustomer from './CardCustomer.vue'
import ActivityCard from './ActivityCard.vue'
import TeamModal from './TeamModal.vue'
import FirstModal from './FirstModal.vue'

export default{
    name:'OffCanvas',
    components:{ CardTeam, CardCustomer, ProgressModal, ActivityCard, TeamModal, FirstModal},
    emits:['getAllProjects'],
    props:{
        project_selected: Object,
        projectActivities: { 
          type: Array,
          default: []
        }
    },
    setup(){
      const store = userStore()
      return { store }
    },
    data(){
      return {
        fecha: new Date(),
        progress_selected: {},
        activity_selected: {},
        percentageActivities: 0,
        activities: [],
        activityId: 0,
        activitySelectedId:0
      }
    },
    methods:{
        colorActivity(activity){
          console.log('called since first modal')
          var activitySelected = this.project_selected.activities.find(el => el.id == activity.id)
          activitySelected.isCompleted = true
          activitySelected.progresses[0].percentage = 100
        },
        checkActivity(activity){

          var activitySelected = this.project_selected.activities.find(el => el.id == activity.id)

          if(activity.fixed_activity_id == 5 || activity.fixed_activity_id == 8){
            activitySelected.isCompleted = true
            activitySelected.progresses[0].percentage = 100
            this.updateProgress(activity)
          }else if(activity.fixed_activity_id == 6){
            this.activity_selected = activitySelected
            $('#teamModal').modal('show')
          }else if(activity.fixed_activity_id == 7){
            this.activity_selected = activitySelected
            $('#firstMeetModal').modal('show')
          }

           /*  this.activitySelectedId = activityId */
              
                /* 
                console.log(this.bgColor) */
                    //this.updateActivityProgress(activityId)     
        },
        uncheckActivity(activity){
          var activitySelected = this.project_selected.activities.find(el => el.id == activity.id)

            if(activity.fixed_activity_id == 5 || activity.fixed_activity_id == 8){
              activitySelected.isCompleted = false
              activitySelected.progresses[0].percentage = 0
              this.minusProgress(activity)
            }
        },
        changeStatus(){
          const fd = new FormData()

            fd.append('emisor_id', this.store.authUser.id)
            fd.append('status', 1)  
            fd.append('project_id', this.project_selected.id)

            axios.post('/api/changeStatusProject', fd)
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
        selectActivity(activityId){
          var selectedActivity =  this.project_selected.activities.find(activity => activity.id == activityId)
          if(selectedActivity.progresses[0].percentage != 100){
            selectedActivity.progresses[0].percentage = 100
          }
        },
        unselectActivity(activityId){
          var selectedActivity =  this.project_selected.activities.find(activity => activity.id == activityId)
        
          selectedActivity.progresses[0].percentage = 0
        },
        activateCheckbox(activityId){

        },
        updateProgress(activity){
          const fd = new FormData()
                fd.append('id', activity.id)
                fd.append('comment', 'Completado')
                fd.append('project_id', this.project_selected.id)
                fd.append('emisor_id', this.store.authUser.id)

                axios.post('/api/updateProgress', fd)
                .then(res =>{
                    console.log(res)  
                    this.comment = ''
                })
                .catch(err =>{
                    if(err.response){
                        console.log(err.response.data)
                    }
                })
        },
        minusProgress(activity){
          const fd = new FormData()
                fd.append('id', activity.id)
                fd.append('comment', 'No Completado')
                fd.append('project_id', this.project_selected.id)
                fd.append('emisor_id', this.store.authUser.id)

                axios.post('/api/deleteActivityProgress', fd)
                .then(res =>{
                    console.log(res)  
                    this.comment = ''
                })
                .catch(err =>{
                    if(err.response){
                        console.log(err.response.data)
                    }
                })
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
               sumTasks = sumTasks + parseFloat(activity.progresses[0].percentage)
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
    }
} 
</script>