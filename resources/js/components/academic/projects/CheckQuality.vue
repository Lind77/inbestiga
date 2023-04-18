<template>
    <div class="d-flex justify-content-center">
        <button class="btn btn-success btn-sm" @click="checkQuality(qualityActivity.id)">Aprobar</button>
        <button class="btn btn-danger btn-sm ms-2" @click="sendRejectObservations">Rechazar</button>
    </div>
    <div v-show="showField">
        <textarea class="form-control mt-2 mb-1" cols="3" rows="4"></textarea>
        <button class="btn btn-danger btn-sm">Enviar</button>
    </div>
    
    <!-- <div class="form-check">
        <input class="form-check-input form-control-lg"  type="checkbox" v-model="isChecked" :id="`disabledCheck${qualityActivity.id}`">
    </div> -->
    <RejectModal/>
</template>
<script>
    export default {
        data(){
            return{
                isChecked: false,
                showField: false
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
            }
        },
        mounted(){
            if(this.qualityActivity.progress == 100){
                this.isChecked = true
            }
        }
    }
</script>