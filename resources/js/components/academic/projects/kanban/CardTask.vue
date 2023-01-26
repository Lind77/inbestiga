<template>
    <div class="card bg-light p-2 mt-2 w-100 text-secondary cursor-pointer" draggable="true" @dragstart="drag" :id="`task${taskSelected.id}`">
        <div class="d-flex justify-content-between flex-wrap align-items-center mb-2 pb-1">
            <div class="item-badges" v-if="taskSelected.activity">
                <div class="badge rounded-pill bg-label-primary" :title="taskSelected.activity.title"> {{ taskSelected.activity.title.substring(0,15)+ '...' }}</div>
            </div>
        </div>
            {{ taskSelected.title }}
        <div v-if="taskSelected.progress && showCronometer== true && taskSelected.status == 1">
            <p class="mb-0">{{ taskSelected.progress.owner }} - {{ formattedDate }}  {{ taskSelected.progress.owner== this.store.authUser[0].name? cronometer : '' }}</p>
        </div>
        <div v-else-if="taskSelected.status == 2">
            <p>{{ taskSelected.progress.owner }} - {{ formattedDate }} - {{ calcStopwatch }}</p>
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