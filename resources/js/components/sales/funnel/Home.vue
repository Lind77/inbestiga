<template>
  <div class="container-xxl flex-grow-1 container-p-y"> 
    <div class="row">
      <DatePicker @filterDate="filterDate" />
      <draggableArea :customers="customers_filtered" :title="'Lead'" :status="3"/>
      <draggableArea :customers="customers_filtered" :title="'Con Cotización'"  :status="4"/>
      <draggableArea :customers="customers_filtered" :title="'Altamente interesado'" :status="5"/>
      <draggableArea :customers="customers_filtered" :title="'Con Contrato'" :status="6"/>
      <draggableArea :customers="customers_filtered" :title="'Cliente'" :status="7"/>
    </div>
    <ProductModal :customer="customer_selected" @getAllCustomers="getAllCustomers"/>
  </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
import ProductModal from './ProductModal.vue'
import {useCounterStore} from '../../../stores/UserStore'
import draggableArea from './draggableArea.vue'

export default{
  setup(){
      const store = useCounterStore()
      return{
        store
      }
  },
  components:{ CardCustomer, ProductModal, draggableArea, DatePicker },
  data(){
    return{
      customers:[],
      customers_filtered:[],
      customer_selected:{}
    }
  },
  methods:{
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
      axios.get('/api/getAllCustomers')
      .then(res =>{
          this.customers = res.data
          this.customers_filtered = this.customers
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
