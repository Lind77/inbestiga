<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <input v-on:keyup.enter="searchByName" @keyup="cleanPreLeads" v-model="search" type="text"
      placeholder="Buscar prelead por nombre..." class="form-control w-50 mb-2">
    <div class="container-override" id="funnelContainer">
      <template v-for="preleadArea in preleadAreas">
        <draggableArea :customers="preleadArea.customers" :title="preleadArea.title" :status="preleadArea.status"
          @updateStatusPrelead="updateStatusPrelead" @updateStatusSpace="updateStatusSpace"
          @showModalUpdateData="showModalUpdateData" @showModalFunnel="showModalFunnel"
          @showModalFunnelCustomer="showModalFunnelCustomer" />
      </template>
    </div>
    <ProductModal :customer="customerSelected" @getAllPreleads="getAllPreleads" />
    <!-- <UpdateCom :comunication="comunication"/>   -->
  </div>
  <OwnerModal :customerId="customerId" @convertLead="convertLead" @cleanLead="cleanLead" />
  <customerModal :customer="customer" :action="2" />
  <FunnelModal :customer="customer" @updateToLead="updateToLead" @updateStatusSpace="updateStatusSpace"
    @callModalComunication="callModalComunication" @showModalUpdateData="showModalUpdateData"
    @getAllPreleads="getAllPreleads" :owners="owners" @updateOwner="updateOwner" />
  <UpdateCom :customer="customerToComunication" :comunication="comunication" :customerId="customerId" :action="action"
    @getAllPreleads="getAllPreleads" @addNewComunication="addNewComunication" />
</template>
<script>
import axios from 'axios'
import { userStore } from '../../../stores/UserStore'
import CardCustomer from './CardCustomer.vue'
import ProductModal from '../funnel/ProductModal.vue'
import draggableArea from '../funnel/DraggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'
import OwnerModal from './OwnerModal.vue'
import customerModal from '../customers/customerModal.vue'
import FunnelModal from '../funnel/FunnelModal.vue'

export default {
  inheritAttrs: false,
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { CardCustomer, ProductModal, draggableArea, UpdateCom, OwnerModal, customerModal, FunnelModal },
  data() {
    return {
      attended: [],
      noAttended: [],
      comunications: [],
      needs: [],
      preleadAreas: [],
      action: 0,
      customers: [],
      origin: [],
      status: 0,
      customerSelected: [],
      comunication: null,
      customerId: 0,
      customer: {},
      customer_selected: {},
      search: '',
      filteredCustomers: [],
      leadsFiltered: [],
      owners: [],
      quotation: {},
      customerToComunication: {}
    }
  },
  methods: {
    addNewComunication(comunication, customer) {
      let arraysByStatus = {
        1: this.noAttended,
        2: this.attended,
        3: this.comunications,
        4: this.needs
      }

      var arraySelected = arraysByStatus[customer.status];

      console.log(arraySelected);

      var customerSelected = arraySelected.find(prelead => prelead.id == customer.id);

      customerSelected.comunications.push(comunication);

      this.customer = customerSelected

      $('#funnelModal').modal('show')

    },
    showModalFunnelCustomer(customer) {
      this.customer = customer;
      $('#funnelModal').modal('show');
      console.log('Im in home preleads', customer);
    },
    updateStatusPrelead(customerId, newStatus) {
      console.log(newStatus);
      var preleadSelected = this.customers.find(customer => customer.id == customerId)
      if (newStatus < 5) {
        this.updateStatusSpace(customerId, newStatus)
        console.log(preleadSelected);
      } else {
        alert('transformando en quot')
      }
    },
    getAllOwners() {
      axios.get('/api/getAllOwners')
        .then(res => {
          this.owners = res.data
        })
        .catch(err => {
          console.error(err)
        })
    },
    distributePreLeads(leads) {
      this.leadsFiltered = leads

      this.leadsFiltered.forEach(customer => {
        if (customer.status == 1) {
          this.noAttended.push(customer)
        } else if (customer.status == 2) {
          this.attended.push(customer)
        } else if (customer.status == 3) {
          this.comunications.push(customer)
        } else {
          this.needs.push(customer)
        }
      })

      this.preleadAreas = [
        {
          title: 'No Atendido',
          status: 1,
          customers: this.noAttended
        },
        {
          title: 'Atendido',
          status: 2,
          customers: this.attended
        },
        {
          title: 'Comunicación Establecida',
          status: 3,
          customers: this.comunications
        },
        {
          title: 'Obtención de necesidades específicas',
          status: 4,
          customers: this.needs
        }
      ]
    },
    cleanPreLeads() {
      if (this.search == '') {
        this.getAllCustomers()
        this.filteredCustomers = []
      }
    },
    searchByName() {
      console.log('nani');
      this.noAttended = []
      this.attended = []
      this.comunications = []
      this.needs = []

      axios.get('/api/searchPreleads/' + this.search)
        .then((res) => {
          console.log(res.data)
          this.distributePreLeads(res.data)

        })
        .catch((err) => {
          console.error(err)
        })
      console.log(this.filteredCustomers)



    },
    callModalComunication(customer) {
      console.log(customer)
      $('#funnelModal').modal('hide')
      this.customerToComunication = customer
      if (customer.comunication == null) {
        this.action = 1
      }
      $('#updateComModal').modal('show')
    },
    updateToLead() {
      alert('pasando a lead')
    },
    showModalFunnel(customer) {
      this.customerSelected = []
      this.customerSelected.push(customer)
      this.customer_selected = customer
      $('#funnelModal').modal('show')
    },
    cleanLead(id, owner) {
      var preleadSelected = this.comunications.find(comunication => comunication.id == id)
      console.log(preleadSelected)
      var index = this.comunications.findIndex(lead => lead.id == id)
      this.comunications.splice(index, 1)
      preleadSelected.status = 4
      preleadSelected.user = owner
      this.needs.unshift({ ...preleadSelected })

    },
    convertLead(id) {
      this.customerId = parseInt(id)
      $('#ownerModal').modal('show')
    },
    updateStatusSpace(customer_id, newStatus) {
      console.log(customer_id, this.customers)

      var customerSelected = this.leadsFiltered.find(customer => customer.id == customer_id)

      if (newStatus == 3) {
        if (customerSelected.name == null || customerSelected.cell == null || customerSelected.career == null || customerSelected.university == null) {
          this.$swal('El usuario carece de información básica necesaria (nombre, número, carrera y universidad)')
        } else {
          var oldStatus = customerSelected.status

          console.log(oldStatus)

          let arraysByStatus = {
            0: this.origin,
            1: this.noAttended,
            2: this.attended,
            3: this.comunications,
            4: this.needs
          }

          let index = arraysByStatus[oldStatus].findIndex(el => el.id == customerSelected.id)

          arraysByStatus[oldStatus].splice(index, 1)
          customerSelected.status = newStatus
          arraysByStatus[newStatus].unshift({ ...customerSelected })

          this.updateStatus(customer_id, newStatus)
        }
      } else if (newStatus == 4) {
        $('#funnelModal').modal('hide')
        this.convertLead(customer_id)
      } else if (newStatus == 5) {
        $('#funnelModal').modal('hide')
        this.$router.push({ name: 'home-quotation', params: { idCustomer: customer_id } });
        /* var oldStatus = customerSelected.status

        console.log(oldStatus)

        let arraysByStatus = {
          0: this.origin,
          1: this.noAttended,
          2: this.attended,
          3: this.comunications,
          4: this.needs
        }

        let index = arraysByStatus[oldStatus].findIndex(el => el.id == customerSelected.id)

        arraysByStatus[oldStatus].splice(index, 1)
        customerSelected.status = newStatus
        if (newStatus < 5) {
          arraysByStatus[newStatus].unshift({ ...customerSelected })
        }


        this.updateStatus(customer_id, newStatus) */
      } else {
        var oldStatus = customerSelected.status

        console.log(oldStatus)

        let arraysByStatus = {
          0: this.origin,
          1: this.noAttended,
          2: this.attended,
          3: this.comunications,
          4: this.needs
        }

        let index = arraysByStatus[oldStatus].findIndex(el => el.id == customerSelected.id)

        arraysByStatus[oldStatus].splice(index, 1)
        customerSelected.status = newStatus
        arraysByStatus[newStatus].unshift({ ...customerSelected })

        this.updateStatus(customer_id, newStatus)
      }

    },
    showModalUpdateData(customer) {
      $('#funnelModal').modal('hide')
      this.customer = customer
      $('#customerModal').modal('show')
    },
    getAllPreleads() {
      this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
      })
      this.noAttended = []
      this.attended = []
      this.comunications = []
      this.needs = []

      axios.get('/api/preleads')
        .then(res => {
          this.customers = res.data
          this.customers.forEach(customer => {
            if (customer.comunications) {
              const ids = customer.comunications.map(comunication => {
                return comunication.id;
              });
              const max = Math.max(...ids);
              customer.lastManagement = customer.comunications.find(element => element.id === max);
            }
          })

          this.distributePreLeads(res.data)
          this.$swal().close()
        })
        .catch(err => {
          console.log(err)
        })
    },
    selectCustomer(customer) {
      console.log('customer selected')
      this.customerSelected = customer
    },
    drop(e) {
      e.preventDefault()
      var data = e.dataTransfer.getData("text");

    },
    allowDrop(e) {
      e.preventDefault()
    },
    updateStatus(id, status) {
      const fd = new FormData()
      fd.append('customer_id', id)
      fd.append('status', status)
      fd.append('user_id', this.store.authUser.id)
      axios.post(`/api/update-customer-status`, fd)
        .then(res => {
          var newCustomer = res.data.eleventhCustomer
          if (newCustomer) {
            let arraysByStatus = {
              0: this.origin,
              1: this.noAttended,
              2: this.attended,
              3: this.comunications,
              4: this.needs
            }
            arraysByStatus[newCustomer.status].push(newCustomer)
          }
          $('#funnelModal').modal('hide')
          this.$swal('El usuario ha sido actualizado correctamente')
        })
        .catch(err => {
          console.log(err)
        })
    },
    updateOwner(newCustomer, newOwner) {
      let arraysByStatus = {
        1: this.noAttended,
        2: this.attended,
        3: this.comunications,
        4: this.needs
      }
      let arraySelected = arraysByStatus[newCustomer.status]

      var customerSelected = arraySelected.find(customer => customer.id == newCustomer.id)
      customerSelected.user = newOwner
    },
    loadCustomerById(userId) {
      var customerSelected = this.customers.find(lead => lead.id == userId)
      if (customerSelected) {
        this.customer_selected = customerSelected
        $('#funnelModal').modal('show')
      } else {
        axios.get('/api/customer-by-id/' + userId)
          .then((result) => {
            this.customer_selected = result.data
            $('#funnelModal').modal('show')
          }).catch((err) => {
            console.error(err)
          });
      }
    }
  },
  mounted() {
    this.getAllPreleads()
    this.getAllOwners()
    if (this.$route.params.userId) {
      this.loadCustomerById(this.$route.params.userId)
    }
  }
}
</script>
<style scoped>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: rgba(67, 89, 113, 0.075);
  border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgba(67, 89, 113, .7);
}

.container-override {
  width: 100%;
  padding: 2px;
  display: inline-flex;
  align-items: center;
}
</style>