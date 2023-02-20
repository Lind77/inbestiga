<template>
    <div class="modal fade" id="timeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Agregar tiempos en minutos</h5>
                {{ idActivity }}
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col mb-0">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">Tiempo minimo</div>
                        <div class="col-md-4">Tiempo máximo</div>
                    </div>
                    <div class="row align-items-center mt-1" v-for="(time, index) in times" :key="index">
                        <div class="col-4">
                            Nivel {{index+1}}
                        </div>
                        <div class="col-4">
                            <input type="number" v-model="times[index].min_time" class="form-control"/>
                        </div>
                        <div class="col-4">
                            <input type="number" v-model="times[index].max_time" class="form-control"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="saveTimes">Insertar</button>
            </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    props:{
        idActivity: Number
    },
    data(){
        return{
            times: [{min_time: 0, max_time: 0}, {min_time: 0, max_time: 0}, {min_time: 0, max_time: 0}, {min_time: 0, max_time: 0}, {min_time: 0, max_time: 0}] 
        }
    },
    methods:{
        saveTimes(){
            const fd = new FormData()
            fd.append('times', JSON.stringify(this.times))
            fd.append('product_id', this.idActivity)

            axios.post('../api/insertTimes', fd)
            .then(res =>{
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
        }

    }
}
</script>
