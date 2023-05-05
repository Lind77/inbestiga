<template>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-1">Cotización</h4>
  <div class="col-xl-12">
    <div v-if="customer.needs" class="alert alert-success alert-dismissible" role="alert">
      <h5 class="fw-bold text-success">Necesidades del cliente</h5>
        {{ customer.needs }}
      </div>
    <div class="card">
      <div class="card-header">
        <h5>Ingrese los datos para generar la cotización.</h5>
        <div class="alert alert-warning alert-dismissible mb-0" role="alert" v-if="!customer.quotations || !customer.quotations.length">
          El usuario actual no posee una cotización
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <CustomerCard :customerSelected="customer"/>
          </div>
          <div class="col-6">
            <div class="card shadow-none bg-transparent border border-info mb-3">
              <div class="card-body">
                  <div class="mb-0">
                  <label class="form-label" for="basic-default-company">Fecha <span class="text-danger">*</span></label>
                  <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                  </div>
                  <div class="mb-0">
                  <label class="form-label" for="basic-default-company">Validez <span class="text-danger">*</span></label>
                  <input type="date" v-model="dateValidate" class="form-control" id="basic-default-company" />
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

        <div class="row" v-show="carNewProducts.length">
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label" for="basic-default-company">Descuento</label>
              <input type="text" class="form-control" v-model="discount">
            </div>
          </div>
        <div class="col-6">
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">Tiempo de Ejecucion <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="term">
          </div>
        </div>
        </div>
        <div class="footer-quotation" v-show="carNewProducts.length">
          <div class="row">
          <div class="col-sm-12 col-lg-6">
          <div class="mb-3">
            <h3>TOTAL S./ {{ totalProducts - discount }}</h3>  
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-lg-6">
            <label class="form-label" for="basic-default-company">Nota</label>
            <input type="text" class="form-control" v-model="note">
          </div>
        </div>
        <div class="row d-flex justify-content-center ">
          <button @click="insertQuotation" class="btn btn-primary btn-lg mt-2 text-white w-25">Guardar</button>
          <router-link v-if="idQuotation != 0" :to="{name:'quotation-file', params:{ id: this.idQuotation }}" target="_blank" class="btn btn-primary btn-lg mt-2 mx-2 text-white w-25" disabled>Imprimir</router-link>
        </div>
        </div>
        
      </div>
    </div>
  </div> 
      <calcModal @addCartModal="addCartModal"/>
      <InsertDetail @addCartModal="addCartModal" @addSugestCartModal="addSugestCartModal" :product="selected_product" :products="fixed_products"/>
      <ProductModal :newProduct="newProduct" @insertCarProducts="insertCarProducts"/>
</div>
</template>
<script>
  import moment from 'moment'
  import CustomerCard from './CustomerCard.vue'
  import DateCard from './DateCard.vue'
  import calcModal from './calcModal.vue'
  import InsertDetail from './InsertDetail.vue'
  import SearchProduct from './searchProduct.vue'
  import ProductModal from './ProductModal.vue'
  import { userStore } from '../../../stores/UserStore'
  
  export default{
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    components:{ calcModal, InsertDetail, CustomerCard, DateCard, SearchProduct, ProductModal },
    data(){
      return{
        customer: {},
        date:'',
        dateValidate:'',
        newProductsByType:[],
        carNewProducts:[],
        newProduct: {},
        discount:0,
        note:'',
        idQuotation:0,
        fixed_products:[],
        selected_product:{},
        newProducts:[],
        term:''
      }
    },
    methods:{
      getUser(){
        axios.get('/api/getCustomer/'+this.$route.params.idUser)
        .then((res)=>{
         this.customer = res.data
          if(this.customer.quotations[0]){
            this.idQuotation = this.customer.quotations[0].id
            this.date = this.customer.quotations[0].date
            this.dateValidate = this.customer.quotations[0].expiration_date
            this.discount = this.customer.quotations[0].discount
            this.term = this.customer.quotations[0].term
            this.note = this.customer.quotations[0].note
            this.customer.quotations[0].details.forEach(detail =>{
            this.carNewProducts.push(detail)
            })
          }
        })
        .catch((err)=>{
          console.log(err)
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
      },
      filterNewProducts(type){
        console.log(type)
        this.newProductsByType = this.newProducts.filter(product => product.type == type)
      },
      callProductModal(newProduct){
        this.newProduct = newProduct
        $('#productModal').modal('show')
      },
      removeSuggestedCart(product){
        this.carNewProducts.splice(product,1)
        console.log(product)
      },
      insertQuotation(){
        if(this.customer.quotations[0]){
          this.updateQuotation(this.customer.quotations[0].id)
        }else{
          this.createQuotation()
        }
      },
      updateQuotation(quotationId){
        const fd =  new FormData()
          
        fd.append('quotation_id',quotationId)
        fd.append('date', this.date)
        fd.append('expirationDay', this.dateValidate)
        fd.append('amount', this.totalProducts - this.discount)
        fd.append('discount', this.discount)
        fd.append('term', this.term)
        fd.append('products', JSON.stringify(this.carNewProducts))
        fd.append('emisor_id', this.store.authUser.id)

        axios.post('/api/updateQuotation', fd)
        .then((res)=>{
          this.$swal('Cotización actualizada correctamente')
          this.idQuotation = res.data.id
        })
        .catch((err)=>{
          console.log(err)
        })
      },
      createQuotation(){
        const fd =  new FormData()

        fd.append('user_id', this.store.authUser.id)
        fd.append('customer_id', this.customer.id)
        fd.append('date', this.date)
        fd.append('expirationDay', this.dateValidate)
        fd.append('amount', this.totalProducts - this.discount)
        fd.append('discount', this.discount)
        fd.append('term', this.term)
        fd.append('products', JSON.stringify(this.carNewProducts))
        fd.append('emisor_id', this.store.authUser.id)

        axios.post('/api/insertQuotation', fd)
        .then((res)=>{
          this.$swal('Cotización insertada correctamente')
          this.idQuotation = res.data.id
        })
        .catch((err)=>{
          console.log(err)
        })
      },
      addCartModal(product){
        this.car_products.push(JSON.stringify(product))
        this.filtered_products = []
        this.searchProduct = ''
      },
      addSugestCartModal(product){
        this.carSugestedProducts.push(JSON.stringify(product))
        this.filtered_products_sugested = []
        this.searchSugestedProduct = ''
      },
      getNewProducts(){
        axios.get('/api/getNewProductsById/'+this.$route.params.idUser)
        .then((res)=>{
         this.carNewProducts = res.data
        })
        .catch((err)=>{
          console.log(err)
        })
      },
      insertCarProducts(newProduct){
        console.log(newProduct)
        var newProd = {'id' : newProduct.id, 'name' : newProduct.name, 'type' : newProduct.typeDetail, 'price' : newProduct.priceFinal, 'new_product_id': newProduct.id, 'level' : newProduct.level}
        this.carNewProducts.push(newProd)
      }
    },
    mounted(){
      this.getUser()
      this.getAllNewProducts()
    },
    computed:{
      totalProducts(){
        var total = 0
        this.carNewProducts.forEach((product)=>{
            total += parseFloat(product.price)
        })
        return total.toFixed(2)
      }
    }
  }
</script>