<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
          <draggableArea :customers="origin" :title="'Origen'" :status="0" @callModal="callModal" @updateStatusSpace="updateStatusSpace" @showModalUpdateData="showModalUpdateData" @showModalFunnel="showModalFunnel"/>
            <draggableArea :customers="noAttended" :title="'No Atendido'" :status="1" @callModal="callModal" @updateStatusSpace="updateStatusSpace" @showModalUpdateData="showModalUpdateData" @showModalFunnel="showModalFunnel"/>
            <draggableArea :customers="attended" :title="'Atendido'" :status="2" @callModal="callModal" @updateStatusSpace="updateStatusSpace" @showModalUpdateData="showModalUpdateData" @showModalFunnel="showModalFunnel"/>
            <draggableArea :customers="comunications" :title="'Comunicación Establecida'" :status="3" @callModal="callModal" @updateStatusSpace="updateStatusSpace" @showModalUpdateData="showModalUpdateData" @convertLead="convertLead" @cleanLead="cleanLead" @showModalFunnel="showModalFunnel"/>
          </div>
      <ProductModal :customer="customerSelected" @getAllCustomers="getAllCustomers"/>
      <!-- <UpdateCom :comunication="comunication"/>   -->
    </div>
      <OwnerModal :customerId="customerId" @convertLead="convertLead" @cleanLead="cleanLead"/>
      <customerModal :customer="customer" :action="2"/>
      <FunnelModal :customer="customer_selected"/>
</template>
<script>
import axios from 'axios'
import CardCustomer from './CardCustomer.vue'
import ProductModal from '../funnel/ProductModal.vue'
import draggableArea from '../funnel/draggableArea.vue'
import UpdateCom from '../prelead/UpdateCom.vue'
import OwnerModal from './OwnerModal.vue'
import customerModal from '../customers/customerModal.vue'
import FunnelModal from '../funnel/FunnelModal.vue'

export default {
    components: {CardCustomer, ProductModal, draggableArea, UpdateCom, OwnerModal, customerModal, FunnelModal},
    data(){
        return{
          customers:[],
          attended:[],
          noAttended:[],
          comunications:[],
          origin:[],
          status: 0,
          customerSelected: null,
          comunication: null,
          customerId:0,
          customer:{},
          customer_selected:{}
        }
    },
    methods:{
      showModalFunnel(customer){
      this.customer_selected = customer
      $('#funnelModal').modal('show')
      },
      cleanLead(id){
        var customerSelected = this.comunications.find(lead => lead.id == id)
        customerSelected.status = 3
      },
      convertLead(id){
        this.customerId = id
        $('#ownerModal').modal('show')
      },
        updateStatusSpace(customer_id, newStatus){
          var customerSelected = this.customers.find(customer => customer.id == customer_id)

          if(newStatus == 3){
            if(customerSelected.name == null || customerSelected.cell == null){
              this.$swal('El usuario carece de información básica necesaria (nombre o número de celular)')
            }else{
              var oldStatus = customerSelected.status

            console.log(oldStatus)

            let arraysByStatus = {
              0: this.origin,
              1: this.noAttended,
              2: this.attended,
              3: this.comunications
            }

            let index = arraysByStatus[oldStatus].findIndex(el => el.id == customerSelected.id)

            arraysByStatus[oldStatus].splice(index, 1)
            customerSelected.status = newStatus
            arraysByStatus[newStatus].unshift({...customerSelected})

            this.updateStatus(customer_id, newStatus)
            }
          }else{
            var oldStatus = customerSelected.status

            console.log(oldStatus)

            let arraysByStatus = {
              0: this.origin,
              1: this.noAttended,
              2: this.attended,
              3: this.comunications
            }

            let index = arraysByStatus[oldStatus].findIndex(el => el.id == customerSelected.id)

            arraysByStatus[oldStatus].splice(index, 1)
            customerSelected.status = newStatus
            arraysByStatus[newStatus].unshift({...customerSelected})

            this.updateStatus(customer_id, newStatus)
          }

        },
        callModal(com){
          this.comunication = com
          $('#updateComModal').modal('show')
        },
        showModalUpdateData(customer){
          this.customer = customer
          $('#customerModal').modal('show')
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
                  if(customer.status == 0){
                    this.origin.push(customer)
                  }
                  else if(customer.status == 1){
                    this.noAttended.push(customer)
                  }else if(customer.status == 2){
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