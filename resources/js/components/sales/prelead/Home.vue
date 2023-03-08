<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
            <!-- <div class="col-md-4 vh-85" id="noAtendedArea" @drop="drop" @dragover="allowDrop">
              No atendido
            <div class="container-cards">
              <div v-for="customer in customers">
                <div v-if="customer.status == 0">
                  <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers" :status="status"/>
                </div>
              </div>
            </div>
            
            </div> -->
            <div class="col-md-6 vh-85 overflow-auto" id="atendedArea" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Atendido</h5>
              <div class="container-cards">
                <div v-for="customer in customers">
                <div v-if="customer.status == 1">
                  <CardCustomer :customer="customer"  @getAllCustomers="getAllCustomers" :status="status"/>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 vh-85 overflow-auto" id="comunicationArea" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Comunicación establecida</h5>
              <div class="container-cards">
                <div v-for="customer in customers">
                <div v-if="customer.status == 2">
                  <CardCustomer :customer="customer" @selectCustomer="selectCustomer" @getAllCustomers="getAllCustomers" :status="status"/>
                </div>
                </div>
              </div>
            </div>
          </div>
      <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>  
    </div>
</template>
<script>
import axios from 'axios'
import CardCustomer from './CardCustomer.vue'
import ProductModal from '../funnel/ProductModal.vue'

export default {
    components: {CardCustomer, ProductModal},
    data(){
        return{
        customers:[],
        status: 0,
        customer_selected:{}
        }
    },
    methods:{
        getAllCustomers(){
        this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
        })
        axios.get('/api/getAllCustomers')
        .then(res =>{
            this.customers = res.data
            this.$swal().close()
        })
        .catch(err =>{
            console.log(err.response.data)
        })
        },
        selectCustomer(customer){
        console.log('customer selected')
        this.customer_selected = customer
        },
        drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData("text");
         
          //console.log(data)
          if(e.target.id == 'noAtendedArea'){
            axios.get(`/api/updateCustomerGrade/${data}/0`)
            .then(res =>{
              this.getAllCustomers()
            })
            .catch(err =>{
                console.log(err)
            })
          }
          else if(e.target.id == 'atendedArea'){
            axios.get(`/api/updateCustomerGrade/${data}/1`)
            .then(res =>{
                this.getAllCustomers()
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
          }else if(e.target.id == 'comunicationArea'){
            
            axios.get(`/api/updateCustomerGrade/${data}/2`)
            .then(res =>{
                this.getAllCustomers()
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
          }
        },
        allowDrop(e){
          e.preventDefault()
        }
    },
    mounted(){
        this.getAllCustomers()
    }
    }
</script>
<style scoped>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: rgba(67, 89, 113, 0.075);
  border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgba(67,89,113,.7);
}
</style>