<template>
    <div class="container-xxl flex-grow-1 container-p-y"> 
      <div class="row">
            <div class="col vh-100" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Lead</h5> 
            <div class="container-cards overflow-auto h-75" id="3">
              <div v-for="customer in customers">
                <div v-if="customer.status == 3">
                  <CardCustomer :customer="customer" @selectCustomer="selectCustomer" @getAllCustomers="getAllCustomers"/>
                </div>
              </div>
            </div>
            
            </div>
            <div class="col vh-100" id="2" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Con cotización</h5>
                <div class="container-cards overflow-auto h-75" id="4">
                <div v-for="customer in customers">
                  <div v-if="customer.status == 4">
                    <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col vh-100" id="3" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Altamente interesado</h5>
                <div class="container-cards overflow-auto h-75" id="5">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 5">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col vh-100" id="4" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Con Contrato</h5>
              <div class="container-cards overflow-auto h-75" id="6">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 6">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col vh-100" id="5" @drop="drop" @dragover="allowDrop">
              <h5 class="fw-600">Cliente</h5>
              <div class="container-cards overflow-auto h-75" id="7">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 7">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
              </div>
            </div>
          </div>
      <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>
    </div>
</template>
<script>
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import {useCounterStore} from '../../../stores/UserStore'


export default{
  setup(){
      const store = useCounterStore()
      return{
        store
      }
  },
  components:{CardCustomer, ProductModal},
  data(){
    return{
      customers:[],
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
    allowDrop(e){
          e.preventDefault()
    },
    drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData("text");
          //e.target.appendChild(document.getElementById(data));

          console.log(data, e.target.id)

          if(e.target.id != 7){
            this.updateStatus(data, e.target.id)
          }else{
            this.setProject(data)
          }
    },
    updateStatus(id, status){
      axios.get(`/api/updateCustomerGrade/${id}/${status}`)
      .then(res =>{
          this.getAllCustomers()
          console.log(res)
      })
      .catch(err =>{
          console.log(err)
      })
    },
    setProject(id){
      console.log(id)

      const fd = new FormData()
      fd.append('id_customer', id)
      fd.append('emisor_id', this.store.authUser[0].id)
      axios.post(`/api/setProject`, fd)
      .then(res =>{
        console.log(res)
        this.getAllCustomers()
      })
      .catch(err =>{
        this.$swal(err.response.data.msg)
      })
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