<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1">Contrato</h4>
    <div class="col-xl-12">
        <div class="alert alert-warning alert-dismissible" role="alert">
          Atención! Los detalles de este contrato están asociados a la última
          <span class="fw-bold cursor-pointer" @click="toQuotation">cotización</span>
          de este cliente
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Verifique los datos para generar el contrato.</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <ClientSection :customerSelected="customerSelected" @getCustomer="getCustomer"/>
            </div>
            <div class="col">
              <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Fecha</label>
                    <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                  </div>
                  <div class="mb-3">
                    <div v-if="countSugestedProducts != 0" class="form-check mt-3">
                    <input @click="considerSugested" class="form-check-input" type="checkbox" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                      Considerar Sugeridos
                    </label>
                  </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
          <SearchProduct :title="'Productos'" @filterNewProducts="filterNewProducts" :newProductsByType="newProductsByType" @callProductModal="callProductModal" />
            
          <div class="table-responsive text-nowrap mt-2" v-show="carNewProducts.length">
        <table class="table table-bordered mb-3">
          <thead class="table-primary">
            <tr>
              <th>Producto/Servicio</th>
              <th>Tipo</th>
              <th>Total</th>
              <th>Borrar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(carNewProduct, index) in carNewProducts">
              <td>{{ carNewProduct.new_product?carNewProduct.new_product.name:carNewProduct.name }}</td>
              <td>{{ carNewProduct.type == 1?'Normal':'Sugerido' }}</td>
              <td>S./{{ carNewProduct.price }}</td>
              <td><a @click="removeSuggestedCart(index)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>

            <div class="row">
                    <div class="col-6">
                      <div class="mb-3">
                        <label class="form-label" for="basic-default-company">Descuento</label>
                        <input type="text" class="form-control" v-model="discount">
                      </div>
                    </div>
                  </div>
                  <div class="row">
        <div class="col-sm-12 col-lg-6">
        <div class="mb-3">
          <h3>TOTAL S./ {{ totalFinal - discount }}</h3>  
        </div>
      </div>
      </div>
            <div class="row">
              <div class="col-xl">
                <h5 class="mb-0">Pagos y entregas <span class="badge bg-label-primary me-1 cursor-pointer" @click="openFeesModal()">+</span></h5>
                <div class="row mt-3">
                  <div class="col-3" v-for="fee in fees">
                    <div class="card shadow-none bg-transparent border border-success p-3">
                      <p class="text-danger cursor-pointer" @click="removeFee(fee.id)"><i class="bx bx-trash"></i></p>
                      <p>Fecha: {{ fee.date }}</p>
                      <p>Monto: S./ {{ fee.amount }}</p>
                      <p>Porcentaje: {{ fee.percentage }} %</p>
                      <p>Avance: {{ fee.advance }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <button @click="insertContract" class="btn btn-primary mt-2 text-white">Guardar</button>
            <a v-if="idContract != 0" :href="`../../api/generateContract/${$route.params.idUser}`" target="_blank" class="btn btn-primary mt-2 mx-2 text-white" disabled>PDF</a>
        </div>
      </div>
    </div>
        <FeesModal @addFee="addFee" :totalFinal="totalFinal - discount"/>
        <ProductModal :newProduct="newProduct" @insertCarProducts="insertCarProducts"/>
  </div>
</template>
<script>
      import conversor from 'conversor-numero-a-letras-es-ar'
      import ClientSection from './ClientSection.vue'
      import FeesModal from './FeesModal.vue'
      import axios from 'axios'
      import moment from 'moment'
      import {userStore} from '../../../stores/UserStore'
      import SearchProduct from './SearchProduct.vue'
      import ProductModal from '../quotations/ProductModal.vue'
      /* import List from './List.vue'
      import PaymentModal from './PaymentModal.vue' */
     /*  import calcModal from './calcModal.vue' */
     /*  import InsertDetail from './InsertDetail.vue' */
      export default{
        setup(){
          const store = userStore()
          return { store }
        },
        components:{ClientSection, FeesModal, SearchProduct, ProductModal},
        data(){
          return{
            customerSelected:{},
            date:null,
            newProductsByType:[],
            carNewProducts:[],
            discount:0,
            newProduct: {},
            newProducts:[],
            fees:[],
            idContract:0,
            quotation:{}
          }
        },
        methods:{
        getCustomer(){
          this.$swal('Cargando ...')
          axios.get('/api/getCustomer/'+this.$route.params.idUser)
          .then(res => {
            this.customerSelected = res.data
            this.$swal.close()
          })
        },
        getQuotation(){
            axios.get(`/api/getQuotationByCustomerId/${this.$route.params.idUser}`)
            .then(res => {
              if(!res.data.msg){
                this.quotation = res.data
                this.carNewProducts = res.data.details
                this.discount = res.data.discount
              }
            })
            .catch(err => { console.error(err)})
        },
        getAllNewProducts(){
          axios.get('/api/getAllNewProducts')
          .then((res)=>{
            this.newProducts = res.data
          })
          .catch((err)=>{
            console.error(err)
          })
        },
        toQuotation(){
          this.$router.push({name:'home-quotation', params:{ idUser: this.customerSelected.id }});
        },
        considerSugested(){
          this.detail_type = (this.detail_type === 1) ? 2 : 1
        },
        removeSuggestedCart(product){
            this.carNewProducts.splice(product,1)
            console.log(product)
        },
        callProductModal(newProduct){
          this.newProduct = newProduct
          $('#productModal').modal('show')
        },
        filterNewProducts(type){
          console.log(type)
          this.newProductsByType = this.newProducts.filter(product => product.type == type)
        },
        openFeesModal(){
          $('#feesModal').modal('show')
        },
        insertContract(){
            if(this.date == null){
              this.$swal('Porfavor, agrega la fecha del contrato')
            }else if(this.totalFinal - this.discount != this.sumTotalFees){
              console.log(this.totalFinal - this.discount, this.sumTotalFees)
              this.$swal('El monto final y el monto de los pagos no coincide')
            }else{
              let conversorClass = conversor.conversorNumerosALetras
              let myConverter = new conversorClass()

              const fd =  new FormData()
              fd.append('quotation_id', this.quotation.id)
              fd.append('amount', parseInt(this.totalFinal))
              fd.append('amount_text',myConverter.convertToText(parseInt(this.totalFinal)))
              fd.append('date', this.date)
              fd.append('fees', JSON.stringify(this.fees))
              fd.append('customer_id', this.$route.params.idUser)
              fd.append('user_id', this.store.authUser.id)
              fd.append('products', JSON.stringify(this.carNewProducts))
              fd.append('emisor_id', this.store.authUser.id)
              axios.post('/api/insertContract', fd)
              .then(res =>{
                this.idContract = res.data
                this.$swal('Contrato generado correctamente')
                document.getElementById('buttonPDF').disabled = false
              })
              .catch(err =>{
                console.log(err)
              })
            }
          },
        insertCarProducts(newProduct){
          console.log(newProduct)
          var newProd = {'id' : newProduct.id, 'name' : newProduct.name, 'type' : newProduct.typeDetail, 'price' : newProduct.priceFinal, 'new_product_id': newProduct.id, 'level' : newProduct.level}
          this.carNewProducts.push(newProd)
        },
        addFee(fee){
          fee.amount = fee.amount
          this.fees.push(fee)
        },
        removeFee(feeId){
        var feedIndex =  this.fees.findIndex(fee => fee.id == feeId)
        this.fees.splice(feedIndex, 1)
        }
        },
        mounted(){
          this.getCustomer()
          this.getQuotation()
          this.getAllNewProducts()
        },
        computed:{
        totalFinal(){
          var total = 0
          this.carNewProducts.forEach((product)=>{
              total += parseFloat(product.price)
          })

          return total
        },
        countSugestedProducts(){
          if(this.quotation.details){
            var numSugested = 0
            this.quotation.details.forEach(detail =>{
              if(detail.type == 2){
                numSugested ++
              }
            })
            return numSugested
          }
        },
        sumTotalFees(){
          var total = 0
          this.fees.forEach((fee)=>{
            total += fee.amount
          })

          return Math.round(total * 100)/100
        }
        }
      }
    </script>