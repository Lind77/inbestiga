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
            <div class="card">
              <h5 class="card-header d-flex align-items-center justify-content-between">
                Codigos de Descuento</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Porcentaje</th>
                        <th>Cantidad</th>
                        <th>Actividad</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr v-for="code in allCodes">
                        <td>{{ code.code }}</td>
                        <td>{{ code.percent }}%</td>
                        <td>{{ code.quantity }}</td>
                        <td>
                          <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" v-model="code.checkbox">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Activo</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
            },
            allCodes:[],
            active: false
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
                this.getAllPromotionsCode()
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
        },
        getAllPromotionsCode(){
          axios.get('/api/getAllPromotionsCode')
          .then((res)=>{
          this.allCodes = res.data
          this.allCodes.forEach((code)=>{
            if(code.able == 1){
              code.checkbox = true
            }
          })
          })
          .catch((err)=>{
          console.error(err)
          })
        }
    },
    mounted(){
        this.getPromotionCode()
        this.getAllPromotionsCode()
    }
}
</script>
