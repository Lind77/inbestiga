<template>
  <div class="container-xxl flex-grow-1 container-p-y"> 
    <div class="row">
      <DatePicker @filterDate="filterDate" />
      <template v-for="area in draggableAreas">
        <draggableArea :customers="area.customers" :title="area.title" :status="area.status" @updateStatusSpace="updateStatusSpace" @showModalFunnel="showModalFunnel"/>
      </template>
    </div>
    <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>
    <UpdateCom :comunication="comunication"/>
    <FunnelModal :customer="customer_selected" @updateStatusSpace="updateStatusSpace"/>
  </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import {userStore} from '../../../stores/UserStore'
import draggableArea from './draggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'
import FunnelModal from './FunnelModal.vue'

export default{
  setup(){
      const store = userStore()
      return{
        store
      }
  },
  components:{ CardCustomer, ProductModal, draggableArea, DatePicker, UpdateCom, FunnelModal},
  data(){
    return{
      customers:[],
      leads:[],
      quotations:[],
      explanations:[],
      experiences:[],
      tracings:[],
      nopays:[],
      closings:[],
      highs:[],
      orders:[],
      totalLeads:[],
      customers_filtered:[],
      customer_selected:{},
      comunication:{},
      needs: [],
      draggableAreas: []
    }
  },
  methods:{
    updateStatusSpace(leadId, status){
      //$('#funnelModal').modal('hide')
      console.log(status)
      this.updateStatusSpaces(leadId, status)
    },
    showModalFunnel(customer){
      this.customer_selected = customer
      $('#funnelModal').modal('show')
    },
    updateStatusSpaces(leadId, status){
      if(status == 5){
        this.$router.push({name:'home-quotation', params:{ idUser: leadId }});
      }else{
        var leadSelected = this.totalLeads.find(customer => customer.id == leadId)
          if(this.verifyChange(leadSelected, status)){
            var firstStatus = leadSelected.status
            leadSelected.status = status
            this.removeLead(firstStatus, leadId)
            this.addLead(leadSelected, status)
          }
      }
    },
    verifyChange(customer, status){
        if(status < 6){
          if(customer.quotations.length != 0){
            return true
          }else{
            this.$swal.fire('Este usuario no cuenta con una cotización')
          }
        }else if(status == 9){
          var i = 0
          customer.quotations.forEach((quot)=>{
            quot.orders.forEach((order)=>{
              i++
            })            
          })
          if(i > 0){
            return true
          }else{
            this.$swal.fire('Este usuario no cuenta con una orden de contrato')
          }
        }else{
          return true
        }
    },
    removeLead(firstStatus, leadId){
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
    addLead(lead, status){
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
      /* this.updateStatusSpace(lead.id, status)
      if(status == 7){
        this.setProject(lead.id)
      } */
    },
    updateInBd(id, status){
      const fd = new FormData()
      fd.append('customer_id', id)
      fd.append('status', status)
      fd.append('user_id', this.store.authUser.id)
      axios.post('/api/updateCustomerGrade', fd)
      .then(res =>{
          console.log(res.data)
      })
      .catch(err =>{
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
    callModal(com){
      this.comunication = com
      $('#updateComModal').modal('show')
    }, */
    filterDate(date){
        if(date == ''){
          this.distributeLeads(this.totalLeads)
        }else{
          this.customers_filtered = this.totalLeads.filter((customer) => customer.comunication && customer.comunication.next_management == date)
          this.distributeLeads(this.customers_filtered)
        }
        console.log(this.customers_filtered)
    },
    getAllCustomers(){
      this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
      })
      axios.get('/api/getAllLeads/'+this.store.authUser.id)
      .then(res =>{
          this.totalLeads = res.data

          this.distributeLeads(this.totalLeads)

          this.customers_filtered = this.totalLeads
          this.$swal().close()
      })
      .catch(err =>{
          console.log(err.response.data)
      })
    },
    distributeLeads(totalLeads){
      totalLeads.forEach(lead => {
            if(lead.status == 4){
              this.needs.push(lead)
            }else if(lead.status == 5){
              this.quotations.push(lead)
            }else if(lead.status == 6){
              this.explanations.push(lead)
            }else if(lead.status == 7){
              this.experiences.push(lead)
            }else if(lead.status == 8){
              this.tracings.push(lead)
            }else if(lead.status == 9){
              this.nopays.push(lead)
            }else if(lead.status == 10){
              this.closings.push(lead)
            }else if(lead.status == 11){
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
    selectCustomer(customer){
      console.log('customer selected')
      this.customer_selected = customer
    },
    allowDrop(e){
          e.preventDefault()
         
          e.dataTransfer.dropEffect = 'move';
    },
    drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData("id_card");
          e.target.appendChild(document.getElementById(data));
          console.log(e.target)
    },
    updateStatus(id, status){
      axios.get(`/api/updateCustomerGrade/${id}/${status}`)
      .then(res =>{
          console.log(res.data)
      })
      .catch(err =>{
          console.log(err)
      })
    },
    setProject(id){
      console.log(id)
      const fd = new FormData()
      fd.append('id_customer', id)
      fd.append('emisor_id', this.store.authUser.id)
      axios.post('/api/setProject', fd)
      .then(res =>{
        console.log(res)
      })
      .catch(err =>{
        this.$swal(err.response.data.msg)
      })
    }
  },
  mounted(){
    this.getAllCustomers()
  }
}
</script>
