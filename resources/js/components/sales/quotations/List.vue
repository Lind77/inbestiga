<template>
<div class="container-xxl flex-grow-1 container-p-y p-0">
      <div>
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Cotizaciones almacenadas</h5>
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
                  <tr v-for="quotation in quotations">
                    <td><strong>{{quotation.customer.name}}</strong></td>
                    <td>{{quotation.date}}</td>
                    <td><a @click="print(quotation.id)" class="btn btn-success text-white"><i class='bx bx-printer'></i></a></td>
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
          quotations:[]
        }
      },
      methods:{
        print(id){
            window.open('/api/generatePDF/'+id)
        },
        getAllProducts(){
                axios.get('../api/getAllQuotations')
                .then(res =>{
                  console.log(res)
                  this.quotations = res.data
                })
                .catch(err =>{
                  console.log(err.response.data)
                })
            },
      },
      mounted(){
        this.getAllProducts()
      }
    }
  </script>