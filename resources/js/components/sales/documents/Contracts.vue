<template>
  <div class="card tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
    <h5 class="card-header">Contratos</h5>
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
          <tr v-for="contract in contracts">
            <td><strong v-for="customer in contract.quotation.customers">{{ customer.name }}</strong></td>
            <td>{{ contract.date ? contract.date : '' }}</td>
            <td>
              <a :href="`../public/api/generateContract/${contract.id}`" target="_blank"
                class="btn btn-sm btn-primary mx-2 text-white" disabled><i class='bx bx-printer'></i></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      contracts: []
    }
  },
  methods: {
    getAllContracts() {
      axios.get('/api/getAllContracts')
        .then(res => {
          console.log(res)
          this.contracts = res.data
        })
        .catch(err => {
          console.log(err.response.data)
        })
    }
  },
  mounted() {
    this.getAllContracts()
  }
}
</script>
<style scoped></style>