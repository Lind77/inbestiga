<template>
    <div class="container-xxl flex-grow-1 container-p-y p-0">
      <div>
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Ordenes de Servicio almacenadas</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead class="table-primary">
                  <tr class="text-nowrap">
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Imprimir</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr v-for="order in orders">
                    <td><strong>{{order.customer.name}}</strong></td>
                    <td>{{order.created_at}}</td>
                    <td>
                      <router-link :to="{name:'order-file', params:{ id: order.id }}" target="_blank" class="btn btn-success text-white"><i class='bx bx-printer'></i></router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
  </div>
</template>
<script>
    export default{
      data(){
        return{
            orders:[]
        }
      },
      methods:{
        print(id){
            window.open('./api/generatePDF/'+id)
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
            },
      },
      mounted(){
        this.getAllOrders()
      }
    }
  </script>