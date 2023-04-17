<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Kanban - {{ project.title }} - Tiempo estimado: {{ secondsFormatted }}</h4>
        <div class="row mb-3">
          <div class="col-6">
            <div class="card px-2 py-2">
              <h6>Porcentaje de avance</h6>
              <a href="javascript:void(0)">{{ parseInt(0) + defaultBar }}%</a>
              <div class="progress mb-3">
                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: defaultBar + '%'}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: doneBar + '%' }" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
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
          <dragArea :title="'To Do'" :tasks="toDo" :status="0" @updateTask="updateTask"/>
          <dragArea :title="'Doing'" :tasks="doing" :status="1" @updateTask="updateTask"/>
          <dragArea :title="'Done'" :tasks="done" :status="2" @updateTask="updateTask"/>
        </div>
    </div>  
</template>
<script>
import moment from 'moment'
import CardActivity from './CardActivity.vue'
import CardTask from './CardTask.vue'
import dragArea from './dragArea.vue'
import {userStore} from '../../../../stores/UserStore'

export default {
    components: { CardActivity, CardTask, dragArea },
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    data(){
        return{
            defaultBar: 15,
            doneBar: 0,
            project: [],
            activities: [],
            toDo:[],
            done:[],
            doing:[],
            tasks:[],
            localTime: " ",
            seconds: " ",
            totalTime: '',
            timer: 0,
            interval: null
        }
    },
    methods:{
        startCron(){
          this.interval = setInterval(()=>{
            this.timer++
          }, 1000)
        },
        stopCron(){
          clearInterval(this.interval)
        },
        updateTask(taskId, newStatus){
          var taskSelected = this.tasks.find(task => task.id == taskId)
          var firstStatus = taskSelected.status
          this.removeTask(firstStatus, taskId)
          this.addTask(taskSelected, newStatus)
          this.updateStatus(taskId, newStatus)
          //this.updateProgressTask(taskId) 
          if(newStatus == 2){
            this.updateEndTime(taskId)
            this.incrementBar()
          }
        },
        updateTaskRealTime(taskToUpdate){
          var taskSelected = this.tasks.find(task => task.id == taskToUpdate.id)
          var firstStatus = taskSelected.status
          this.removeTask(firstStatus, taskToUpdate.id)
          taskSelected.progress.owner = taskToUpdate.progress.owner
          console.log(taskSelected.progress.owner)
          let arraysByStatus = {
            0: this.toDo,
            1: this.doing,
            2: this.done
          }
          let arraySelected = arraysByStatus[taskToUpdate.status]
          taskSelected.status = taskToUpdate.status
          arraySelected.push(taskSelected)
        },
        incrementBar(){
          this.doneBar = this.doneBar + (this.toDo.length + this.doing.length + this.done.length)/80
        },
        removeTask(firstStatus, taskId){
          let arraysByStatus = {
            0: this.toDo,
            1: this.doing,
            2: this.done
          }
          let arraySelected = arraysByStatus[firstStatus]
          let index = arraySelected.findIndex(el => el.id == taskId)
          arraySelected.filter(el => el.id == taskId)
        },
        addTask(taskSelected, newStatus){
          console.log(taskSelected, newStatus)
          let arraysByStatus = {
            0: this.toDo,
            1: this.doing,
            2: this.done
          }
          let arraySelected = arraysByStatus[newStatus]
          taskSelected.status = newStatus
          taskSelected.progress.owner = this.store.authUser.name
          arraySelected.push(taskSelected)
        },
        updateStatus(taskId, newStatus){
          const fd = new FormData()

          fd.append('taskId', taskId)
          fd.append('newStatus', newStatus)
          fd.append('owner', this.store.authUser.name)
          axios.post('/api/changeTaskStatus', fd)
          .then(res =>{
            console.log(res)
          })
          .catch(err =>{
            console.error(err)
          })
        },
        updateProgressTask(taskId){
          const fd = new FormData();
          fd.append('id_task', taskId)
          fd.append('owner', this.store.authUser.name)
          fd.append('start_time', new Date())
          axios.post('/api/insertTimeTask', fd)
          .then(res =>{
            console.log(res)
          })
          .catch(err =>{
            console.log(err)
          })
        },
        updateEndTime(taskId){
          const fd = new FormData()
          fd.append('id_task', taskId)
          fd.append('end_time', new Date())
          axios.post('/api/insertEndTimeTask', fd)
          .then(res =>{
              console.log('seteando task en completed') 
          })
          .catch(err =>{
              console.log(err)
          })
        },
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
            this.$swal({
              title: 'Cargando ...',
              showConfirmButton: false,
            });
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
                    if(task.status == 0){
                      this.toDo.push(task)
                    }else if(task.status == 1){
                      this.doing.push(task)
                    }else{
                      this.done.push(task)
                    }
                    /* this.tasks.push(task)
                      if(task.status == 2){
                        nroTasksDone = nroTasksDone + 1
                      } */
                  })
                })
                if(this.percentAcad == 0){
                  this.addPercent()
                }
                console.log(this.done.length*(1/80))
                this.doneBar = this.done.length*(112/80)
                this.$swal().close()
            })
        },
        allowDrop(e){
          e.preventDefault()
        },
        updateSinceRealTime(task){
          console.log('procesando', task)
          var taskInToDo = this.toDo.find(activity => activity.id == task.activity_id)
          var taskInDoing = this.doing.find(activity => activity.id == task.activity_id)

          if(taskInToDo){
            taskInToDo.status = 1
          }else if(taskInDoing){
            taskInToDo.status = 2
          }

        }
    },
    mounted(){
        this.getProjectById(),
        Echo.private('tasks')
        .listen('NewDoing', (e)=>{
          console.log(e.task)
          if(e.task.progress.owner != this.store.authUser.name){
            this.updateTaskRealTime(e.task)
          }
        })
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