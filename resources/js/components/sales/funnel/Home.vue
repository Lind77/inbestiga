<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="row">
        <DatePicker @filterDate="filterDate" @distributeLeads="distributeLeads" @getAllCustomers="getAllCustomers" />
      </div>
      <template v-for="area in draggableAreas">
        <draggableArea :customers="area.customers" :title="area.title" :status="area.status"
          @updateStatusSpace="updateStatusSpace" @showModalFunnel="showModalFunnel" @callModal="callModal" />
      </template>
    </div>
    <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers" />
    <UpdateCom :customerId="customerId" :comunication="comunication" />
    <FunnelModal :customer="customer_selected" :owners="owners" @updateStatusSpace="updateStatusSpace"
      @callModal="callModal" @showModalUpdateData="showModalUpdateData" @getAllCustomers="getAllCustomers"
      @updateOwner="updateOwner" @updateInterest="updateInterest" />
    <customerModal :customer="customer_selected" :action="2" />
  </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import { userStore } from '../../../stores/UserStore'
import draggableArea from './draggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'
import FunnelModal from './FunnelModal.vue'
import customerModal from '../customers/customerModal.vue'
import axios from 'axios'

export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { CardCustomer, ProductModal, draggableArea, DatePicker, UpdateCom, FunnelModal, customerModal },
  data() {
    return {
      customers: [],
      leads: [],
      quotations: [],
      explanations: [],
      experiences: [],
      tracings: [],
      nopays: [],
      closings: [],
      highs: [],
      orders: [],
      totalLeads: [],
      customers_filtered: [],
      customer_selected: {},
      comunication: {},
      needs: [],
      draggableAreas: [],
      customerId: 0,
      leadsFiltered: [],
      owners: []
    }
  },
  methods: {
    redirect() {
      alert('redirect desde otro componente')
      /*   if(){
          this.$router.push({name:'home-contracts', params:{ idUser: this.customer.id }})
        }else{
          this.$router.push({name:'home-orders', params:{ idUser: this.customer.id }})
        } */

    },
    updateInterest(newCustomer) {
      console.log(newCustomer);
      var customerSelected = this.leadsFiltered.find(lead => lead.id == newCustomer.id)
      customerSelected.interest = newCustomer.interest
      this.customer_selected.interest = newCustomer.interest
    },
    updateComunication(customer) {
      var customerSelected = this.leadsFiltered.find(lead => lead.id == customer.id)
      customerSelected.comunications = []
      customerSelected.comunications.push(customer.comunications)
      console.log(customer)
    },
    updateOwner(newCustomer, newOwner) {
      let arraysByStatus = {
        4: this.needs,
        5: this.quotations,
        6: this.explanations,
        7: this.experiences,
        8: this.tracings,
        9: this.nopays,
        10: this.closings,
        11: this.customers
      }
      let arraySelected = arraysByStatus[newCustomer.status]

      var customerSelected = arraySelected.find(customer => customer.id == newCustomer.id)
      customerSelected.user = newOwner
    },
    showModalUpdateData(customer) {
      this.customer_selected = customer
      $('#funnelModal').modal('hide')
      $('#customerModal').modal('show')
    },
    updateStatusSpace(leadId, status) {
      //$('#funnelModal').modal('hide')
      console.log(status)
      this.updateStatusSpaces(leadId, status)
    },
    showModalFunnel(customer) {
      this.customer_selected = customer
      $('#funnelModal').modal('show')
    },
    updateStatusSpaces(leadId, status) {

      if (status == 5) {
        $('#funnelModal').modal('hide')
        this.$router.push({ name: 'home-quotation', params: { idUser: leadId } });
      } else if (status == 9) {
        $('#funnelModal').modal('hide')
        var leadSelected = this.totalLeads.find(customer => customer.id == leadId)

        if (leadSelected.quotations[0].amount < 1500) {
          this.$router.push({ name: 'home-orders', params: { idUser: leadId } });
        } else {
          this.$router.push({ name: 'home-contracts', params: { idUser: leadId } });
        }

      } else {
        var leadSelected = this.leadsFiltered.find(customer => customer.id == leadId)
        console.log(leadSelected)
        if (leadSelected.user != null && leadSelected.user.id == this.store.authUser.id) {
          if (this.verifyChange(leadSelected, status)) {
            var firstStatus = leadSelected.status
            leadSelected.status = status
            this.removeLead(firstStatus, leadId)
            this.addLead(leadSelected, status)
          }
        } else {
          this.$swal.fire({
            title: 'Este lead no te pertenece, tienes la seguridad de actualizarlo?',
            showDenyButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              if (this.verifyChange(leadSelected, status)) {
                var firstStatus = leadSelected.status
                leadSelected.status = status
                this.removeLead(firstStatus, leadId)
                this.addLead(leadSelected, status)
              }
            } else if (result.isDenied) {

            }
          })
        }



      }
    },
    verifyChange(customer, status) {
        /* if(status >=5 && status < 9){
          console.log('verificando estado menor a 9')
          if(customer.quotations.length != 0){
            return true
          }else{
            this.$swal.fire('Este usuario no cuenta con una cotización')
          }
        }else */ if (status >= 9) {
        console.log('verificando estado mayor a 9', customer.quotations[0].order)
        if (customer.quotations[0].order != null || customer.quotations[0].contract != null) {
          return true
        } else {
          this.$swal.fire('Este usuario no cuenta con una orden o contrato')
        }
      } else {
        return true
      }
    },
    removeLead(firstStatus, leadId) {
      console.log(firstStatus, leadId)
      let arraysByStatus = {
        4: this.needs,
        5: this.quotations,
        6: this.explanations,
        7: this.experiences,
        8: this.tracings,
        9: this.nopays,
        10: this.closings,
        11: this.customers
      }
      let arraySelected = arraysByStatus[firstStatus]

      let index = arraySelected.findIndex(el => el.id == leadId)
      arraySelected.splice(index, 1)
    },
    addLead(lead, status) {
      let arraysByStatus = {
        4: this.needs,
        5: this.quotations,
        6: this.explanations,
        7: this.experiences,
        8: this.tracings,
        9: this.nopays,
        10: this.closings,
        11: this.customers
      }
      let array = arraysByStatus[status]

      array = array.unshift(lead)
      this.updateInBd(lead.id, status)
      //this.updateStatusSpace(lead.id, status)
      if (status == 11) {
        this.setProject(lead.id)
      }
    },
    updateInBd(id, status) {
      const fd = new FormData()
      fd.append('customer_id', id)
      fd.append('status', status)
      fd.append('user_id', this.store.authUser.id)
      axios.post('/api/updateCustomerGrade', fd)
        .then(res => {
          console.log(res.data)
        })
        .catch(err => {
          console.log(err)
        })
    },
    /* updateStatusSpace(id, status){
      axios.get(`/api/updateCustomerGrade/${id}/${status}`)
      .then(res =>{
          console.log(res.data)
      })
      .catch(err =>{
          console.log(err)
      })
    },
    */
    callModal(com) {
      console.log(com)
      this.comunication = com
      this.customerId = com.id
      $('#funnelModal').modal('hide')
      $('#updateComModal').modal('show')
    },
    filterDate(date) {
      if (date == '') {
        this.distributeLeads(this.totalLeads)
      } else {
        axios.get('/api/getLeadsByDate/' + date)
          .then(res => {
            this.distributeLeads(res.data)
          })
        this.customers_filtered = this.totalLeads.filter((customer) => customer.comunication && customer.comunication.next_management == date)
        this.distributeLeads(this.customers_filtered)
      }
      console.log(this.customers_filtered)
    },
    getAllCustomers() {
      this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
      })
      axios.get('/api/leads')
        .then(res => {
          this.totalLeads = res.data
          this.distributeLeads(this.totalLeads)

          this.customers_filtered = this.totalLeads
          this.$swal().close()
        })
        .catch(err => {
          console.log(err)
        })
    },
    distributeLeads(leads) {

      this.leadsFiltered = leads

      leads.forEach(customer => {
        if (customer.comunications) {
          const ids = customer.comunications.map(comunication => {
            return comunication.id;
          });
          const max = Math.max(...ids);
          customer.lastManagement = customer.comunications.find(element => element.id === max);
        }
      })


      this.needs = []
      this.quotations = []
      this.explanations = []
      this.experiences = []
      this.tracings = []
      this.nopays = []
      this.closings = []
      this.customers = []


      this.leadsFiltered.forEach(lead => {
        if (lead.status == 4) {
          this.needs.push(lead)
        } else if (lead.status == 5) {
          this.quotations.push(lead)
        } else if (lead.status == 6) {
          this.explanations.push(lead)
        } else if (lead.status == 7) {
          this.experiences.push(lead)
        } else if (lead.status == 8) {
          this.tracings.push(lead)
        } else if (lead.status == 9) {
          this.nopays.push(lead)
        } else if (lead.status == 10) {
          this.closings.push(lead)
        } else if (lead.status == 11) {
          this.customers.push(lead)
        }
      });
      this.draggableAreas = [
        {
          customers: this.needs,
          title: 'Obtención de necesidades específicas',
          status: 4
        },
        {
          customers: this.quotations,
          title: 'Con Cotización',
          status: 5
        },
        {
          customers: this.explanations,
          title: 'Explicación de Cotización',
          status: 6
        },
        {
          customers: this.experiences,
          title: 'Explicación de la Experiencia',
          status: 7
        },
        {
          customers: this.tracings,
          title: 'Seguimientos',
          status: 8
        },
        {
          customers: this.nopays,
          title: 'Cierre no pagado',
          status: 9
        },
        {
          customers: this.closings,
          title: 'Seguimiento de cierre',
          status: 10
        },
        {
          customers: this.customers,
          title: 'Cliente',
          status: 11
        }
      ]
    },
    selectCustomer(customer) {
      console.log('customer selected')
      this.customer_selected = customer
    },
    allowDrop(e) {
      e.preventDefault()

      e.dataTransfer.dropEffect = 'move';
    },
    drop(e) {
      e.preventDefault()
      var data = e.dataTransfer.getData("id_card");
      e.target.appendChild(document.getElementById(data));
      console.log(e.target)
    },
    updateStatus(id, status) {
      axios.get(`/api/updateCustomerGrade/${id}/${status}`)
        .then(res => {
          console.log(res.data)
        })
        .catch(err => {
          console.log(err)
        })
    },
    setProject(id) {
      console.log(id)
      const fd = new FormData()
      fd.append('id_customer', id)
      fd.append('emisor_id', this.store.authUser.id)
      axios.post('/api/setProject', fd)
        .then(res => {
          console.log(res)
          this.$swal('Felicidades!, ha conseguido un nuevo cliente para Inbestiga!!')
        })
        .catch(err => {
          this.$swal(err.response.data.msg)
        })
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
    loadCustomerById(userId) {
      console.log(userId);
      var customerSelected = this.totalLeads.find(lead => lead.id == userId)
      console.log(customerSelected);
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
    this.getAllCustomers()
    this.getAllOwners()
    if (this.$route.params.userId) {
      this.loadCustomerById(this.$route.params.userId)
    }
  }
}
</script>
