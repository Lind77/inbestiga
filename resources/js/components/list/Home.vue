<template>
    <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <Sidebar />
        <div class="layout-page">
            <Navbar />
            <div class="content-wrapper">
              <!-- Content -->
  
              <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">Cotizaciones</h4>
                <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Tabla de Productos o Servicios</h5>
                    </div>
                    <div class="card-body">
                      <form>
                        <h5 class="mb-4">Cotizaciones almacenadas</h5>
                        <div class="table-responsive text-nowrap">
                          <table class="table">
                            <thead class="table-primary">
                              <tr class="text-nowrap">
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>PDF</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr v-for="quotation in quotations">
                                <td><strong>{{quotation.customer.name}}</strong></td>
                                <td>{{quotation.date}}</td>
                                <td><a @click="print(quotation.id)" class="btn btn-success text-white">PDF</a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              
              
              <!-- / Content -->
  
              <div class="content-backdrop fade"></div>
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
          quotations:[]
        }
      },
      methods:{
        print(id){
            window.open('/api/generatePDF/'+id)
        },
        getAllProducts(){
                axios.get('/api/getAllQuotations')
                .then(res =>{
                  console.log(res)
                  this.quotations = res.data
                })
                .catch(err =>{
                  console.log(err.response.data)
                })
            },
      },
      mounted(){
        this.getAllProducts()
      }
    }
  </script>