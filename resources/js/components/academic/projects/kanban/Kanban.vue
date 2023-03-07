<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Kanban - {{ project.title }} - {{ secondsFormatted }}</h4>
        <div class="row mb-3">
          <div class="col-6">
            <div class="card px-2 py-2">
              <h6>Porcentaje de avance</h6>
              <a href="javascript:void(0)">{{ parseInt(percentAcad) +15 }}%</a>
              <div class="progress mb-3">
                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: percentAcad + '%' }" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
              <!--  <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div> -->
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card px-2 py-2">
              <h6>Indicaciones adicionales</h6>
              <p>{{ project.aditional }}</p>
            </div> 
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4 pb-3" id="todoArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold">
              <h4>To Do</h4>
            </div>
            <div class="container-cards">
              <div v-for="task in tasks">
                <div v-if="task.status == 0">
                  <CardTask :task="task"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 pb-3" id="doingArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold">
              <h4>Doing</h4>
            </div>
            <div class="container-cards">
              <div v-for="task in tasks">
                <div v-if="task.status == 1">
                  <CardTask :task="task"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 pb-3" id="doneArea" @drop="drop" @dragover="allowDrop">
            <div class="kanban-header fw-bold">
              <h4>Done</h4>
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
        addPercent(){
          var nroTasksDone = 0
          this.activities.forEach((activity) =>{
            activity.tasks.forEach((task) =>{
              if(task.status == 2){
                nroTasksDone = nroTasksDone + 1
              }
            })
          })
          this.percentAcad = this.percentAcad + (80/this.tasks.length)*nroTasksDone
        },
        getProjectById(){
            axios.get(`/api/getProjectById/${this.$route.params.idProject}`)
            .then(res =>{
                this.tasks = []
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
                if(this.percentAcad == 0){
                  this.addPercent()
                }
            })
        },
        allowDrop(e){
          e.preventDefault()
        },
        drop(e){
          e.preventDefault()
          if(this.store.rol == 'Acad'){ 
          var data = e.dataTransfer.getData('text')
          //e.target.appendChild(document.getElementById(data))

          if(e.target.id == 'doingArea'){
            this.$swal({
                  title: 'Asignando Tarea ...'  
            });
            axios.get(`/api/verifyOwner/${data.substr(4,6)}`)
            .then(res =>{
              console.log(res.data)
              if(res.data.owner != null){
                this.$swal({
                  title: 'Esta tarea ya ha sido elegida por un InBESTigador'  
                });
                this.getProjectById()
              }else{

                const fd = new FormData();

                fd.append("id_task", res.data.progressable_id)
                fd.append("owner", this.store.authUser[0].name)
                fd.append("start_time", new Date())

                axios.post('/api/insertTimeTask', fd)
                .then(res =>{
                  this.getProjectById()
                })
                .catch(err =>{
                console.log(err)
                })
              }
            })
            .catch(err =>{
              console.log(err)
            })
          }
          
          if(e.target.id == 'doneArea'){
            
            const fd = new FormData();

                fd.append("id_task", data.substr(4,6))
                fd.append("end_time", new Date())

            axios.post('/api/insertEndTimeTask', fd)
            .then(res =>{
                console.log('seteando task en completed')
                this.taskSelected = res.data.task
                this.getProjectById()
                this.addPercent()   
            })
            .catch(err =>{
                console.log(err)
            })
          }
          }else{
            this.$swal('Usted no tiene permisos para modificar las tareas')
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
<style>
.vh-75{
  height: 75vh;
}
</style>