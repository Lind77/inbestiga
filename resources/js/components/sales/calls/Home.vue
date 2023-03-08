<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Comunicaciones</h4>
    <div class="row mb-3">
      <label for="">Seleccionar fecha de Próxima Gestión</label>
      <input type="date" @change="filterDate" class="form-control w-25 ms-2">
    </div>
    <div class="row">
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
                    <th>Servicio</th>
                    <th>Acción</th>
                    <th>Primera Gestión</th>
                    <th>Última Gestión</th>
                    <th>Próxima Gestión</th>
                    <th>Comentario</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr v-for="customer in customers_filtered">
                  <td><strong>{{customer.name}}</strong></td>
                    <td>{{customer.cell}}</td>
                    <td>{{customer.email}}</td>
                    <td>{{customer.university}}</td>
                    <td>{{customer.career}}</td>
                    <td>{{ status[customer.status] }}</td>
                    <td>{{customer.comunication? customer.comunication.product_tentative : '-'}}</td>
                    <td>{{ customer.comunication?  comunication[customer.comunication.type] : '-'  }}</td>
                    <td>{{ customer.comunication? customer.comunication.first_management : '-'  }}</td>
                    <td>{{ customer.comunication? customer.comunication.last_management : '-'  }}</td>
                    <td>{{ customer.comunication? customer.comunication.next_management : '-'  }}</td>
                    <td>{{ customer.comunication? customer.comunication.comment : '-'  }}</td>
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
export default{
  data(){
    return{
      customers:[],
      customers_filtered:[],
      status:{
          0: 'No atendido',
          1: 'Atendido',
          2: 'Comunicación establecida',
          3: 'Lead',
          4: 'Interesado',
          5: 'Altamente Interesado',
          6: 'Cliente',
          null: 'Stand By'
        },
      comunication:{
        1: 'Llamar',
        2: 'Escribir',
        3: 'Meet'
      }
    }
  },
  methods:{
    filterDate(e){
      console.log(e.target.value == '')
      if(e.target.value == ''){
        this.customers_filtered = this.customers
      }else{
        this.customers_filtered = this.customers.filter((customer) => customer.comunication && customer.comunication.next_management == e.target.value)
      }
      
    },
    getAllCustomers(){
      axios.get('/api/getAllCustomers')
      .then(res => {
        this.customers = res.data
        this.customers_filtered = this.customers
      })
    }
  },
  mounted(){
    this.getAllCustomers()
  }
}
</script>