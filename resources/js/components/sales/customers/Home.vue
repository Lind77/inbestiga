<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"> Clientes <span class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#customerModal">+</span></h4>
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <h5 class="card-header">Directorio de Clientes</h5>
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                  <tr>
                    <th>Nombre</th>
                      <th>Celular</th>
                      <th>Universidad</th>
                      <th>Carrera</th>
                      <th>Grado</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr v-for="customer in customers">
                    <td><strong>{{customer.name}}</strong></td>
                      <td>{{customer.cell}}</td>
                      <td>{{customer.university}}</td>
                      <td>{{customer.career}}</td>
                      <td v-if="customer.grade == 1">
                        Pregrado
                      </td>
                      <td v-else-if="customer.grade == 2">
                        Maestría
                      </td>
                      <td v-else-if="customer.grade == 3">
                        Doctorado
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <customerModal @getAllCustomers="getAllCustomers"/>
    </div>
</template>
<script>
import customerModal from './customerModal.vue'

  export default{
    components:{ customerModal },
    data(){
      return{
        customers:[]
      }
    },
    methods:{
      getAllCustomers(){
        axios.get('/api/getAllCustomers')
        .then(res => {
          this.customers = res.data
        })
      }
    },
    mounted(){
      this.getAllCustomers()
    }
  }
</script>