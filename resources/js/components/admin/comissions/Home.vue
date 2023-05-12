<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Comisiones</h4>
    </div>
</template>
<script>
export default {
    methods:{
        getAllComissions(){
            axios.get('/api/getAllComissions')
            .then((res) =>{
                console.log(res)
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