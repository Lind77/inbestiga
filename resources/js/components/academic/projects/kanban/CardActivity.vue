<template lang="">
    <div class="card bg-danger text-white p-3 mb-2 cursor-pointer" draggable="true" @dragstart="drag" :id="`${activity.id}`">
        {{ activity.title }}
        <div class="card bg-info p-2 w-50 text-white" v-for="task in activity.tasks" draggable="true" @dragstart="drag" :id="`${task.id}`">
            {{ task.title}}
        </div>
        <div v-if="visible">
            {{ store.authUser[0].name }}
        </div>
    </div>
</template>
<script>
 import {useCounterStore} from '../../../../stores/UserStore'

export default {
    data(){
        return{
            visible: false
        }
    },
    setup(){
      const store = useCounterStore()
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