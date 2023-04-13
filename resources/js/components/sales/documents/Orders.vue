<template>
    <div class="card tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                <h5 class="card-header">Ordenes</h5>
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
                      <tr v-for="order in orders">
                        <td><strong>{{order.quotation.customer.name}}</strong></td>
                        <td>{{  dateFormatted(order.created_at) }}</td>
                        <td>
                          <router-link :to="{name:'order-file', params:{ id: order.id }}" target="_blank" class="btn btn-sm btn-success text-white mx-1"><i class='bx bx-printer'></i>
                          </router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
</template>
<script>
  import moment from 'moment'
  export default {
    data(){
      return{
        orders:[]
      }
    },
    methods:{
      dateFormatted(date){
        return moment(date).format('D-MM-YYYY')
      },
      getAllOrders(){
        axios.get('/api/getAllOrders')
          .then(res =>{
            console.log(res)
            this.orders = res.data
          })
          .catch(err =>{
            console.log(err.response.data)
          })
      }
    },
    mounted(){
      this.getAllOrders()
    }
  }
</script>
<style scoped>
    
</style>