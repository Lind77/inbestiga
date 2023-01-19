<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3"> Pre-leads</h4>
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 border border-danger" id="noAtendedArea">
              No atendido
            <div class="container-cards">
              <div v-for="customer in customers">
                <div v-if="customer.grade == 0">
                  <CardCustomer :customer="customer"/>
                </div>
              </div>
            </div>
            
            </div>
            <div class="col-md-4 border border-danger" id="atendedArea" @drop="drop" @dragover="allowDrop">
              Atendido
              <div class="container-cards">
                <div v-for="customer in customers">
                <div v-if="customer.grade == 1">
                  <CardCustomer :customer="customer"/>
                </div>
              </div>
              </div>
            </div>
            <div class="col-md-4 border border-danger" id="comunicationArea">
              Comunicación establecida
              <div class="container-cards">
                <div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
</template>
<script>
import axios from 'axios'
import CardCustomer from './CardCustomer.vue'

export default {
    components: {CardCustomer},
    data(){
        return{
        customers:[]
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
        drop(e){
          e.preventDefault()
          console.log(e)
          if(e.target.id == 'atendedArea'){
            axios.get(`/api/updateCustomerGrade/${1}`)
            .then(res =>{
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
          }
          console.log(e.target.id)
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
