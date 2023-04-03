<template>
    <div :class="`card ${activity.isCompleted?'bg-success':'bg-danger'} text-white p-3 mb-1`" >
        <div class="card-title d-flex align-items-center justify-content-between mb-0">
            <h5 class="text-white mb-0">{{ activity.title }}</h5>
                <div class="form-check" v-show="mustShowCheckbox">
                    <input class="form-check-input" type="checkbox" id="checkbox" v-model="activity.isCompleted" @click="handleCheck(activity, $event)"/>
                </div>   
        </div>
    </div>  
    
</template>
<script>
    import axios from 'axios'
    import { userStore } from '../../../stores/UserStore'
    

    export default {
        emits:['selectActivity', 'unselectActivity', 'checkActivity'],
        setup(){
            const store = userStore()
            return{
                store
            }
        },
        data(){
            return{
                isChecked: false,
                bgColor: ''
            }
        },
        props:{
            activity: Object,
            project_selected: Object
        },
        methods:{
            handleCheck(activity, e){
                if(activity.fixed_activity_id == 5 || activity.fixed_activity_id == 8){
                    this.$emit('checkActivity', activity)
                }else{
                    e.preventDefault()
                    this.$emit('checkActivity', activity)
                }
               /*  if(activity.fixed_activity_id == 7){
                    $('#firstMeetModal').modal('show')
                } */

                /* var selectActivityByFixed = {
                    1 : ''
                }

                const checkbox = e.target
                    if (checkbox.checked) {
                        $('#teamModal').modal('show')
                        this.checkActivity()
                    } else {
                        this.uncheckActivity()
                    } */
            },
            checkActivity(activityId){
                console.log('checkeando activity nani', activityId)
                this.bgColor = 'bg-success'
                this.isChecked = true
                console.log(this.bgColor)
                    //this.updateActivityProgress(activityId)     
            },
            uncheckActivity(){
                console.log('has desmarcado la actividad', this.activity)
                this.bgColor = 'bg-danger'
                this.removeActivitiyProgress(this.activity.id)
                this.$emit('unselectActivity', this.activity.id)
            },
            updateActivityProgress(activityId){
                axios.get('/api/updateActivityProgress/'+ activityId)
                .then(res =>{   
                    console.log('progreso actualizado de la actividad')
                })
                .catch(err =>{

                })
            },
            removeActivitiyProgress(activityId){
                axios.get('/api/removeActivityProgress/'+ activityId)
                .then(res =>{
                    console.log('eliminando progreso de la actividad')
                })
                .catch(err =>{

                })
            }
        },
        mounted(){
            if(this.activity.progresses[0].percentage == 100){
                this.bgColor = 'bg-success'
                this.isChecked = true
            }else{
                this.bgColor = 'bg-danger'
            }
        },
        computed:{
            mustShowCheckbox(){
                if (this.store.authUser.roles[0].name == 'Experience' && this.activity.fixed_activity_id != 6) {
                    return true
                } else if (this.store.authUser.roles[0].name == 'AdminAcad' && this.activity.fixed_activity_id == 6) {
                    return true
                } else {
                    return false
                }
            },
            checked(){
                return this.isChecked
            }
        }
    }
</script>
<style scoped>
    
</style>