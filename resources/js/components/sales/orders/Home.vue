<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1">Orden de Servicio</h4>
      <div class="alert alert-warning alert-dismissible" role="alert">
            Atención! Los detalles de esta orden están asociados a la 
            <span class="fw-bold cursor-pointer" @click="toQuotation">cotización</span> 
            del cliente
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Verifique los datos para generar la orden de servicio.</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="card shadow-none bg-transparent border border-info mb-3"  v-if="customerSelected.id">
                <div class="card-body">
                <h5 class="card-title">Cliente: {{ customerSelected.name }}</h5>
                <p class="card-text">
                  Teléfono: {{ customerSelected.cell }}
                </p>
                <p class="card-text">
                  Carrera: {{ customerSelected.career }}
                </p>
                <p class="card-text">
                  Universidad: {{ customerSelected.university }}
                </p>
                <p class="card-text">
                  <div v-if="customerSelected.dni == null">
                    <label for="">DNI</label>
                    <input type="text" class="form-control" v-model="dni">
                  </div>
                  <div v-else>
                    DNI: {{ customerSelected.dni }}
                  </div>
                  <button v-if="customerSelected.dni == null" class="btn btn-success btn-sm mt-2" @click="saveDni"> Guardar DNI</button>
                </p>
              </div>
              </div>
          </div>
          <div class="col">
            <div class="card shadow-none bg-transparent border border-info mb-3">
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label" for="basic-default-company">Fecha</label>
                  <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                </div>
                <div class="mb-3">
                  <div v-if="areSuggesteds" class="form-check mt-3">
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

          <div class="table-responsive text-nowrap" v-show="carNewProducts.length">
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
              <label class="form-label" for="basic-default-company">Entrega Final</label>
              <textarea class="form-control" v-model="final_delivery"></textarea>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label" for="basic-default-company">Observaciones</label>
              <textarea class="form-control" v-model="observations"></textarea>
            </div>
          </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label" for="basic-default-company">Descuento</label>
                <input type="text" class="form-control" v-model="discount">
              </div>
            </div>
            <div class="col-6">
            <div class="mb-3">
              <label class="form-label" for="basic-default-company">TOTAL FINAL:</label>
              <br>
              S./ {{ totalFinal }}
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl">
              <h5 class="mb-0">Pagos <span class="badge bg-label-primary me-1 cursor-pointer" @click="openPaymentModal">+</span></h5>
              <div class="row mt-3">
                <div class="col-3" v-for="payment in payments">
                  <div class="card shadow-none bg-transparent border border-success p-3">
                    <p class="text-danger cursor-pointer" @click="removePayment(payment.id)"><i class="bx bx-trash"></i></p>
                    <p>Fecha: {{ payment.date }}</p>
                    <p>Monto: S./ {{ payment.amount }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button @click="insertOrder" class="btn btn-primary mt-2 text-white">Guardar</button>
          <router-link v-if="idOrder != 0" :to="{name:'order-file', params:{ id: idOrder }}" target="_blank" class="btn btn-primary mt-2 mx-2 text-white" disabled>Imprimir</router-link>
        </div>
      </div>
    <PaymentModal @addPayment="addPayment"/>
    <ProductModal :newProduct="newProduct" @insertCarProducts="insertCarProducts"/>
  </div>
</template>
    <script>
      import axios from 'axios'
      import moment from 'moment'
      import List from './List.vue'
      import PaymentModal from './PaymentModal.vue'
      import SearchProduct from './SearchProducts.vue'
      import { userStore } from '../../../stores/UserStore'
      import ProductModal from '../quotations/ProductModal.vue'
     
      export default{
        setup(){
          const store = userStore()
          return { store }
        },
        components:{List, PaymentModal, SearchProduct, ProductModal},
        data(){
          return{
            newProductsByType:[],
            customerSelected:{},
            date:null,
            details:[],
            final_delivery:'',
            observations:'',
            discount:0,
            payments: [],
            idOrder:0,
            quotation: {},
            detail_type: 1,
            newProduct:{},
            carNewProducts:[]
          }
        },
        methods:{
          removeSuggestedCart(product){
        this.carNewProducts.splice(product,1)
        console.log(product)
      },
          insertCarProducts(newProduct){
        console.log(newProduct)
        var newProd = {'id' : newProduct.id, 'name' : newProduct.name, 'type' : newProduct.typeDetail, 'price' : newProduct.priceFinal, 'new_product_id': newProduct.id, 'level' : newProduct.level}
        this.carNewProducts.push(newProd)
      },
          filterNewProducts(type){
        console.log(type)
        this.newProductsByType = this.newProducts.filter(product => product.type == type)
      },
      callProductModal(newProduct){
        this.newProduct = newProduct
        $('#productModal').modal('show')
      },
          toQuotation(){
            this.$router.push({name:'home-quotation', params:{ idUser: this.customerSelected.id }});
          },
          saveDni(){
            const fd = new FormData()
            fd.append('id_customer', this.$route.params.idUser)
            fd.append('dni', this.dni)

            axios.post('/api/updateDniCustomer', fd)
            .then((res) =>{
              this.customerSelected = res.data
            })
            .catch((err)=>{
              console.error(err.data.message)
            })
          },
          considerSugested(){
            this.detail_type = (this.detail_type === 1) ? 2 : 1
          },
          removePayment(paymentId){
            var indexPayment = this.payments.findIndex(payment => payment.id == paymentId)
            this.payments.splice(indexPayment, 1)
          },
          addPayment(payment){
            this.payments.push(payment);
          },
          openPaymentModal(){
            $('#paymentModal').modal('show')
          },
          insertOrder(){
            var sumTotalPayments = 0
            this.payments.forEach(payment =>{
              sumTotalPayments += parseFloat(payment.amount)
            })
            if(this.totalFinal != sumTotalPayments){
              this.$swal('El monto final y el monto de los pagos no coincide')
            }
            else if(this.date == null){
              this.$swal('Porfavor agregar la fecha de cotización')
            }else{
              const fd =  new FormData()
          
            fd.append('quotation_id', this.quotation.id)
            fd.append('final_delivery', this.final_delivery)
            fd.append('observations', this.observations)
            fd.append('suggested', this.detail_type)
            fd.append('payments', JSON.stringify(this.payments))
            fd.append('discount', this.discount)
            fd.append('customer_id', this.$route.params.idUser)
            fd.append('user_id', this.store.authUser.id)
    
            axios.post('/api/insertOrder',fd)
            .then(res =>{
              console.log(res)
    
              this.idOrder = res.data
              this.$swal('Orden almacenada correctamente')
              document.getElementById('buttonPDF').disabled = false
            })
            .catch(err =>{
              console.error(err)
            })
            } 
          },
          getUser(){
            axios.get('/api/getCustomer/'+this.$route.params.idUser)
            .then(res =>{
              this.customerSelected = res.data
            })
          },
          getAllProducts(){
            axios.get('/api/getAllProducts')
            .then(res =>{
              this.products = res.data
              this.fixed_products = res.data
            })
            .catch(err =>{
              console.log(err.response.data)
            })
          },
          getQuotation(){
            axios.get(`/api/getQuotationByCustomerId/${this.$route.params.idUser}`)
            .then(res => {
              console.log(res.data)
              this.quotation = res.data
              var dateConverted = moment(res.data.order.updated_at).format('YYYY-MM-DD')
              this.date = dateConverted
              this.final_delivery = res.data.order.final_delivery
              this.observations = res.data.order.observations
              this.details = res.data.details
              this.discount = res.data.discount
              this.payments = res.data.order.payments
            })
            .catch((err) => { 
              console.error(err)
            })
          },
          getAllNewProducts(){
        axios.get('/api/getAllNewProducts')
        .then((res)=>{
          this.newProducts = res.data
        })
        .catch((err)=>{
          console.error(err)
        })
      }
        },
        mounted(){
          this.getUser()
          this.getAllNewProducts()
          this.getQuotation()
        },
        computed:{
          areSuggesteds(){
            var suggestedProduct = this.details.find(detail => detail.type == 2)

            if(suggestedProduct){
              return true
            }else{
              return false
            }
          },
          totalFinal(){
            var sumMonto = 0
            if(this.detail_type == 1){
              this.details.forEach(detail =>{
                  if(detail.type == 1){
                    sumMonto += parseFloat(detail.price)
                  }
              })
              return parseFloat(sumMonto).toFixed(0) - parseFloat(this.discount).toFixed(0)
            }else{
              this.details.forEach(detail =>{
                  if(detail.type <= 2){
                    sumMonto += parseFloat(detail.price)
                  }
              })
              return parseFloat(sumMonto).toFixed(0) - parseFloat(this.discount).toFixed(0) 
            }
          },
          totalProducts(){
            var total = 0
            this.car_products.forEach((product)=>{
                total += JSON.parse(product).total
            })
    
            return Math.round(total * 100)/100
          }
        }
      }
    </script>