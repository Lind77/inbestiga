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
                        <button class="btn btn-primary mx-2 my-2" v-for="comission in owner.comissions">{{ comission.customer.name }}</button>
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