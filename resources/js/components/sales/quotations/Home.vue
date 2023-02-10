<template>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-1">Cotizaciones</h4>
  <div class="col-xl-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Home</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Lista</button>
        </li>
      </ul>
      <div class="tab-content p-0">
        <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
          
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Ingrese los datos para generar la cotización.</h5>
            </div>
            <div class="card-body">
              
                <div class="row">
                  <div class="col">
                  <!-- <div class="mb-3">
                  <label class="form-label" for="basic-default-fullname">Nombre del cliente</label>
                  <input type="text" v-model="name" class="form-control" id="inputSearchName" @keyup="searchCustomer"/>
                  <table class="table table-bordered mb-3">
                    <tr v-for="customer in customersFiltered" @click="selectCustomer(customer)">{{ customer.name }}</tr>
                  </table>
                  </div> -->
                  <div class="card shadow-none bg-transparent border border-info mb-3"  v-if="customerSelected.id">
                    <div class="card-body">
                    <h5 class="card-title">Cliente: {{ customerSelected.name }} <i @click="deleteCustomerSelected" class='bx bx-trash text-danger cursor-pointer'></i></h5>
                    <p class="card-text">
                      Teléfono: {{ customerSelected.cell }}
                    </p>
                    <p class="card-text">
                      Carrera: {{ customerSelected.career }}
                    </p>
                    <p class="card-text">
                      Universidad: {{ customerSelected.university }}
                    </p>
                    <!-- <p class="card-text">
                      Estado: {{ status[customerSelected.status] }}
                    </p> -->
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
                        <label class="form-label" for="basic-default-company">Validez</label>
                        <p>{{  finalDayMonth }}</p>
                      </div>
                    <!-- <p class="card-text">
                      Estado: {{ status[customerSelected.status] }}
                    </p> -->
                  </div>
                  </div>
                </div>
                
                </div>
                <!-- <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-fullname">Celular</label>
                  <input type="text" v-model="cell" class="form-control" />
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-company">Universidad</label>
                  <input type="text" v-model="university" class="form-control" />
                  </div>
                </div>
                </div> -->
                <!-- <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-fullname">Carrera</label>
                  <input type="text" v-model="career" class="form-control" />
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-company">Grado</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" v-model="grade">
                  <option selected="">Seleccione un grado</option>
                  <option value="1">Pregrado</option>
                  <option value="2">Maestría</option>
                  <option value="3">Doctorado</option>
                </select>
                  </div>
                </div>
                </div> -->
                <h5 class="mb-4">Productos</h5>
                <div class="row">
                  <div class="col-6">
                  <label class="form-label" for="basic-default-company">Nivel</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" v-model="level">
                    <option selected="">Seleccione un nivel</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Producto</label>
                    <input type="text" id="inputSearch" v-model="searchProduct" autocomplete="off" class="form-control" @keyup="search"/>
                    <table class="table table-bordered mb-3">
                      <tr v-for="product in filtered_products">
                        <td class="cursor-pointer" @click="addCart(product)">{{product.title}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead class="table-primary">
                      <tr>
                        <th>Producto/Servicio</th>
                        <th>Descripción</th>
                        <th>Plazo</th>
                        <th>Total</th>
                        <th>Borrar</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr v-for="(product, index) in car_products" :key="index">
                        <td>{{ JSON.parse(product).title }}</td>
                        <td style="white-space: pre-line">{{ product.description }}</td>
                        <td>{{ product.term }}</td>
                        <td>S./ {{ JSON.parse(product).amount }}</td>
                        <td><a @click="removeCart(index)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                    <p>TOTAL:  S./ {{ totalProducts }}</p>
                  </div>
                </div>
                </div>
                <h5 class="mb-4">Producto Sugerido</h5>
                <div class="row">
                  <div class="col-6">
                  <label class="form-label" for="basic-default-company">Nivel</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" v-model="levelSugested">
                    <option selected="">Seleccione un nivel</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Producto</label>
                    <input type="text" id="inputSearch" autocomplete="off" class="form-control" v-model="searchSugestedProduct" @keyup="searchSugested"/>
                    <table class="table table-bordered mb-3">
                      <tr v-for="product in filtered_products_sugested">
                        <td class="cursor-pointer" @click="addCartSuggested(product)">{{product.title}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead class="table-primary">
                      <tr>
                        <th>Producto/Servicio</th>
                        <th>Descripción</th>
                        <th>Plazo</th>
                        <th>Total</th>
                        <th>Borrar</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr v-for="(product, index) in carSugestedProducts" :key="index">
                        <td>{{ JSON.parse(product).title }}</td>
                        <td style="white-space: pre-line">{{ product.description }}</td>
                        <td>{{ product.term }}</td>
                        <td>S./ {{ JSON.parse(product).amount }}</td>
                        <td><a @click="removeSuggestedCart(index)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                    <p>TOTAL: S./ {{ totalSuggestedProducts }}</p>
                  </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                    <p>DESCUENTO: </p>
                    <input type="text" class="form-control" v-model="discount">
                  </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                    <p>TOTAL FINAL: S./ {{ totalProducts - discount }}</p>
                  </div>
                </div>
                </div>
                <button @click="insertQuotation" class="btn btn-primary mt-2 text-white">Guardar</button>
                <button @click="print" target="_blank" id="buttonPDF" class="btn btn-primary mt-2 mx-2 text-white" disabled>Generar PDF</button>
                <button class="btn btn-primary" @click="generatePDF">PDF</button>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
          <List/>
        </div>
      </div>
    </div>
  </div>


      <!-- Basic Layout -->
      <div class="row">
        <div class="col-xl">
          
        </div>
      </div>
      <calcModal @addCartParaphrase="addCartParaphrase"/>
    </div>
</template>
<script>
  import moment from 'moment'
  import List from './List.vue'
  import calcModal from './calcModal.vue'
  export default{
    components:{List, calcModal},
    data(){
      return{
        customers:[],
        customersFiltered:[],
        customerSelected:{},
        discount:0,
        products:[],
        fixed_products:[],
        selected_product:{},
        filtered_products:[],
        filtered_products_sugested:[],
        car_products:[],
        carSugestedProducts:[],
        name: '',
        date:null,
        cell:'',
        searchProduct:'',
        searchSugestedProduct:'',
        university:'',
        career:'',
        grade:0,
        idQuotation:0,
        level: 0,
        levelSugested: 0,
        price: [],
        status:{
          0: 'No atendido',
          1: 'Atendido',
          2: 'Comunicación establecida',
          3: 'Lead',
          4: 'Interesado',
          5: 'Altamente Interesado',
          6: 'Cliente',
          null: 'Stand By'
        }
      }
    },
    methods:{
      generatePDF(){

        const fd =  new FormData()
      
        fd.append('customer', this.customerSelected)
        fd.append('date', this.date)
        fd.append('expirationDay', finalDayMonth)
        fd.append('products', this.car_products)
        fd.append('suggestedProducts', this.suggested_products)
        fd.append('discount', this.discount)

        axios.post('/api/quotationPDF', fd)
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
      },
      selectCustomer(customer){
        this.customerSelected = customer
        this.customersFiltered = []
        this.name = ''
      },
      deleteCustomerSelected(){
        this.customerSelected = {}
      },
      print(e){
            e.preventDefault()
            window.open('/api/generatePDF/'+this.idQuotation)
      },
      insertQuotation(){
        const fd =  new FormData()
      
        fd.append('customer', JSON.stringify(this.customerSelected))
        fd.append('date', this.date)
        fd.append('expirationDay', this.finalDayMonthFormatted)
        fd.append('products', JSON.stringify(this.car_products))
        fd.append('suggestedProducts', JSON.stringify(this.carSugestedProducts))
        fd.append('discount', this.discount)

        axios.post('/api/insertQuotation',fd)
        .then(res =>{
          console.log(res)

          this.idQuotation = res.data.id
          this.$swal('Cotización almacenada correctamente')
          document.getElementById('buttonPDF').disabled = false
        })
        .catch(err =>{
          console.log(err.response.data)
        })
      },
      addCartParaphrase(cost){
        this.selected_product.amount = cost
        this.car_products.push(this.selected_product)
        this.filtered_products = []
        const objWithIdIndex = this.products.findIndex((obj) => obj.id === 41)
        this.products.splice(objWithIdIndex,1)
        document.getElementById('inputSearch').value = ''
        document.getElementById('inputSearch').focus()
      },
      addCart(product){
        if(this.level == 0){
          this.$swal('Selecciona un nivel, por favor')
        }else{
        if(product.id == 41){
          this.selected_product = product
          $('#calcModal').modal('show')
        }else{
          
          this.filtered_products = []
          var selectedProduct = {}

          selectedProduct = product

          let price =  selectedProduct.prices.filter(prices => prices.level == this.level)[0].price

          selectedProduct.id_product = product.id
          selectedProduct.level = this.level
          selectedProduct.amount = price 

          console.log(selectedProduct)
          this.car_products.push(JSON.stringify(selectedProduct))

          this.searchProduct = ''
        }
        }
      },
      addCartSuggested(product){
        if(this.levelSugested == 0){
          this.$swal('Selecciona un nivel en producto sugerido, por favor')
        }else{
        if(product.id == 41){
          this.selected_product = product
          $('#calcModal').modal('show')
        }else{
          
          this.filtered_products_sugested = []
          var selectedProduct = {}

          selectedProduct = product

          let price =  selectedProduct.prices.filter(prices => prices.level == this.level)[0].price

          selectedProduct.id_product = product.id
          selectedProduct.level = this.level
          selectedProduct.amount = price

          this.carSugestedProducts.push(JSON.stringify(selectedProduct))

          this.searchSugestedProduct = ''
        }
        }
      },
      removeCart(product){
        this.car_products.splice(product,1)
        console.log(product)
      },
      removeSuggestedCart(product){
        this.carSugestedProducts.splice(product,1)
        console.log(product)
      },
      searchSugested(e){
        if(e.target.value != ''){
          this.filtered_products_sugested = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
        }else{
          this.filtered_products_sugested = [] 
        }
      },
      search(e){
        if(e.target.value != ''){
          this.filtered_products = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
        }else{
          this.filtered_products = [] 
        }
      },
      searchCustomer(e){
        console.log(e.target.value)
        if(e.target.value != ''){
          this.customersFiltered = this.customers.filter(customer => customer.name.toLowerCase().includes(e.target.value))
        }else{
          this.customersFiltered = [] 
        }
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
      getAllCustomers(){
        this.$swal('Cargando ...')
        axios.get('/api/getAllCustomers')
        .then(res => {
          this.customers = res.data
          if(this.$route.params.idUser != 0){
            this.customerSelected = this.customers.find(customer => customer.id == this.$route.params.idUser)
          }
          this.$swal.close()
        })
      }
    },
    mounted(){
      this.getAllProducts()
      this.getAllCustomers()
    },
    computed:{
      finalDayMonthFormatted(){
        return moment().endOf('month').format('YYYY-MM-DD')
      },
      finalDayMonth(){
        return moment().endOf('month').format('DD/MM/YYYY')
      },
      totalProducts(){
        var total = 0
        this.car_products.forEach((product)=>{
            total += JSON.parse(product).amount
        })

        return Math.round(total * 100)/100
      },
      totalSuggestedProducts(){
        var total = 0
        this.carSugestedProducts.forEach((product)=>{
            total += JSON.parse(product).amount
        })

        return Math.round(total * 100)/100
      }
    }
  }
</script>