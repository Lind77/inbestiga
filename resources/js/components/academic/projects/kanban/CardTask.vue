<template>
    <div class="card bg-danger p-2 mt-2 w-100 text-white " draggable="true" @dragstart="drag" @dragend="dragend" :id="`task${taskSelected.id}`">
            {{ taskSelected.title }}
        <div v-if="taskSelected.progress">
            <p>{{ taskSelected.progress[0].owner}} - {{ formattedDate }} - {{ cronometer }}</p>
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
            cronometer: ""
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
        },
        dragend(e){
            console.log(e.path[1].id)
            if(e.path[1].id == "doingArea"){
                document.getElementById(e.target.id).classList.remove('bg-danger')
                document.getElementById(e.target.id).classList.add('bg-warning')
                this.showLocalTime()

                const fd = new FormData();

                    fd.append("id_task", this.task.id)
                    fd.append("owner", this.store.authUser[0].name)
                    fd.append("start_time", new Date())

                axios.post('/api/insertTimeTask', fd)
                .then(res =>{
                    console.log(res)
                    this.taskSelected = res.data.task
                })
                .catch(err =>{
                    console.log(err)
                })
            }
            else if(e.path[1].id == "doneArea"){
                document.getElementById(e.target.id).classList.remove('bg-warning')
                document.getElementById(e.target.id).classList.add('bg-success')
            }
        }
    },
    computed:{
        formattedDate(){
            return moment(this.taskSelected.progress[0].start_time).format('h:mm:ss a')
        }
    }
}
</script>