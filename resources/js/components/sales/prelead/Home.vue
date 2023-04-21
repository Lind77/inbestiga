<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
          <draggableArea :customers="attended" :title="'Origen'" :status="0" @callModal="callModal" @updateStatusSpace="updateStatusSpace"/>
            <draggableArea :customers="attended" :title="'No Atendido'" :status="1" @callModal="callModal" @updateStatusSpace="updateStatusSpace"/>
            <draggableArea :customers="attended" :title="'Atendido'" :status="2" @callModal="callModal" @updateStatusSpace="updateStatusSpace"/>
            <draggableArea :customers="comunications" :title="'Comunicación Establecida'" :status="3" @callModal="callModal" @updateStatusSpace="updateStatusSpace" @convertLead="convertLead" @cleanLead="cleanLead"/>
          </div>
      <ProductModal :customer="customerSelected" @getAllCustomers="getAllCustomers"/>
      <!-- <UpdateCom :comunication="comunication"/>   -->
    </div>
      <OwnerModal :customerId="customerId" @convertLead="convertLead" @cleanLead="cleanLead"/>
</template>
<script>
import axios from 'axios'
import CardCustomer from './CardCustomer.vue'
import ProductModal from '../funnel/ProductModal.vue'
import draggableArea from '../funnel/draggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'
import OwnerModal from './OwnerModal.vue'


export default {
    components: {CardCustomer, ProductModal, draggableArea, UpdateCom, OwnerModal},
    data(){
        return{
          customers:[],
          attended:[],
          comunications:[],
          status: 0,
          customerSelected: null,
          comunication: null,
          customerId:0
        }
    },
    methods:{
      cleanLead(id){
        var customerSelected = this.comunications.find(lead => lead.id == id)
        customerSelected.status = 3
      },
      convertLead(id){
        this.customerId = id
        $('#ownerModal').modal('show')
      },
        updateStatusSpace(customer_id, status){
          var customerSelected = this.customers.find(customer => customer.id == customer_id)
          customerSelected.status = status
          if(status == 1){
            let index = this.comunications.findIndex(comunication => comunication.id == customerSelected.id)
            this.comunications.splice(index, 1)
            this.attended.unshift({...customerSelected})
            this.updateStatus(customer_id, status)
          }else{
            let index = this.attended.findIndex(el => el.id == customerSelected.id)
            this.attended.splice(index, 1)
            this.comunications.unshift({...customerSelected})
            this.updateStatus(customer_id, status)
          }
            /* if(customerSelected.status == 2){
              this.attended.push(customerSelected)
            }else{
              this.comunications.push(customerSelected)
            } */
        },
        callModal(com){
          this.comunication = com
          $('#updateComModal').modal('show')
        },
        getAllCustomers(){
          this.$swal({
          title: 'Cargando ...',
          allowOutsideClick: false,
          showConfirmButton: false
          })
            axios.get('/api/getAllPreleads')
            .then(res =>{
                this.customers = res.data
                this.customers.forEach(customer =>{
                  if(customer.status == 1){
                    this.attended.push(customer)
                  }else{
                    this.comunications.push(customer)
                  }
                })
                this.$swal().close()
            })
            .catch(err =>{
                console.log(err)
            })
        },
        selectCustomer(customer){
          console.log('customer selected')
          this.customerSelected = customer
        },
        drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData("text");
          
        },
        allowDrop(e){
          e.preventDefault()
        },
        updateStatus(id, status){
          axios.get(`/api/updateCustomerGrade/${id}/${status}`)
          .then(res =>{
              console.log(res.data)
          })
          .catch(err =>{
              console.log(err)
          })
        }
    },
    mounted(){
        this.getAllCustomers()
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
  background: rgba(67,89,113,.7);
}
</style>