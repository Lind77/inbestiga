<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <DatePicker class="ms-4" @filterDate="filterDate" @distributeQuotations="distributeQuotations"
      @getAllQuotations="getAllQuotations" />
    <!-- <div class="container-override">
      <div class="first-container"></div>
      <div class="second-container"></div>
      <div class="third-container"></div>
    </div> -->
    <div class="d-flex justify-content-between w-100">
      <i class='bx bx-chevron-left text-white arrow cursor-pointer' @click="moveFunnelLeft"></i>
      <i class='bx bx-chevron-right text-white arrow cursor-pointer' @click="moveFunnelRigth"></i>
    </div>
    <div class="container-override" id="funnelContainer">
      <template v-for="areaQuotation in draggableQuotations">
        <DraggableArea @updateStatusSpace="updateStatusSpace" @transformQuotation="transformQuotation"
          :customer="areaQuotation.customer" :quotations="areaQuotation.quotations" :title="areaQuotation.title"
          :status="areaQuotation.status" @callModal="callModal" @showModalQuotationFunnel="showModalQuotationFunnel" />
      </template>

    </div>
    <ProductModal :customer="customersSelected" @getAllCustomers="getAllCustomers" />
    <UpdateCom :customerId="customerId" :customer="customerToComunication" :comunication="comunication"
      @addNewComunication="addNewComunication" />
    <FunnelModal :quotation="quotation" :owners="owners" @updateStatusSpace="updateStatusSpace" @callModal="callModal"
      @showModalUpdateData="showModalUpdateData" @getAllCustomers="getAllCustomers" @updateOwner="updateOwner"
      @getAllQuotations="getAllQuotations" @updateOwnerQuotation="updateOwnerQuotation" @updateInterest="updateInterest"
      @callModalComunication="callModalComunication" />
    <customerModal :customer="customer_selected" :action="2" />
  </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import { userStore } from '../../../stores/UserStore'
import DraggableArea from './DraggableArea.vue'
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
  components: { CardCustomer, ProductModal, DraggableArea, DatePicker, UpdateCom, FunnelModal, customerModal },
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
      customersSelected: [],
      comunication: {},
      needs: [],
      draggableAreas: [],
      draggableQuotations: [],
      customerId: 0,
      leadsFiltered: [],
      owners: [],
      totalQuotations: [],
      quotation: {},
      customerToComunication: {},
      customer_selected: {},
      initialPage: 0
    }
  },
  methods: {
    moveFunnelRigth() {

      if (this.initialPage < this.draggableQuotations.length - 1) {
        this.initialPage++;
        var percent = ((this.initialPage) * 17) * -1
        console.log(percent)
        $('#funnelContainer').css('transform', `translate(${percent}%, 0)`)
        /* $('#funnelContainer').removeClass('moveFunnelRigth') */
      }

    },
    moveFunnelLeft() {
      if (this.initialPage != 0) {
        this.initialPage--;
        var percent = ((this.initialPage) * 17) * -1
        console.log(percent)
        $('#funnelContainer').css('transform', `translate(${percent}%, 0)`)
      }

    },
    addNewComunication(comunication, customer) {
      let arraysByStatus = {
        5: this.quotations,
        6: this.explanations,
        7: this.experiences,
        8: this.tracings,
        9: this.nopays,
        10: this.closings,
        11: this.customers
      }

      var arraySelected = arraysByStatus[customer.status];



      var quotationSelected = arraySelected.find(quotation => quotation.customers && quotation.customers[0].id == customer.id)

      quotationSelected.customers[0].comunications.push(comunication)

      this.quotation = quotationSelected

      $('#funnelModal').modal('show')

    },
    callModalComunication(customer) {
      console.log(customer);
      this.customerToComunication = customer
      if (customer.comunication == null) {
        this.action = 1
      }
      $('#updateComModal').modal('show')
    },
    showModalQuotationFunnel(quotation) {
      this.quotation = quotation
      $('#funnelModal').modal('show')
      console.log('Im in home funnel', quotation);
    },
    transformQuotation(leadId) {
      this.$router.push({ name: 'home-quotation', params: { idCustomer: leadId } });
    },
    redirect() {
      alert('redirect desde otro componente')
      /*   if(){
          this.$router.push({name:'home-contracts', params:{ idUser: this.customer.id }})
        }else{
          this.$router.push({name:'home-orders', params:{ idUser: this.customer.id }})
        } */

    },
    updateInterest(newQuotation) {
      console.log(newQuotation);
      let arraysByStatus = {
        5: this.quotations,
        6: this.explanations,
        7: this.experiences,
        8: this.tracings,
        9: this.nopays,
        10: this.closings,
        11: this.customers
      }

      var arraySelected = arraysByStatus[newQuotation.status];
      var quotationSelected = arraySelected.find(quotation => quotation.id == newQuotation.id)
      quotationSelected.interest = newQuotation.interest
      //var customerSelected = this.leadsFiltered.find(lead => lead.id == newCustomer.id)
      //this.customerSelected[0].interest = newCustomer.interest

      //this.customer_selected.interest = newCustomer.interest
    },
    updateComunication(customer) {
      var customerSelected = this.leadsFiltered.find(lead => lead.id == customer.id)
      customerSelected.comunications = []
      customerSelected.comunications.push(customer.comunications)
      console.log(customer)
    },
    updateOwner(newCustomer, newOwner) {
      console.log(newCustomer, newOwner);
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

      if (newCustomer.status > 4) {
        var customerSelected = arraySelected.find(quotation => quotation.customers[0].id == newCustomer.id)
        console.log(customerSelected);
        //customerSelected.user = newOwner
      } else {
        var customerSelected = arraySelected.find(customer => customer.id == newCustomer.id)
        customerSelected.user = newOwner
      }
    },
    updateOwnerQuotation(newQuotation, newOwner) {
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

      let arraySelected = arraysByStatus[newQuotation.status]
      var quotationSelected = arraySelected.find(quotation => quotation.id == newQuotation.id)


      console.log(quotationSelected);
      quotationSelected.customers.forEach(customer => {
        customer.user = newOwner
      });
    },
    convertCustomerQuotation(leadId) {
      console.log(leadId);
    },
    showModalUpdateData(customer) {
      console.log(customer);
      this.customer_selected = customer
      $('#funnelModal').modal('hide')
      $('#customerModal').modal('show')
    },
    updateStatusSpace(quotationId, status) {
      //$('#funnelModal').modal('hide')
      console.log(quotationId, status)
      this.updateStatusSpaces(quotationId, status)
    },
    showModalFunnel(quotation) {
      /* console.log(customers);
      this.customersSelected = customers */
      this.quotation = quotation
      $('#funnelModal').modal('show')
    },
    updateStatusSpaces(quotationId, status) {
      console.log(quotationId, status);
      if (status == 9) {
        $('#funnelModal').modal('hide')
        var quotSelected = this.totalQuotations.find(quotation => quotation.id == quotationId)
        this.$router.push({ name: 'home-docs', params: { customerId: quotSelected.customers[0].id } })
        /* var leadSelected = this.totalLeads.find(customer => customer.id == leadId)
        if (leadSelected.quotations[0].amount < 1500) {
          this.$router.push({ name: 'home-orders', params: { idUser: leadId } });
        } else {
          this.$router.push({ name: 'home-contracts', params: { idUser: leadId } });
        } */
      } else if (status == 11) {
        this.updateInBd(quotationId, status)
        this.removeLead(10, quotationId)
      } else {
        console.log(quotationId, 'updateando a status 11');
        var quotSelected = this.totalQuotations.find(quotation => quotation.id == quotationId)
        console.log(quotSelected)
        if (quotSelected.customers[0].user_id == this.store.authUser.id) {
          if (this.verifyChange(quotSelected, status)) {
            var firstStatus = quotSelected.status
            quotSelected.status = status
            this.removeLead(firstStatus, quotationId)
            this.addLead(quotSelected, status)
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
              if (this.verifyChange(quotSelected, status)) {
                var firstStatus = quotSelected.status
                quotSelected.status = status
                this.removeLead(firstStatus, quotationId)
                this.addLead(quotSelected, status)
              }
            }
          })
        }
      }
    },
    verifyChange(quotation, status) {
      /* if(status >=5 && status < 9){
        console.log('verificando estado menor a 9')
        if(customer.quotations.length != 0){
          return true
        }else{
          this.$swal.fire('Este usuario no cuenta con una cotización')
        }
      }else  if (status >= 9) {
      console.log('verificando estado mayor a 9', quotation.customers[0].quotations[0].order)
      if (quotation.customers[0].quotations[0].order != null || quotation.customers[0].quotations[0].contract != null) {
        return true
      } else {
        this.$swal.fire('Este usuario no cuenta con una orden o contrato')
      }
    } else {
      return true
    }*/
      return true;
    },
    removeLead(firstStatus, quotationId) {
      console.log(firstStatus, quotationId)
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

      let index = arraySelected.findIndex(el => el.id == quotationId)
      arraySelected.splice(index, 1)
    },
    addLead(quotation, status) {
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

      array = array.unshift(quotation)
      this.updateInBd(quotation.id, status)
      //this.updateStatusSpace(lead.id, status)
      if (status == 11) {
        this.setProject(quotation.id)
      }
    },
    updateInBd(id, status) {
      const fd = new FormData()
      fd.append('quotation_id', id)
      fd.append('status', status)
      fd.append('user_id', this.store.authUser.id)
      axios.post('/api/update-quotation-status', fd)
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
      this.customers = []


      this.leadsFiltered.forEach(lead => {
        if (lead.status == 4) {
          this.needs.push(lead)
        } /* else if (lead.status == 11) {
          this.customers.push(lead)
        } */
      });
      this.draggableAreas = [
        /* {
          customers: this.needs,
          title: 'Obtención de necesidades específicas',
          status: 4
        } */
        /* {
          customers: this.customers,
          title: 'Cliente',
          status: 11
        } */
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
    setProject(quotationId) {
      console.log(quotationId)
      const fd = new FormData()
      fd.append('quotationId', quotationId)
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
    getAllQuotations() {
      axios.get('/api/quotations-funnel')
        .then(res => {
          this.totalQuotations = res.data
          this.distributeQuotations(this.totalQuotations)

        })
        .catch(err => {
          console.error(err)
        })
    },
    distributeQuotations(quotations) {

      this.totalQuotations = quotations

      this.quotations = []
      this.explanations = []
      this.experiences = []
      this.tracings = []
      this.nopays = []
      this.closings = []

      quotations.forEach(quotation => {
        if (quotation.status == 5) {
          this.quotations.push(quotation)
        } else if (quotation.status == 6) {
          this.explanations.push(quotation)
        } else if (quotation.status == 7) {
          this.experiences.push(quotation)
        } else if (quotation.status == 8) {
          this.tracings.push(quotation)
        } else if (quotation.status == 9) {
          this.nopays.push(quotation)
        } else if (quotation.status == 10) {
          this.closings.push(quotation)
        }
      })

      this.draggableQuotations = [
        {
          quotations: this.quotations,
          title: 'Con Cotización',
          status: 5
        },
        {
          quotations: this.explanations,
          title: 'Explicación de Cotización',
          status: 6
        },
        {
          quotations: this.experiences,
          title: 'Explicación de la Experiencia',
          status: 7
        },
        {
          quotations: this.tracings,
          title: 'Seguimientos',
          status: 8
        },
        {
          quotations: this.nopays,
          title: 'Cierre no pagado',
          status: 9
        },
        {
          quotations: this.closings,
          title: 'Seguimiento de cierre',
          status: 10
        }
      ]
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
    this.getAllQuotations()
    this.getAllOwners()
    if (this.$route.params.userId) {
      this.loadCustomerById(this.$route.params.userId)
    }
  }
}
</script>
<style scoped>
.container-override {
  z-index: 2;
  width: 120vw;
  padding: 2px;
  display: inline-flex;
  align-items: center;
  transition: 1s;
}

.arrow {
  color: #696cff !important;
  font-size: 50px;
}

.moveFunnelLeft {
  transform: translate(-19.8%, 0);
  transition: 1s;
}

.moveFunnelRigth {
  transform: translate(0%, 0);
  transition: 1s;
}

.first-container {
  background-color: red;
  width: 30vw;
  height: 30px;
}

.second-container {
  background-color: blue;
  width: 30vw;
  height: 30px;
}

.third-container {
  background-color: gray;
  width: 30vw;
  height: 30px;
}
</style>
