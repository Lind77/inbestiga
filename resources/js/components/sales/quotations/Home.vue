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
              <h5 class="mb-0">Ingrese los datos para generar el PDF</h5>
            </div>
            <div class="card-body">
              
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-fullname">Nombre del cliente</label>
                  <input type="text" v-model="name" class="form-control" id="basic-default-fullname" />
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-company">Fecha</label>
                  <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                  </div>
                </div>
                </div>
                <div class="row">
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
                </div>
                <div class="row">
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
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
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
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="mb-3">
                  <label class="form-label" for="basic-default-company">Precio</label>
                  {{ price[0]? 'S./ '+price[0].price : '' }}
                  </div>
                </div>
                </div>
                <h5 class="mb-4">Productos</h5>
                <input type="text" id="inputSearch" autocomplete="off" class="form-control" @keyup="search"/>
                <table class="table table-bordered mb-3">
                  <tr v-for="product in filtered_products">
                    <td class="cursor-pointer" @click="addCart(product)">{{product.title}}</td>
                  </tr>
                </table>
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
                      <tr v-for="product in car_products">
                        <td>{{ product.title }}</td>
                        <td style="white-space: pre-line">{{ product.description }}</td>
                        <td>{{ product.term }}</td>
                        <td>S./ {{ product.amount[0]? product.amount[0].price : product.amount }}</td>
                        <td><a @click="removeCart(product)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <button @click="insertQuotation" class="btn btn-primary mt-2 text-white">Guardar</button>
                <button @click="print" target="_blank" id="buttonPDF" class="btn btn-primary mt-2 mx-2 text-white" disabled>Generar PDF</button>
              
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
  import List from './List.vue'
  import calcModal from './calcModal.vue'
  export default{
    components:{List, calcModal},
    data(){
      return{
        products:[],
        selected_product:{},
        filtered_products:[],
        car_products:[],
        name: '',
        date:null,
        cell:'',
        university:'',
        career:'',
        grade:0,
        idQuotation:0,
        level: 0,
        price: []
      }
    },
    methods:{
      print(e){
            e.preventDefault()
            window.open('/api/generatePDF/'+this.idQuotation)
      },
      insertQuotation(){
        const fd = new FormData()
        fd.append('name', this.name)
        fd.append('date', this.date)
        fd.append('cell', this.cell)
        fd.append('university', this.university)
        fd.append('career', this.career)
        fd.append('grade', this.grade)
        fd.append('products', JSON.stringify(this.car_products))

        axios.post('/api/insertQuotation',fd)
        .then(res =>{
          console.log(res)
          this.idQuotation = res.data.id
          alert('Cotización almacenada correctamente')
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
        if(product.id == 41){
          this.selected_product = product
          $('#calcModal').modal('show')
        }else{
        product.amount = product.prices.filter(price => price.level == this.level)
        this.car_products.push(product)
        this.filtered_products = []
        const objWithIdIndex = this.products.findIndex((obj) => obj.id === product.id)
        this.products.splice(objWithIdIndex,1)
        document.getElementById('inputSearch').value = ''
        document.getElementById('inputSearch').focus()

        this.price = product.prices.filter(price => price.level == this.level)
        }
      },
      removeCart(product){
        const objWithIdIndex = this.products.findIndex((obj) => obj.id === product.id)
        this.products.push(product)
        this.car_products.splice(objWithIdIndex,1)
      },
      search(e){
        console.log(e.target.value)
        if(e.target.value != ''){
          this.filtered_products = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
        }else{
          this.filtered_products = [] 
        }
      },
      getAllProducts(){
                axios.get('/api/getAllProducts')
                .then(res =>{
                  this.products = res.data
                  console.log(this.products)
                })
                .catch(err =>{
                  console.log(err.response.data)
                })
      }
    },
    mounted(){
      this.getAllProducts()
    }
  }
</script>