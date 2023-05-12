<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Comisiones</h4>
        <div class="row">
            <div class="col-md-4" v-for="comission in comissions">
                <div class="card mt-1">
                    <div class="card-header">
                        {{ comission.user_id }}
                    </div>
                    <div class="card-body">
                        {{ comission.user.name }}
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
            comissions: []
        }
    },
    methods:{
        getAllComissions(){
            axios.get('/api/getAllComissions')
            .then((res) =>{
                this.comissions = res.data
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