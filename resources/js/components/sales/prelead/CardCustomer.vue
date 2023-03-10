<template>
    <div class="card bg-light mb-2 p-2 cursor-pointer" draggable="true" @dragover="allowDrop" @dragstart="drag" :id="`${customer.id}`">
        <h6 class="mb-0">{{ customer.name || customer.cell }}</h6>
        <div class="demo-inline-spacing">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-user'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p>Celular: {{ customer.cell }}</p>
                        <p>Universidad: {{ customer.university }}</p>
                        <p>Carrera: {{ customer.career }}</p>
                        <p>Email: {{ customer.email }}</p>
                    </li>
                </ul>
            </div>

            <div class="btn-group" v-if="customer.comunication">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-chat'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p>1ra Gestión: {{ formatDate(customer.comunication.first_management) }}</p>
                        <p>Última Gestión: {{ formatDate(customer.comunication.last_management) }}</p>
                        <p>Siguiente Gestión: {{ formatDate(customer.comunication.next_management) }}</p>
                        <p>Producto tentativo: {{ customer.comunication.product_tentative }}</p>
                        <p>Tipo: {{ comunication[customer.comunication.type] }}</p>
                        <p>Comentario: {{ customer.comunication.comment }}</p>
                    </li>
                </ul>
            </div>

            <div class="btn-group" v-if="customer.quotations.length != 0">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-file'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p class="mb-0">Cotizaciones :</p>
                        <template v-for="quotation in customer.quotations">
                            <router-link target="_blank" :to="{name:'quotation-file', params:{ id: quotation.id }}"  class="btn btn-success w-100 mt-1">{{ formatDate(quotation.date) }}</router-link>
                            <template v-if="quotation.orders">
                                <template v-for="order in quotation.orders">
                                    <router-link target="_blank" :to="{name:'order-file', params:{ id: order.id }}"  class="btn btn-info mt-1">{{ formatDate(order.created_at) }}</router-link>
                                </template>
                            </template>
                        </template>
                        
                       
                    </li>
                </ul>
            </div>

            <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-dots-vertical-rounded'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                <li>
                    <a class="dropdown-item" v-if="customer.status == 2" @click="convertLead(customer.id)" href="javascript:void(0);">Convertir en Lead</a>
                </li>   
                <li>
                    <router-link class="dropdown-item" v-if="customer.status == 3" :to="{name:'home-quotation', params:{ idUser: customer.id }}">Generar Cotización</router-link>
                </li>
                <li>
                    <router-link class="dropdown-item" v-if="customer.status == 5" :to="{name:'home-orders', params:{ idUser: customer.id }}">Generar Orden</router-link>
                </li>
                <li><a class="dropdown-item" @click="customerStandBy(customer.id)" href="javascript:void(0);">Stand By</a></li>
                </ul>
        </div>
    </div>
    <!-- <div class="btn-group pt-2" draggable="true" @dragstart="drag" :id="`${customer.id}`">
        <button type="button" :class="`btn btn-${bgColor} text-truncate`">{{ customer.name || customer.cell }}</button>
        <button type="button" :class="`btn btn-${bgColor} dropdown-toggle dropdown-toggle-split`" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
          <li class="ps-2">
            <template v-if="customer.comunication">
                <p class="mb-0">Primera comunicación: {{customer.comunication.first_management}}</p>
                <p class="mb-0">Última comunicación: {{customer.comunication.last_management}}</p>
                <p class="mb-0">Próxima comunicación: {{customer.comunication.next_management}}</p>
                <p class="mb-0">Comentario: {{customer.comunication.comment}}</p>
                <p class="mb-0">Producto Tentativo: {{customer.comunication.product_tentative}}</p>
                <p class="mb-0">Tipo: {{customer.comunication.type}}</p>
            </template>
            
            <p class="mb-0">Universidad: {{ customer.university }}</p>
            <p class="mb-0">Celular: {{ customer.cell }}</p>
            <p class="mb-0">Correo: {{ customer.email }}</p>
          </li>
          <li><a class="dropdown-item"  href="javascript:void(0);">Stand By</a></li>
          <li></li>
          <li></li>
        </ul>
    </div> -->
</template>
<script>
import moment from 'moment'

    export default{
        data(){
            return{
                customer_selected:{},
                comunication:{
                    1: 'Llamar',
                    2: 'Escribir',
                    3: 'Meet'
                }
            } 
        },
        props:{
            customer: Object,
            status: Number,
            visible: Boolean
        },
        methods:{
            formatDate(date){
                return moment(date).format('DD/MM/YYYY')
            },
            customerStandBy(id){
                this.$swal.fire('Tienes la seguridad de enviar a este usuario a stand by?')
                .then((res) =>{
                    if(res.isConfirmed){
                        axios.get('/api/standByCustomer/'+id)
                        .then(res =>{
                            console.log(res)
                        })
                        .catch(err =>{

                        })
                    }
                })
            },
            allowDrop(e){
                return
            },
            drag(e){
                e.dataTransfer.setData('id_card', this.customer.id)
            },
            rejectDrop(id){
                e.preventDefault()
            },
            convertLead(id){
                this.$swal.fire('Tienes la seguridad de convertir a este usuario en un lead?')
                .then((res) => {
                    if(res.isConfirmed){
                        axios.get(`/api/updateCustomerGrade/${id}/3`)
                        .then(res =>{
                            console.log(res)
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
<style scoped>
.pt-10{
    margin-top: 100px;
}
</style>