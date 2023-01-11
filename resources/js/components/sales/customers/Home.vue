<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"> Clientes <span class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#customerModal">+</span></h4>
      <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
            <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-primary">
          <tr class="text-nowrap">
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
            <td>{{customer.grade}}</td>
          </tr>
        </tbody>
      </table>
      </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import axios from 'axios';

  export default{
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