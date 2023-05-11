<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"> Base de datos <span class="badge bg-label-primary me-1 cursor-pointer" @click="openCustomerModal(1)">+</span></h4>
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <h5 class="card-header">Base de datos</h5>
            <input type="text" name="" id="" placeholder="Buscar..." class="form-control w-50 ms-2 py-2" @keyup.enter="searchCustomer" @keyup="cleanSearch" v-model="search">
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                  <tr>
                      <th>Nombre</th>
                      <th>Celular</th>
                      <th>Fecha de Registro</th>
                      <th>Universidad</th>
                      <th>Carrera</th>
                      <th>Estado</th>
                      <th>Opciones</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr v-for="customer in customers">
                    <td><strong>{{customer.name}}</strong><i @click="openAsignOwner(customer.id)" v-show="customer.user_id == null" class='bx bxs-user-x text-danger'></i></td>
                      <td>{{customer.cell}}</td>
                      <td>{{formatDate(customer.created_at)}}</td>
                      <td>{{customer.university}}</td>
                      <td>{{customer.career}}</td>
                      <td>{{ status[customer.status] }}</td>
                      <td>
                        <!-- <router-link class="btn btn-success btn-sm" :to="{name:'home-quotation', params:{ idUser: customer.id }}">Generar Cotización</router-link> -->
                        <button v-if="customer.status == null" @click="reactivateCustomer(customer.id)" class="btn btn-success btn-sm me-1">
                          <i class='bx bx-recycle'></i>
                        </button>
                        <button @click="openCustomerModal(2, customer)" class="btn btn-success btn-sm ms-2">
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
      <customerModal :customer="customer_selected" :action="action" :allUsers="allUsers" @getAllCustomers="getAllCustomers"/>
      <OwnerModal :customerId="customerId" @cleanLead="cleanLead"/>
    </div>
</template>
<script>
import moment from "moment"
import customerModal from './customerModal.vue'
import OwnerModal from '../prelead/OwnerModal.vue'
  export default{
    components:{ customerModal, OwnerModal },
    data(){
      return{
        customerId:0,
        customers:[],
        customersPag: [],
        customersChunked: [],
        customer_selected:{},
        allUsers:[],
        action: 1,
        search: '',
        status:{
          1: 'No atendido',
          2: 'Atendido',
          3: 'Comunicación establecida',
          4: 'Obtención de necesidades específicas',
          5: 'Con Cotización',
          6: 'Explicación de Cotización',
          7: 'Explicación de la Experiencia',
          8: 'Seguimientos',
          9: 'Cierre no pagado',
          10: 'Seguimiento de cierre',
          11: 'Cliente'
        }
      }
    },
    methods:{
      cleanSearch(){
        if(this.search == ''){
          this.getAllCustomers()
        }
      },
      formatDate(date){
        return moment(date).format('DD/MM/YYYY')
      },
      cleanLead(customerId, seller){
        var customerSelected = this.customersPag.find(customer => customer.id == customerId)
        customerSelected.user_id = seller
      },
      openAsignOwner(id){
        this.customerId = id
        $('#ownerModal').modal('show')
      },
      searchCustomer(){
         axios.get('/api/searchCustomers/'+this.search)
         .then((res) =>{
          this.customers = res.data
         })
         .catch((err) =>{
          console.error(err.response)
         })
      },
      stepPag(i){
        this.customersPag = this.customersChunked[i]
        document.querySelectorAll('.paginate_button').forEach(el =>{
          el.classList.remove('active')
        })
        document.getElementById('li'+i).classList.add('active')
      },
      openCustomerModal(action, customer){
        this.action = action
        this.customer_selected = customer
        $('#customerModal').modal('show')
      },
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