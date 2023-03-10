<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
            <draggableArea :customers="customers" :title="'Atendido'" :status="1"/>
            <draggableArea :customers="customers" :title="'Comunicación Establecida'" :status="2"/>
          </div>
      <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>  
    </div>
</template>
<script>
import axios from 'axios'
import CardCustomer from './CardCustomer.vue'
import ProductModal from '../funnel/ProductModal.vue'
import draggableArea from '../funnel/draggableArea.vue'

export default {
    components: {CardCustomer, ProductModal, draggableArea},
    data(){
        return{
        customers:[],
        status: 0,
        customer_selected:{}
        }
    },
    methods:{
        getAllCustomers(){
        this.$swal({
        title: 'Cargando ...',
        allowOutsideClick: false,
        showConfirmButton: false
        })
        axios.get('/api/getAllCustomers')
        .then(res =>{
            this.customers = res.data
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
        drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData("text");
          
        },
        allowDrop(e){
          e.preventDefault()
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