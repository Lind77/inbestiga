<template>
  <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold" v-if="this.$route.params.idUser == 0">Cotizaciones</h4>
              <div class="row">
              <div class="col-xl">
                <div class="card mb-4">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tabla de Cotizaciones almacenadas</h5>
                  </div>
                  <div class="card-body">
                  <form>
                    <div class="table-responsive text-nowrap">
                      <table class="table">
                        <thead class="table-primary">
                          <tr class="text-nowrap">
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          <tr v-for="quotation in quotations">
                            <td><strong>{{quotation.customer.name}}</strong></td>
                            <td>{{quotation.date}}</td>
                            <td>
                              <router-link :to="{name:'quotation-img', params:{ id: quotation.id }}" target="_blank" class="btn btn-success text-white mx-1"><i class='bx bx-image'></i>
                              </router-link>
                              <router-link :to="{name:'quotation-file', params:{ id: quotation.id }}" target="_blank" class="btn btn-success text-white mx-1"><i class='bx bx-printer'></i>
                              </router-link>
                              <router-link :to="{name:'edit-quotation', params:{ idQuot: quotation.id }}" class="btn btn-success text-white"><i class='bx bx-edit'></i></router-link>
                            </td>
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
  </template>
  <script>
    export default{
      data(){
        return{
          quotations:[]
        }
      },
      methods:{
        print(id){
            window.open(`./api/quotations/${id}/pdf/`)
        },
        getAllQuotations(){
                axios.get('/api/quotations')
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
        this.getAllQuotations()
      }
    }
  </script>