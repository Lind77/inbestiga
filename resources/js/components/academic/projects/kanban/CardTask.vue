<template>
    <div class="card card-action mb-4 cursor-pointer" draggable="true" @dragstart="drag" :id="task.id">
    <div class="card-header">
        <div class="card-action-title h5 fw-bold">
            <div class="demo-inline-spacing" v-if="task.status == 1">
                <button type="button" @click="startCron" class="btn rounded-pill btn-icon btn-primary">
                    <span class="tf-icons bx bx-play"></span>
                </button>
                <button type="button" @click="stopCron" class="btn rounded-pill btn-icon btn-secondary">
                    <span class="tf-icons bx bx-pause"></span>
                </button>
                {{ timer }}
                {{ cronometer }}
            </div>
          

            {{ taskSelected.fixed_task.fixed_activity.product.title }}
            <template v-if="taskSelected.status >= 1">
                <span class="h6">{{ taskSelected.progress.owner }}</span> <i class='bx bx-user'></i>
            </template>
        </div>
        <div class="card-action-element">
        <ul class="list-inline mb-0">
            <li class="list-inline-item">
            <a class="card-collapsible" data-bs-toggle="collapse" :href="`#collapseExample${taskSelected.id}`" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="tf-icons bx bx-chevron-up"></i></a>
            </li>
        </ul>
        </div>
    </div>
    <div class="collapse" :id="`collapseExample${taskSelected.id}`">
        <div class="card-body pt-0">
            <p class="card-text">
                <div class="item-badges" v-if="taskSelected.fixed_task.fixed_activity">
                    <p class="h5">Actividad: {{ taskSelected.fixed_task.fixed_activity.title }}</p>
                    <p class="h6">Tarea: {{ taskSelected.fixed_task.title }}</p>
                </div>  
            </p>
        </div>
    </div>
    </div>
    
</template>
<script>
import moment from 'moment'
import {userStore} from '../../../../stores/UserStore'

export default {
    props:{
        task: Object
    },
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    data(){
        return {
            visible: false,
            taskSelected: this.task,
            cronometer: new Date().setHours(0,0,0,0),
            showCronometer: true,
            subtract: 0,
            seconds: 0,
            timer: 0,
            interval: null
        }
    },
    methods:{
        startCron(){
          this.interval = setInterval(()=>{
            this.timer++
            this.cronometer.setSeconds(this.cronometer.getSeconds() + 1)
          }, 1000)
        },
        stopCron(){
          clearInterval(this.interval)
        },
        startCronometer(){
            console.log('iniciando cronometro')
           
            this.interval = setInterval(()=>{
               
                //document.getElementById('cronometer'+id).innerHTML = d.toLocaleTimeString()
            }, 1000)
        },
        stopCronometer(){
            console.log('stopeando cronometer')
            clearInterval(this.interval)
        },
        drag(e){  
          e.dataTransfer.setData('text', e.target.id)
        }
    },
    computed:{
        formattedDate(){
            return moment(this.taskSelected.progress.start_time).format('h:mm a')
        },
        bgCard(){
            if(this.task.status == 0){
                return 'bg-danger'
            }else if(this.task.status == 1){
                return 'bg-warning'
            }else if(this.task.status == 2){
                return 'bg-success'
            }
        },
        calcStopwatch(){
            if(this.taskSelected.status == 2 ){
                var cantStartTime = Date.parse(this.taskSelected.progress.start_time)
                var cantEndTime = Date.parse(this.taskSelected.progress.end_time)

                var totalTime = cantEndTime - cantStartTime

                var totalSeconds = totalTime/1000
                if(totalSeconds >= 3600){
                    var totalMinutes = Math.floor(totalSeconds/60)
                    var restSeconds = totalSeconds%60
                    var totalHours = Math.floor(totalMinutes/60)
                    var restMinutes = totalMinutes%60

                    return totalHours+'h '+restMinutes+'m '+ restSeconds +'s'
                }
                else if(totalSeconds >= 60){
                    var totalMinutes = Math.floor(totalSeconds/60)
                    var restSeconds = totalSeconds%60

                    return totalMinutes+'m '+restSeconds+'s'
                }else{
                    return totalSeconds+'s'
                }

               
            }
        }
    },
    watch:{
        task(){
            this.startCron()
        }
    } 
}
</script>