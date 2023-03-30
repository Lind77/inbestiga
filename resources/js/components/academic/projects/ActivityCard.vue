<template>
    <div :class="`card ${activity.progresses[0].percentage == 100 ? 'bg-success' : 'bg-danger'} text-white p-3 mb-1`" >
        <div class="card-title d-flex align-items-center justify-content-between mb-0">
            <h5 class="text-white mb-0">{{ activity.title }}</h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" v-bind:checked="activity.progresses[0].percentage == 100" @click="selectActivity(activity)" v-bind:disabled="activity.isCompleted">
            </div>           
        </div>
    </div>
</template>
<script>
    import { userStore } from '../../../stores/UserStore'

    export default {
        setup(){
            const store = userStore()
            return{
                store
            }
        },
        data(){
            return{
                activated: true
            }
        },
        props:{
            activity: Object
        },
        methods:{
            selectActivity(activity){
                this.$emit('selectActivity', activity)
            }
        },
        mounted(){
            
        }
    }
</script>
<style scoped>
    
</style>