<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4" v-if="user[0]"><span class="text-muted fw-light">Equipo {{user[0].memoir.team.name}} / </span>{{ user[0].name }}</h4>
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Tareas Realizadas</h5>
                    <div class="dropdown">
                    <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="javascript:void(0);">Ultima semana</a>
                        <a class="dropdown-item" href="javascript:void(0);">Ultimo mes</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                    <li class="d-flex mb-4 pb-1 border border-success rounded p-2" v-for="prog in progress">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <small class="text-muted d-block mb-1">{{ prog.progressable.activity.title}}</small>
                            <h6 class="mb-0">{{ prog.progressable.title }}</h6>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <h6 class="mb-0">{{ (Date.parse(prog.end_time) - Date.parse(prog.start_time))/1000 }}</h6>
                            <span class="text-muted">s</span>
                        </div>
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Chart de Productividad</h5>
                    </div>
                    <div class="card-body">
                        <apexchart width="500" type="line" :options="options" :series="series"></apexchart>
                    </div>
                </div>
            </div>             
        </div>
    </div>
</template>
<script>
import VueApexChart from 'vue3-apexcharts'

export default {
    data(){
        return{
            user:{},
            progress:[],
            options: {
                chart: {
                id: 'vuechart-example'
                },
                xaxis: {
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                }
            },
            series: [{
                name: 'series-1',
                data: [30, 40, 45, 50, 49, 60, 70, 91]
            }]
        }
    },
    methods:{
        getUserData(){
            axios.get(`/api/getUserData/${this.$route.params.idUser}`)
            .then(res => {
                this.user = res.data.user
                this.progress = res.data.progress
            })
            .catch(err => {
                console.log(err)
            })
        }
    },
    mounted(){
        this.getUserData()
    }
}
</script>