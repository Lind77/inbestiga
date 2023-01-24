<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"> Llamadas </h4>
    <!-- <div class="row">
      <div class="col-xl-12 col-lg-12">
        <div class="card">
          <h5 class="card-header">Clientes en Stand By</h5>
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
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr v-for="customer in customers">
                  <td><strong>{{customer.name}}</strong></td>
                    <td>{{customer.cell}}</td>
                    <td>{{customer.email}}</td>
                    <td>{{customer.university}}</td>
                    <td>{{customer.career}}</td>
                    <td>Stand By</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</template>
<script>
export default{
  data(){
    return{
      customers:[]
    }
  },
  methods:{
    getAllCustomers(){
      axios.get('/api/getAllStandByCustomers')
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