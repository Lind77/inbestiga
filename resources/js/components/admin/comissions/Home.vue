<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Comisiones</h4>
        <div class="row">
            <div class="col-md-4" v-for="owner in owners">
                <div class="card mt-1" @click="showCustomers(owner.customers)">
                    <div class="card-header">
                        {{ owner.name }}
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row mt-3" v-if="showClients">
            <h5 class="fw-bold">Clientes</h5>
            <div class="col-md-3" v-for="customer in customers">
                <template v-if="customer.comissions != []">
                    <button class="btn btn-primary w-100 my-2" @click="showComissions(customer)">{{ customer.name || customer.cell }}</button>
                </template>
            </div>
        </div>
    </div>
    <Offcanvas :comissions="comissions"/>
</template>
<script>
import Offcanvas from './Offcanvas.vue'

export default {
    components:{Offcanvas},
    data(){
        return{
            owners: [],
            customers:[],
            showClients: false,
            comissions:[]
        }
    },
    methods:{
        showComissions(customer){
            console.log(customer.comissions)
            this.comissions = customer.comissions
            $('#offcanvasComission').offcanvas('show')
        },
        showCustomers(customers){
            this.showClients =  true
            this.customers = customers
        },
        getAllComissions(){
            axios.get('/api/getAllComissions')
            .then((res) =>{
                this.owners = res.data
            })
            .catch((err) =>{

            })
        }
    },
    mounted(){
        this.getAllComissions()
    }
}
</script>