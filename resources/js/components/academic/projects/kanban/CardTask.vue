<template>
    <div class="card card-action mb-4 cursor-pointer" draggable="true" @dragstart="drag" :id="`task${taskSelected.id}`">
    <div class="card-header">
        <div class="card-action-title h5 fw-bold">{{ taskSelected.title }}</div>
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
                    <p class="h5">Actividad padre: {{ taskSelected.fixed_task.fixed_activity.title }}</p>
                    <p class="h6">Producto: {{ taskSelected.fixed_task.fixed_activity.product.title }}</p>
                </div>  
            </p>
        </div>
    </div>
    </div>
    
</template>
<script>
import moment from 'moment'
import {useCounterStore} from '../../../../stores/UserStore'

export default {
    props:{
        task: Object
    },
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
        return {
            time: new Date().toLocaleTimeString(),
            visible: false,
            taskSelected: this.task,
            cronometer: "",
            showCronometer: true,
            subtract: 0,
            stopWatch: ""
        }
    },
    methods:{
        showLocalTime(){
          var time =  this
          var d = new Date();
          d.setHours(0,0,0,0)
          setInterval(() => {
            d.setSeconds(d.getSeconds() + 1)
            time.cronometer = d.toLocaleTimeString()
            this.seconds = d.getTime()
          }, 1000);
        },
        drag(e){  
          this.visible =  true
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
    }   
}
</script>