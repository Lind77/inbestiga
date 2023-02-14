<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3"> Funnel</h4>
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col vh-100" id="clientArea" @drop="drop" @dragover="allowDrop">
              Lead
            <div class="container-cards">
              <div v-for="customer in customers">
                <div v-if="customer.status == 3">
                  <CardCustomer :customer="customer" @selectCustomer="selectCustomer" @getAllCustomers="getAllCustomers"/>
                </div>
              </div>
            </div>
            
            </div>
            <div class="col vh-100" id="interested" @drop="drop" @dragover="allowDrop">
              Interesado
                <div class="container-cards">
                <div v-for="customer in customers">
                  <div v-if="customer.status == 4">
                    <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col vh-100" id="highInterested" @drop="drop" @dragover="allowDrop">
              Altamente interesado
                <div class="container-cards">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 5">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col vh-100" id="withContract" @drop="drop" @dragover="allowDrop">
              Con Contrato
              <div class="container-cards">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 6">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col vh-100" id="client" @drop="drop" @dragover="allowDrop">
              Cliente
              <div class="container-cards">
                  <div v-for="customer in customers">
                    <div v-if="customer.status == 7">
                      <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </div>
                  </div>
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

export default{
  components:{CardCustomer, ProductModal},
  data(){
    return{
      customers:[],
      customer_selected:{}
    }
  },
  methods:{
    getAllCustomers(){
      axios.get('/api/getAllCustomers')
      .then(res =>{
          this.customers = res.data
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

          console.log(data)
          if(e.target.id == 'interested'){
            axios.get(`/api/updateCustomerGrade/${data.substring(data.length-1)}/4`)
            .then(res =>{
                this.getAllCustomers()
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
          }
          else if(e.target.id == 'highInterested'){
            axios.get(`/api/updateCustomerGrade/${data.substring(data.length-1)}/5`)
            .then(res =>{
                this.getAllCustomers()
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
          }
          else if(e.target.id == 'client'){
            axios.get(`/api/setProject/${data.substring(data.length-1)}`)
            .then(res =>{
              console.log(res)
              this.getAllCustomers()
            })
            .catch(err =>{
              console.log(err)
            })
          }
    }
  },
  mounted(){
    this.getAllCustomers()
  }
}
</script>