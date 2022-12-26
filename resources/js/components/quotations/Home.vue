<template>
<div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Formulario/</span> Cotizaciones</h4>

      <!-- Basic Layout -->
      <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
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
                <h5 class="mb-4">Productos</h5>
                <input type="text" id="inputSearch" autocomplete="off" class="form-control" @keyup="search"/>
                <table class="table table-bordered mb-3">
                  <tr v-for="product in filtered_products">
                    <td class="cursor-pointer" @click="addCart(product)">{{product.title}} - S./ {{product.amount}}</td>
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
                        <td>{{ product.amount }}</td>
                        <td><a @click="removeCart(product)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <button @click="insertQuotation" class="btn btn-primary mt-2 text-white">Guardar</button>
                <button @click="print" target="_blank" id="buttonPDF" class="btn btn-primary mt-2 mx-2 text-white" disabled>Generar PDF</button>
              
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
  import Sidebar from '../layout/Sidebar.vue'
  import Navbar from '../layout/Navbar.vue'
  export default{
    components: { Sidebar, Navbar },
    data(){
      return{
        products:[],
        filtered_products:[],
        car_products:[],
        name: '',
        date:null,
        cell:'',
        university:'',
        career:'',
        grade:0,
        idQuotation:0
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
      addCart(product){
        this.car_products.push(product)
        this.filtered_products = []
        const objWithIdIndex = this.products.findIndex((obj) => obj.id === product.id)
        this.products.splice(objWithIdIndex,1)
        document.getElementById('inputSearch').value = ''
        document.getElementById('inputSearch').focus()
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