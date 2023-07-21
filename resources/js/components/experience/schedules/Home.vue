<template>
   <!--  <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Mis Horarios de Reunión </h4>
        <div class="row mb-3">
            <h6>Recientes</h6>
            <div class="col-md-4" v-for="lead in todayLeads">
                <div class="card bg-danger my-3">
                    <div class="card-header text-white"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" v-for="lead in myLeads">
                <div class="card bg-success my-3">
                    <div class="card-header text-white"></div>
                </div>
            </div>
        </div>
    </div> -->
</template>
<script>
/* import { userStore } from '../../../stores/UserStore' */

export default {
 /*    setup() {
        const store = userStore()
        return { store }
    },
    data() {
        return {
            mySchedules: [],
            todayScheudle: []
        }
    },
    methods: {
        getAllMyLeads() {
            axios.get('/api/getAllMyLeads/' + this.store.authUser.id)
                .then((res) => {
                    this.myLeads = res.data.customers
                    this.todayLeads = res.data.customersToday
                })
                .catch((err) => {

                })
        }
    },
    mounted() {
        this.getAllMySchedules()
    } */
}
</script>
<style lang="">
    
</style>