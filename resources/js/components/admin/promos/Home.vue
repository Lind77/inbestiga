<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Código de Promoción</h4>
        <div class="d-flex">
            <input type="text" class="form-control w-50" v-model="code">
            <button class="btn btn-primary ms-1" @click="insertCode">Actualizar</button>
        </div>
        <h3>CODIGO ACTUAL: {{ recentCode }}</h3>
    </div>
</template>
<script>
export default {
    data(){
        return{
            code: '',
            recentCode: ''
        }
    },  
    methods:{
        insertCode(){
            axios.get('/api/insertCode/'+ this.code)
            .then((res) =>{
                this.$swal('Codigo insertado')
                this.recentCode = this.code
            })
            .catch((err) =>{
                console.error(err)
            })
        },
        getPromotionCode(){
            axios.get('/api/getPromotionCode')
            .then((res)=>{
            this.recentCode = res.data.code
            })
            .catch((err)=>{
            console.error(err)
            })
        }
    },
    mounted(){
        this.getPromotionCode()
    }
}
</script>
