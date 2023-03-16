<template>
  <div class="container-xxl flex-grow-1 container-p-y"> 
    <div class="row">
      <DatePicker @filterDate="filterDate" />
      <draggableArea :customers="leads" @callModal="callModal" :title="'Lead'" :status="3" @updateStatusSpace="updateStatusSpaces"/>
      <draggableArea :customers="quotations" @callModal="callModal" :title="'Con Cotización'"  :status="4" @updateStatusSpace="updateStatusSpaces"/>
      <draggableArea :customers="highs" @callModal="callModal" :title="'Altamente interesado'" :status="5" @updateStatusSpace="updateStatusSpaces"/>
      <draggableArea :customers="orders" @callModal="callModal" :title="'Con Contrato'" :status="6" @updateStatusSpace="updateStatusSpaces"/>
      <draggableArea :customers="customers" @callModal="callModal" :title="'Cliente'" :status="7" @updateStatusSpace="updateStatusSpaces"/>
    </div>
    <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>
    <UpdateCom :comunication="comunication"/>
  </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import {useCounterStore} from '../../../stores/UserStore'
import draggableArea from './draggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'

export default{
  setup(){
      const store = useCounterStore()
      return{
        store
      }
  },
  components:{ CardCustomer, ProductModal, draggableArea, DatePicker, UpdateCom },
  data(){
    return{
      customers:[],
      leads:[],
      quotations:[],
      highs:[],
      orders:[],
      totalLeads:[],
      customers_filtered:[],
      customer_selected:{},
      comunication:{}
    }
  },
  methods:{
    updateStatusSpaces(leadId, status){

      console.log(leadId)
      
      var leadSelected = this.totalLeads.find(customer => customer.id == leadId)

      var firstStatus = leadSelected.status

      leadSelected.status = status

      this.removeLead(firstStatus, leadId)
      
      this.addLead(leadSelected, status)
      
    },
    removeLead(firstStatus, leadId){
      console.log(firstStatus, leadId)
      let arraysByStatus = {
        3: this.leads,
        4: this.quotations,
        5: this.highs,
        6: this.orders,
        default: this.customers
      }
      let arraySelected = arraysByStatus[firstStatus]

      let index = arraySelected.findIndex(el => el.id == leadId)
      arraySelected.splice(index, 1)
    },
    addLead(lead, status){
      let arraysByStatus = {
        3: this.leads,
        4: this.quotations,
        5: this.highs,
        6: this.orders,
        default: this.customers
      }
      let array = arraysByStatus[status]

      array = array.unshift(lead)
      this.updateStatusSpace(lead.id, status)
    },
    updateStatusSpace(id, status){
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
    },
    filterDate(date){
        this.$swal({
          title: 'Cargando ...',
          allowOutsideClick: false,
          showConfirmButton: false
        })
        if(date == ''){
          this.customers_filtered = this.customers
          this.$swal().close()
        }else{
          this.customers_filtered = this.customers.filter((customer) => customer.comunication && customer.comunication.next_management == date)
          this.$swal().close()
        }
    },
    getAllCustomers(){
      this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
      })
      axios.get('/api/getAllLeads')
      .then(res =>{
          this.totalLeads = res.data

          this.totalLeads.forEach(lead => {
            if(lead.status == 3){
              this.leads.push(lead)
            }else if(lead.status == 4){
              this.quotations.push(lead)
            }else if(lead.status == 5){
              this.highs.push(lead)
            }else if(lead.status == 6){
              this.orders.push(lead)
            }else{
              this.customers.push(lead)
            }
          });


          this.customers_filtered = this.totalLeads
          this.$swal().close()
      })
      .catch(err =>{
          console.log(err.response.data)
      })
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
          this.getAllCustomers()
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
      fd.append('emisor_id', this.store.authUser[0].id)
      axios.post(`/api/setProject`, fd)
      .then(res =>{
        console.log(res)
        this.getAllCustomers()
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
