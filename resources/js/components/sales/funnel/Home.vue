<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3"> Funnel</h4>
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Seguimiento de Clientes</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4" id="clientArea">
              No atendido
            <div class="container-cards">
              <div v-for="customer in customers">
                <div v-if="customer.grade == 0">
                  <div class="card bg-danger mt-2">
                    <div class="card-header text-white fw-300">
                      {{ customer.name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            </div>
            <div class="col-md-4" id="directionArea">
              Atendido
              <div class="container-cards">
                <div>
              </div>
              </div>
            </div>
            <div class="col-md-4" id="qualityArea">
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
  export default{
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
      }
    },
    mounted(){
      this.getAllCustomers()
    }
  }
</script>