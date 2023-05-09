<template>
    <div class="card tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
                <h5 class="card-header">Cotizaciones</h5>
                <SearchDocs :group="'Quotations'" @updateRows="updateRows" @getAllQuotations="getAllQuotations"/>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr v-for="quotation in quotations">
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{quotation.customer.name}}</strong></td>
                        <td>{{ quotation.date }}</td>
                        <td>
                          <router-link :to="{name:'quotation-img', params:{ id: quotation.id }}" target="_blank" class="btn btn-sm btn-success text-white mx-1"><i class='bx bx-image'></i></router-link>
                          <router-link :to="{name:'quotation-file', params:{ id: quotation.id }}" target="_blank" class="btn btn-sm btn-success text-white mx-1"><i class='bx bx-printer'></i>
                          </router-link>
                          <router-link :to="{name:'home-quotation', params:{ idUser: quotation.customer.id }}" class="btn btn-sm btn-success text-white"><i class='bx bx-edit'></i></router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
</template>
<script>
import SearchDocs from './SearchDocs.vue'

export default {
  components:{SearchDocs},
    data(){
      return{
        quotations:[]
      }
    },
    methods:{
      getAllQuotations(){
          axios.get('/api/getAllQuotations')
          .then(res =>{
            console.log(res)
            this.quotations = res.data
          })
          .catch(err =>{
            console.log(err.response.data)
          })
      },
      updateRows(quotations){
        this.quotations = quotations
      }
    },
    mounted(){
      this.getAllQuotations()
    }
}
</script>
<style scoped>
    
</style>