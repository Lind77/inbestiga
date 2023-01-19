<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3"> Funnel</h4>
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3" id="clientArea">
              Lead
            <div class="container-cards">
              
            </div>
            
            </div>
            <div class="col-md-3" id="directionArea">
              Interesado
                <div class="container-cards">
                <div>
              </div>
              </div>
            </div>
            <div class="col-md-3" id="qualityArea">
              Altamente interesado
              <div class="container-cards">
                <div>
              </div>
              </div>
            </div>
            <div class="col-md-3" id="qualityArea">
              Cliente
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