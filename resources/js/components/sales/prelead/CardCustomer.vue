<template>
    <div class="btn-group mt-2" draggable="true" @dragstart="drag" :id="`${customer.id}`">
        <button type="button" :class="`btn btn-${bgColor}`">{{ customer.name || customer.cell }}</button>
        <button type="button" :class="`btn btn-${bgColor} dropdown-toggle dropdown-toggle-split`" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" style="">
          <li><a class="dropdown-item" @click="customerStandBy(customer.id)" href="javascript:void(0);">Stand By</a></li>
          <li><router-link class="dropdown-item" v-if="customer.status == 2" :to="{name:'home-quotation', params:{ idUser: customer.id }}">Generar Cotización</router-link></li>
          <li><router-link class="dropdown-item" v-if="customer.status == 5" :to="{name:'home-orders', params:{ idUser: customer.id }}">Generar Orden</router-link></li>
          <!-- <li><a class="dropdown-item" v-if="customer.status == 2" @click="openProductModal(customer)" href="javascript:void(0);">Asignar Producto</a></li> -->
        </ul>
    </div>
</template>
<script>
import axios from 'axios'

    export default{
        data(){
            return{
                customer_selected:{}
            } 
        },
        props:{
            customer: Object,
            status: Number
        },
        methods:{
            customerStandBy(id){
                this.$swal.fire('Tienes la seguridad de enviar a este usuario a stand by?')
                .then((res) =>{
                    if(res.isConfirmed){
                        axios.get('/api/standByCustomer/'+id)
                        .then(res =>{
                            this.$emit('getAllCustomers')
                        })
                        .catch(err =>{

                        })
                    }
                })
            },
            drag(e){
                e.dataTransfer.setData('text', e.target.id)
            },
            convertLead(id){
                this.$swal.fire('Tienes la seguridad de convertir a este usuario en un lead?')
                .then((res) => {
                    if(res.isConfirmed){
                        axios.get(`/api/updateCustomerGrade/${id}/3`)
                        .then(res =>{
                            console.log(res)
                            this.$emit('getAllCustomers')
                        })
                        .catch(err =>{
                            console.log(err)
                        })
                    }
                })
            },
            openProductModal(customer){
                console.log('asignando customer')
                this.$emit('selectCustomer', customer)
                $('#productModal').modal('show')
            }
        },
        computed:{
            bgColor(){
                if(this.customer.status == 0){
                    return 'danger'
                }else if(this.customer.status == 1){
                    return 'warning'
                }else if (this.customer.status == 2){
                    return 'success'
                }else if (this.customer.status >= 3){
                    return 'success'
                }
            }
        }
    }
</script>