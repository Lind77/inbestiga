<template>
    <div class="card shadow-none bg-transparent border border-danger p-3 mb-2 cursor-pointer" draggable="true" @dragstart="drag" :id="`${activity.id}`">
        {{ activity.title }}
        <div class="row px-2"  v-for="task in activity.tasks">
            <div v-if="task.status == 0">
                <CardTask :task="task"/>
            </div>
        </div>
    </div>
</template>
<script>
 import {userStore} from '../../../../stores/UserStore'
 import CardTask from './CardTask.vue'


export default {
    components:{CardTask},
    data(){
        return{
            visible: false,
            time: new Date().toLocaleTimeString()
        }
    },
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    props: {
        activity: {
            type: Object
        }
    },
    methods:{         
        drag(e){  
          this.visible =  true
          e.dataTransfer.setData('text', e.target.id)
        }
    }
}
</script>
<style lang="">
    
</style>