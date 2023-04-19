<template>
    <div class="d-flex justify-content-center">
        <button class="btn btn-success btn-sm" @click="checkQuality(qualityActivity.id)">Aprobar</button>
        <button class="btn btn-danger btn-sm ms-2" @click="sendRejectObservations">Rechazar</button>
    </div>
    <div v-show="showField">
        <textarea class="form-control mt-2 mb-1" cols="3" rows="4" v-model="reject"></textarea>
        <button class="btn btn-danger btn-sm" @click="sendReject(qualityActivity.id)">Enviar</button>
    </div>
    
    <!-- <div class="form-check">
        <input class="form-check-input form-control-lg"  type="checkbox" v-model="isChecked" :id="`disabledCheck${qualityActivity.id}`">
    </div> -->
    <RejectModal/>
</template>
<script>
import { userStore } from '../../../stores/UserStore'
import axios from 'axios'

    export default {
        setup(){
            const store = userStore()
                return{
                    store
                }
        },
        data(){
            return{
                isChecked: false,
                showField: false,
                reject: ''
            }
        },
        props:{
            qualityActivity:Object
        },
        methods:{
            checkQuality(id){
                    this.$emit('checkQuality',id)
            },
            uncheckQuality(id){
                    this.$emit('uncheckQuality',id)
            },
            sendRejectObservations(){
                this.showField = !this.showField
            },
            sendReject(id){
                const fd = new FormData()
                fd.append('emisor_id', this.store.authUser.id)
                fd.append('project_id', this.qualityActivity.project_id)
                fd.append('title', this.qualityActivity.title)
                fd.append('extra', this.reject)
                axios.post('/api/insertReject', fd)
                .then((res) =>{
                    console.log(res)
                    this.showField = false
                    this.reject = ''
                })
                .catch((err) =>{
                    console.log(err)
                })

                this.$emit('rejectQuality', id)
            }
        },
        mounted(){
            if(this.qualityActivity.progress == 100){
                this.isChecked = true
            }
        }
    }
</script>