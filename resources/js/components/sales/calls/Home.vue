<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-0">Comunicaciones</h4>
    <!-- <div class="row mb-3">
      <label for="">Seleccionar fecha de Próxima Gestión</label>
      <input type="date" @change="filterDate" class="form-control w-25 ms-2">
    </div> -->
    <div class="row px-3 mb-2">
      <input type="text" v-model="search" v-on:keyup.enter="searchCustomer" class="form-control w-50">
      <button class="btn btn-primary w-25 ms-2" @click="searchCustomer">Buscar</button>
    </div>
    <div class="row">
      <div class="col-4" v-for="customer in customers_filtered">
        <div class="card mt-1">
          <h5 class="card-header cursor-pointer" @click="callModal(customer.comunications)">{{ customer.name ||
            customer.cell }}</h5>
        </div>
      </div>
    </div>
  </div>
  <ComunicationsModal :comunications="comunications" />
</template>
<script>
import axios from 'axios'
import ComunicationsModal from './ComunicationsModal.vue'

export default {
  components: { ComunicationsModal },
  data() {
    return {
      search: '',
      comunications: [],
      customers: [],
      customers_filtered: [],
      status: {
        0: 'No atendido',
        1: 'Atendido',
        2: 'Comunicación establecida',
        3: 'Lead',
        4: 'Interesado',
        5: 'Altamente Interesado',
        6: 'Cliente',
        null: 'Stand By'
      }
    }
  },
  methods: {
    callModal(comunications) {
      if (comunications != null) {
        this.comunications = comunications
      }
      $('#ComunicationsModal').modal('show')
    },
    searchCustomer() {
      if (this.search != '') {
        axios.get('/api/customers/comunications/' + this.search)
          .then(res => {
            this.customers_filtered = res.data
          })
          .catch(err => {
            console.error(err)
          })
      }
    },
    filterDate(e) {
      console.log(e.target.value == '')
      if (e.target.value == '') {
        this.customers_filtered = this.customers
      } else {
        this.customers_filtered = this.customers.filter((customer) => customer.comunication && customer.comunication.next_management == e.target.value)
      }

    },
    getAllCustomers() {
      axios.get('/api/customers')
        .then(res => {
          this.customers = res.data
          this.customers_filtered = this.customers
        })
    }
  },
  mounted() {
    this.getAllCustomers()
  }
}
</script>