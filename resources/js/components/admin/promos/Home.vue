<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Código de Promoción</h4>

        <h3>CODIGO ACTUAL: {{ recentCode }}</h3>
        <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
              <div class="d-flex border rounded position-relative pe-0 bg-light">
                <div class="row w-100 m-0 p-3">
                  <div class="col-md-6 col-12 mb-md-0 mb-3 ps-md-0">
                    <p class="mb-2 repeater-title">Codigo</p>
                    <input type="text" class="form-control" v-model="promotion.code">
                  </div>
                  <div class="col-md-3 col-12 mb-md-0 mb-3">
                    <p class="mb-2 repeater-title">Porcentaje</p>
                    <input type="number" class="form-control" v-model="promotion.percent">
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <p class="mb-2 repeater-title">Monto:</p>
                    <input type="number" class="form-control" v-model="promotion.quantity">
                  </div>
                  <div class="col-md-1 col-12 mb-md-0 mb-3">
                    <button class="btn btn-primary btn-sm mt-4" @click="insertCode">Actualizar</button>
                  </div>    
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                  <i class="bx bx-x fs-4 text-muted cursor-pointer" data-repeater-delete=""></i>
                  
                </div>
              </div>
            </div>
        
    </div>
</template>
<script>
export default {
    data(){
        return{
            code: '',
            recentCode: '',
            promotion:{
                code:'',
                percent:0,
                quantity: 0,
                able:1
            }
        }
    },  
    methods:{
        insertCode(){
            const fd = new FormData()
            fd.append('code', this.promotion.code)
            fd.append('percent', this.promotion.percent)
            fd.append('quantity', this.promotion.quantity)
            fd.append('able', this.promotion.able)

            axios.post('/api/insertCode', fd)
            .then((res) =>{
                this.$swal('Codigo insertado')
                this.getPromotionCode()
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
