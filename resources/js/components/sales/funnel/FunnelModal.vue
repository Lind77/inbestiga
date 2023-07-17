<template>
    <div class="modal fade" id="funnelModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100" id="exampleModalLabel3">
                        <div class="row">
                            <div class="col-6">
                                <button @click="toQuotation(customers[0].pivot.quotation_id)" type="button"
                                    class="btn btn-icon btn-success ms-2" style=""><span
                                        class="tf-icons bx bx-file"></span></button>
                                <button @click="callToOrder()" type="button" class="btn btn-icon btn-info ms-2">
                                    <span class="tf-icons bx bx-pen"></span>
                                </button>
                                <button @click="callModal()" type="button" class="btn btn-icon btn-warning ms-2">
                                    <span class="tf-icons bx bx-chat"></span>
                                </button>
                            </div>
                            <div class="col-3">
                                <!-- <p><i :class="`bx ${interest[customer.interest]} display-4 cursor-pointer`"></i></p> -->
                            </div>
                            <div class="col-3">
                                <div class="alert alert-info d-flex" role="alert" v-if="customers && customers[0]">
                                    <div class="d-flex flex-column ps-1">
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">{{
                                            customers[0].user.name }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-6">
                                Información de Lead
                                
                                
                                <div v-if="customer.status >= 3">
                                    <h6 @dblclick="editOwner" v-show="!showOptionOwner" class="cursor-pointer">Dueño: {{
                                        customer.user ? customer.user.name : 'Sin asignar' }}</h6>
                                    <select v-model="newOwner" v-show="showOptionOwner" @blur="hideOptionOwner"
                                        @change="updateOwner" id="smallSelect" class="form-select form-select-sm">
                                        <option :value="owner.id" v-for="owner in owners">{{ owner.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                
                            </div>
                        </div> -->
                    </h5>


                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12 col-lg-6" v-for="customer in customers">
                            <div class="alert alert-primary d-flex" role="alert">
                                <span class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
                                        class="bx bx-user fs-6"></i></span>
                                <div class="d-flex flex-column ps-1">
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">{{
                                        customer.name }}
                                    </h6>
                                    <span>{{ customer.cell }}</span>
                                    <span> {{ customer.university }}</span>
                                    <span>{{ customer.career }}</span>
                                </div>
                            </div>
                            <!--  <div v-if="customer.quotations && customer.quotations.length == 0 && customer.status > 3"
                                class="alert alert-danger py-1 px-2" role="alert">Este usuario no tiene una cotización hecha
                                en el sistema</div> -->
                            <!-- <div class="card shadow-none bg-transparent border border-primary mb-3"
                                v-for="customer in customers">
                                <div class="card-body">
                                    <h5 class="card-title">{{ customer.name }}
                                        <button type="button" class="btn btn-icon btn-primary ms-2"
                                            @click="showModalUpdateData(customer)">
                                            <span class="tf-icons bx bx-user"></span>
                                        </button>
                                    </h5>
                                    <p class="card-text">Celular: {{ customer.cell }}</p>
                                    <p class="card-text">Email: {{ customer.email }}</p>
                                    <p class="card-text">Universidad: {{ customer.university }}</p>
                                    <p class="card-text">Carrera: {{ customer.career }}</p>
                                </div>
                            </div> -->
                            <!-- <div class="card shadow-none bg-transparent border border-success mb-3"
                                v-for="quotation in customer.quotations">
                                <div class="card-body">
                                    <h5 class="card-title">{{ quotation.date }}
                                        <p class="h6" v-for="detail in quotation.details">{{ detail.product.name }}</p>
                                        <button type="button" class="btn btn-success ms-2"
                                            @click="callToQuotation(quotation.id)">
                                            Ir a Cotización
                                        </button>
                                    </h5>
                                </div>
                            </div> -->
                        </div>
                        <template v-for="customer in customers">
                            <div class="col-12" v-for="comunication in customer.comunications">
                                <div class="alert alert-warning d-flex" role="alert">
                                    <span
                                        class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2"><i
                                            class="bx bx-envelope fs-6"></i></span>
                                    <div class="d-flex flex-column ps-1">
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">{{
                                            comunication.last_management }}
                                        </h6>
                                        <span>{{ comunication.comment }}</span>
                                        <span>Siguiente comunicación: {{ comunication.next_management }} {{
                                            comunication.time }}</span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- <div class="col-12 col-lg-6" v-if="customers">

                            
                            </div>
                        </div> -->

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" @click="standBy(customer.id)">Stand By</button>
                    <button type="button" class="btn btn-primary" @click="updateStatusSpace">Ascender</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    data() {
        return {
            showOptionOwner: false,
            newOwner: 1,
            typeComunication: {
                1: 'Llamar',
                2: 'Escribir',
                3: 'Meet'
            },
            interest: {
                null: 'bx-minus-circle',
                1: 'bx-sad text-danger',
                2: 'bx-smile text-info',
                3: 'bx-wink-smile text-success'
            }
        }
    },
    props: {
        customers: Array,
        owners: Array
    },
    methods: {
        toQuotation(quotationId) {
            $('#funnelModal').modal('hide')
            this.$router.push({ name: 'edit-quotation', params: { idQuotation: quotationId } })
        },
        changeInterest(customer) {
            var customerId = customer.id

            if (customer.interest == null) {
                var newInterest = 1
            } else if (customer.interest < 3) {
                var newInterest = parseInt(customer.interest) + 1
            } else {
                var newInterest = 1
            }

            axios.get('/api/changeInterest/' + customerId + '/' + newInterest)
                .then((res) => {
                    this.$emit('updateInterest', res.data)
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        hideOptionOwner() {
            this.showOptionOwner = false
        },
        updateOwner() {
            var newOwner = this.owners.find(owner => owner.id == this.newOwner)

            const fd = new FormData()
            fd.append('customer_id', this.customer.id)
            fd.append('user_id', this.newOwner)

            axios.post('/api/updateOwner', fd)
                .then((res) => {
                    this.$emit('updateOwner', this.customer, newOwner)
                })
                .catch((err) => {
                    console.error(err)
                })

            this.showOptionOwner = false
        },
        editOwner() {
            this.showOptionOwner = true
        },
        standBy(id) {
            $('#funnelModal').modal('hide')
            this.$swal({
                title: '¿Deseas pasar este cliente a StandBy?',
                icon: 'question',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'No'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.get('/api/standByCustomer/' + id)
                            .then((res) => {
                                $('#funnelModal').modal('hide')
                                this.$emit('getAllCustomers')
                            })
                            .catch(err => {
                                console.log(err)
                            })
                    } else {
                        this.$swal.close()
                    }
                })
        },
        updateStatusSpace() {
            var newStatus = parseInt(this.customer.status) + 1
            this.$emit('updateStatusSpace', this.customer.id, newStatus)
        },
        callModal(customer) {
            this.$emit('callModal', customer)
        },
        showModalUpdateData(customer) {
            this.$emit('showModalUpdateData', customer)
        },
        callToQuotation(quotationId) {
            if (this.store.authUser.id != 22) {
                $('#funnelModal').modal('hide')
                this.$router.push({ name: 'home-quotation', params: { idQuotation: quotationId } })
            } else {
                $('#funnelModal').modal('hide')
                this.$swal('Nop')
            }

        },
        callToOrder(customer) {
            $('#funnelModal').modal('hide')
            if (this.store.authUser.id == 22) {
                this.$swal('Nop')
            } else {
                if (customer.quotations[0]) {
                    if (customer.quotations[0].amount > 1500) {
                        this.$router.push({ name: 'home-contracts', params: { idUser: customer.id } })
                    } else {
                        this.$router.push({ name: 'home-orders', params: { idUser: customer.id } })
                    }
                } else {
                    this.$swal.fire({
                        title: 'Qué documento deseas generar?',
                        showDenyButton: true,
                        confirmButtonText: 'Contrato',
                        denyButtonText: `Orden`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            this.$router.push({ name: 'home-contracts', params: { idUser: customer.id } })
                        } else if (result.isDenied) {
                            this.$router.push({ name: 'home-orders', params: { idUser: customer.id } })
                        }
                    })
                }
            }
        }
    }
}
</script>
