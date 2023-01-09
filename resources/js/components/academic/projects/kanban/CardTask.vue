<template>
    <div class="card bg-danger p-2 mt-2 w-100 text-white" draggable="true" @dragstart="drag" @dragend="dragend" :id="`task${task.id}`">
            {{ task.title }}
        <div v-if="visible">
            {{ store.authUser[0].name }}
            {{ this.time }}
        </div>
    </div>
</template>
<script>
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
            visible: false
        }
    },
    methods:{
        dragend(e){
            console.log(e.path[1].id)
            
            if(e.path[1].id == "doingArea"){
                document.getElementById(e.target.id).classList.remove('bg-danger')
                document.getElementById(e.target.id).classList.add('bg-warning')
                this.time = new Date().toLocaleTimeString()
                this.visible = true
            }
        }
    }
}
</script>