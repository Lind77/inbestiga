<template>
    <div class="modal fade" id="qualityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Indicadores de calidad</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <h6>Porcentaje de avance</h6>
                    <a href="javascript:void(0)">{{ 95 }}%</a>
                    <div class="progress mb-3 w-100">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: 15 + '%'}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: 80 + '%' }" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated shadow-none" role="progressbar" :style="{width: qualityBar + '%' }" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-3" v-for="qualityActivity in qualityActivities">
                        <div class="card shadow-none bg-transparent border border-secondary mb-3">
                            <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">{{ qualityActivity.title }}</h5>
                            <div class="form-check p-0">
                                <template v-if="qualityActivity.progress == 0">
                                    <checkQuality :qualityActivity="qualityActivity" @checkQuality="checkQuality" @uncheckQuality="uncheckQuality" @rejectQuality="rejectQuality"/>
                                </template>
                                <template v-else-if="qualityActivity.progress == 50">
                                    <div class="d-flex justify-content-center">
                                        <p class="text-danger mb-0">!! Pendiente de Rectificación</p>
                                    </div>
                                    <checkQuality :qualityActivity="qualityActivity" @checkQuality="checkQuality" @uncheckQuality="uncheckQuality" @rejectQuality="rejectQuality"/>
                                </template>
                                <template v-else>
                                    <i class='bx bx-check-circle text-success'></i>
                                </template>

                                <!-- <input class="form-check-input form-control-lg" @click="checkQuality(qualityActivity.id)" type="checkbox" v-model="isChecked" :id="`disabledCheck${qualityActivity.id}`"> -->
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-success btn-xl" v-bind:disabled="endProject">Finalizar proyecto</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import CheckQuality from './CheckQuality.vue'
export default {
    components: {CheckQuality},
    props:{
        qualityActivities: Array
    },
    data(){
        return{
            qualityBar: 0,
            endProject: true
        }
    },
    methods:{
        rejectQuality(id){
            var activitySelected = this.qualityActivities.find(activity => activity.id == id)
            activitySelected.progress = 50
        },
        checkQuality(id){
            var activitySelected = this.qualityActivities.find(activity => activity.id == id)
            activitySelected.progress = 100
            axios.get('/api/updateQualityActivity/'+id)
            .then((res)=>{

            })
            .catch((err)=>{

            })
            this.qualityBar += 1.25
            if(this.qualityBar >= 5){
                this.endProject = false
            }
        },
        uncheckQuality(id){
            axios.get('/api/removeQualityActivity/'+id)
            .then((res)=>{

            })
            .catch((err)=>{

            })
            this.qualityBar -= 1.25
        },
        chargingBar(){
            this.qualityBar = 0
            if(this.qualityActivities.length != 0){
                this.qualityActivities.forEach((activity)=>{
                if(activity.progress == 100){
                    this.qualityBar += 1.25
                }
            })
            }
        }
    },
    watch:{
        qualityActivities(){
            this.chargingBar()
        }
    }
}
</script>
