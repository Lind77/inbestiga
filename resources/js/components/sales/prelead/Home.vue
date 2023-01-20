<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3"> Pre-leads</h4>
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 border border-danger vh-100" id="noAtendedArea" @drop="drop" @dragover="allowDrop">
              No atendido
            <div class="container-cards">
              <div v-for="customer in customers">
                <div v-if="customer.grade == 0">
                  <CardCustomer :customer="customer"/>
                </div>
              </div>
            </div>
            
            </div>
            <div class="col-md-4 border border-danger vh-100" id="atendedArea" @drop="drop" @dragover="allowDrop">
              Atendido
              <div class="container-cards">
                <div v-for="customer in customers">
                <div v-if="customer.grade == 1">
                  <CardCustomer :customer="customer"/>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 border border-danger vh-100" id="comunicationArea" @drop="drop" @dragover="allowDrop">
              Comunicación establecida
              <div class="container-cards">
                <div v-for="customer in customers">
                <div v-if="customer.grade == 2">
                  <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                </div>
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
          var data = e.dataTransfer.getData("text");
          //e.target.appendChild(document.getElementById(data));
          console.log(data)
          if(e.target.id == 'noAtendedArea'){
            axios.get(`/api/updateCustomerGrade/${data.substring(data.length-1)}/0`)
            .then(res =>{
                console.log(res)
                this.getAllCustomers()
            })
            .catch(err =>{
                console.log(err)
            })
          }
          else if(e.target.id == 'atendedArea'){
            axios.get(`/api/updateCustomerGrade/${data.substring(data.length-1)}/1`)
            .then(res =>{
                console.log(res)
                this.getAllCustomers()
            })
            .catch(err =>{
                console.log(err)
            })
          }else if(e.target.id == 'comunicationArea'){
            axios.get(`/api/updateCustomerGrade/${data.substring(data.length-1)}/2`)
            .then(res =>{
                console.log(res)
                this.getAllCustomers()
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
