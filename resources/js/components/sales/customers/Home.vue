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
                      <th>Correo</th>
                      <th>Universidad</th>
                      <th>Carrera</th>
                      <th>Estado</th>
                      <th>Reactivar</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr v-for="customer in customers">
                    <td><strong>{{customer.name}}</strong></td>
                      <td>{{customer.cell}}</td>
                      <td>{{customer.email}}</td>
                      <td>{{customer.university}}</td>
                      <td>{{customer.career}}</td>
                      <td>{{ status[customer.status] }}</td>
                      <td v-if="customer.status == null">
                        <button @click="reactivateCustomer(customer.id)" class="btn btn-success btn-sm">
                          Reactivar
                        </button>
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
        customers:[],
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
      reactivateCustomer(id){
        axios.get('/api/reactivateCustomer/'+id)
        .then(res => {
          this.customers = res.data
          this.getAllCustomers()
        })
      },
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