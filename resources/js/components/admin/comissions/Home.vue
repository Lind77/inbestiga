<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Comisiones</h4>
        <div class="row">
            <div class="col-md-4" v-for="owner in owners">
                <div class="card mt-1">
                    <div class="card-header">
                        {{ owner.name }}
                    </div>
                    <div class="card-body">
                        <template v-if="owner.referal != '-'">
                            <button class="btn btn-primary mx-2 my-2" v-for="customer in owner.customers">{{ customer.name || customer.cell }}</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            owners: []
        }
    },
    methods:{
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