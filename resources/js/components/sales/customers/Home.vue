<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"> Clientes <span class="badge bg-label-primary me-1 cursor-pointer" @click="openCustomerModal(1)">+</span></h4>
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
                      <th>Opciones</th>
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
                      <td>
                        <button v-if="customer.status == null" @click="reactivateCustomer(customer.id)" class="btn btn-success btn-sm me-1">
                          <i class='bx bx-recycle'></i>
                        </button>
                        <button @click="openCustomerModal(2, customer)" class="btn btn-success btn-sm">
                          <i class='bx bx-edit'></i>
                        </button>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <customerModal :customer="customer_selected" :action="action" @getAllCustomers="getAllCustomers"/>
    </div>
</template>
<script>
import customerModal from './customerModal.vue'

  export default{
    components:{ customerModal },
    data(){
      return{
        customers:[],
        customer_selected:{},
        action: 1,
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
      openCustomerModal(action, customer){
        this.action = action
        this.customer_selected = customer
        $('#customerModal').modal('show')
      },
      reactivateCustomer(id){
        axios.get('../api/reactivateCustomer/'+id)
        .then(res => {
          this.customers = res.data
          this.getAllCustomers()
        })
      },
      getAllCustomers(){
        axios.get('../api/getAllCustomers')
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