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
                <button class="btn btn-primary w-100 my-2" @click="showComissions(customer.comissions)">{{ customer.name || customer.cell }}</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            owners: [],
            customers:[],
            showClients: false
        }
    },
    methods:{
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