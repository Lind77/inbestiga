<template>
    <div class="cardSpace" draggable="true" @dragover.prevent @drop.stop.prevent @dragstart="drag" :id="`${customer.id}`">
        <div class="card bg-light p-2 cursor-pointer">
        <h6 class="mb-0">{{ customer.name || customer.cell }}</h6>
        <div class="demo-inline-spacing">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-user'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p><span class="fw-bold">Celular:</span><br> {{ customer.cell }}</p>
                        <p><span class="fw-bold">Universidad:</span><br> {{ customer.university }}</p>
                        <p><span class="fw-bold">Carrera:</span><br> {{ customer.career }}</p>
                        <p><span class="fw-bold">Email: </span><br> {{ customer.email }}</p>
                    </li>
                </ul>
            </div>

            <div class="btn-group" v-if="customer.comunication">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-chat'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p> <span class="fw-bold"> 1ra Gestión:</span>
                           <br> {{ formatDate(customer.comunication.first_management) }}
                        </p>
                        <p> <span class="fw-bold"> Última Gestión:</span>
                           <br> {{ formatDate(customer.comunication.last_management) }}
                        </p>
                        <p> <span class="fw-bold"> Siguiente Gestión:</span>
                           <br> {{ formatDate(customer.comunication.next_management) }}
                        </p>
                        <p> <span class="fw-bold"> Producto tentativo:</span>
                           <br> {{ customer.comunication.product_tentative }}
                        </p>
                        <p> <span class="fw-bold"> Tipo:</span>
                           <br> {{ comunication[customer.comunication.type] }}
                        </p>
                        <p> <span class="fw-bold"> Comentario:</span>
                           <br> {{ customer.comunication.comment }}
                        </p>
                        <button @click="showModalUpdateCom" class="btn btn-sm btn-primary">Actualizar</button>
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
                        </template>
                    </li>
                </ul>
            </div>
            <div class="btn-group" v-if="verifyOrders">
                <button type="button" class="btn btn-primary btn-sm btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-copy-alt'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="p-2">
                        <p class="mb-0">Ordenes:</p>
                        <template v-for="quotation in customer.quotations">
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
                    <a class="dropdown-item" v-if="statusCard == 2" @click="convertLead(customer.id)" href="javascript:void(0);">Convertir en Lead</a>
                </li>   
                <li>
                    <router-link class="dropdown-item" v-if="statusCard == 3" :to="{name:'home-quotation', params:{ idUser: customer.id }}">Generar Cotización</router-link>
                </li>
                <li>
                    <router-link class="dropdown-item" v-if="statusCard == 5" :to="{name:'home-orders', params:{ idUser: customer.id }}">Generar Orden</router-link>
                </li>
                <li><a class="dropdown-item" @click="customerStandBy(customer.id)" href="javascript:void(0);">Stand By</a></li>
                </ul>
        </div>
        </div>
        <div class="space" :id="'space'+customer.id" @dragover="changeColor(customer.id)" @dragleave="removeColor(customer.id)" @drop="dropSpace($event, customer.id)">
        </div>
    </div>
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
                },
                statusCard: 0,
                orders:[]
            } 
        },
        props:{
            customer: Object,
            status: Number,
            visible: Boolean
        },
        methods:{
            removeColor(index){
                document.getElementById('space'+index).classList.remove('space-show')
            },
            changeColor(index){
                document.getElementById('space'+index).classList.add('space-show')
            },
            dropSpace(e, index){
                var leadId = e.dataTransfer.getData('leadId')
                this.$emit('updateStatusSpace', leadId)
                document.getElementById('space'+index).classList.remove('space-show')
            },
            showModalUpdateCom(){
                this.$emit('showModalUpdateCom', this.customer.comunication)
            },
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
                e.dataTransfer.setData('leadId', this.customer.id)
                if(this.customer.quotations.length != 0){
                    e.dataTransfer.setData('quot', this.customer.quotations[0].id)
                    if(this.orders != 0){
                        e.dataTransfer.setData('order', this.orders[0].id)
                    }else{
                        e.dataTransfer.setData('order', null)
                    }
                }else{
                    e.dataTransfer.setData('quot', null)
                }
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
            },
            verifyOrders(){
                return this.customer.quotations.some(quotation => {
                    return quotation.orders?.length > 0
                })
            }
        },
        mounted(){
            this.statusCard = this.customer.status
        }
    }
</script>
<style scoped>
.space{
    height: 10px;
    border-radius: 5px;
}
.space-show{
    background-color: #696cff;
}
.bg-hover{
    background-color: #696cff;
}
.pt-10{
    margin-top: 100px;
}
</style>