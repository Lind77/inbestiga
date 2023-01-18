<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Kanban - {{ project.title }} - {{ secondsFormatted }}</h4>
        <h5>Porcentaje de avance</h5>
        <a href="javascript:void(0)">15%</a>
        <div class="progress mb-3">
          <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
          <div class="progress-bar bg-success progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: percentAcad + '%' }" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
         <!--  <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div> -->
        </div>
        <div class="row">
          <div class="col-md-4 border border-danger rounded vh-100" id="todoArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold text-center">
              <h4>TO DO</h4>
            </div>
            <div class="container-cards">
              <div v-for="task in tasks">
                <div v-if="task.status == 0">
                  <CardTask :task="task"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 border border-warning rounded vh-100" id="doingArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold text-center">
              <h4>DOING</h4>
            </div>
            <div class="container-cards">
              <div v-for="task in tasks">
                <div v-if="task.status == 1">
                  <CardTask :task="task"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 border border-success rounded vh-100" id="doneArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold text-center">
              <h4>DONE</h4>
            </div>
            <div class="container-cards">
              <div v-for="task in tasks">
                <div v-if="task.status == 2">
                  <CardTask :task="task"/>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
import CardActivity from './CardActivity.vue'
import CardTask from './CardTask.vue'
import {useCounterStore} from '../../../../stores/UserStore'

export default {
    components: { CardActivity, CardTask },
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
        return{
            project: [],
            activities: [],
            tasks:[],
            localTime: " ",
            seconds: " ",
            totalTime: '',
            percentAcad: 0
        }
    },
    methods:{
        addPercent(nroTasksDone){
          this.percentAcad = this.percentAcad + (80/this.tasks.length)*nroTasksDone
        },
        getProjectById(){
            axios.get(`/api/getProjectById/${this.$route.params.idProject}`)
            .then(res =>{
                this.project = res.data.project[0]
                this.totalTime = res.data.total_time
                this.activities = this.project.activities
                var nroTasksDone = 0
                this.activities.forEach((activity) =>{
                  activity.tasks.forEach((task) =>{
                    this.tasks.push(task)
                    if(task.status == 2){
                      nroTasksDone = nroTasksDone + 1
                    }
                  })
                })
                this.addPercent(nroTasksDone)
            })
        },
        allowDrop(e){
          e.preventDefault()
        },
        drop(e){
          e.preventDefault()
          if(this.store.rol == 'Acad'){ 
          var data = e.dataTransfer.getData('text')
          e.target.appendChild(document.getElementById(data))
          if(e.target.id == 'doneArea'){
            this.addPercent(1)
          }
          }else{
            alert('Usted no puede modificar las tareas')
          }
        }
    },
    mounted(){
        this.getProjectById()
    },
    computed:{
      secondsFormatted(){
        if(this.totalTime >= 3600){
            var totalMinutes = Math.floor(this.totalTime/60)
            var restSeconds = this.totalTime%60
            var totalHours = Math.floor(totalMinutes/60)
            var restMinutes = totalMinutes%60

            return totalHours+'h '+restMinutes+'m '+ restSeconds +'s'
        }
        else if(this.totalTime >= 60){
            var totalMinutes = Math.floor(this.totalTime/60)
            var restSeconds = this.totalTime%60

            return totalMinutes+'m '+restSeconds+'s'
        }else{
            return this.totalTime+'s'
        }
      }
    }
}
</script>