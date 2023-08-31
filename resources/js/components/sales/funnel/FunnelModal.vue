<template>
    <div class="modal fade" id="funnelModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title w-100" id="exampleModalLabel3">
                        <div class="row">
                            <div class="col-6">
                                <button v-if="quotation" v-bind:disabled="quotation.status < 5"
                                    @click="toQuotation(quotation.customers[0].id)" type="button"
                                    class="btn btn-icon btn-success ms-2" style=""><span
                                        class="tf-icons bx bx-file"></span></button>
                                <button v-if="quotation" v-bind:disabled="quotation.status < 8" @click="toOrder(quotation)"
                                    type="button" class="btn btn-icon btn-info mx-2">
                                    <span class="tf-icons bx bx-pen"></span>
                                </button>
                                <button v-if="customer || quotation" @click="callModalUpdateComunication" type="button"
                                    class="btn btn-icon btn-warning">
                                    <span class="tf-icons bx bx-chat"></span>
                                </button>
                                <!-- <button v-if="quotation" @click="viewQuotation(quotation)" type="button"
                                    class="btn btn-icon btn-danger mx-2">
                                    <span class="tf-icons bx bx-show"></span>
                                </button> -->
                                <button v-if="quotation" @click="deleteQuotation(quotation)" type="button"
                                    class="btn btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash"></span>
                                </button>
                            </div>
                            <div class="col-3" v-if="quotation">
                                <p class="h2 cursor-pointer emoji" @dblclick="changeInterest(quotation)">{{
                                    interest[quotation.interest] }}
                                </p>
                            </div>
                            <div class="col-3" v-else-if="customer">
                                <p class="h2 cursor-pointer emoji">{{
                                    interest[customer.interest] }}
                                </p>
                            </div>
                            <div class="col-3">
                                <div @dblclick="editOwner" class="alert alert-info d-flex" role="alert">
                                    <div class="d-flex flex-column ps-1">
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1"
                                            v-if="quotation && quotation.customers">{{
                                                quotation.customers[0].user ? quotation.customers[0].user.name : 'Sin dueño' }}
                                        </h6>
                                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1"
                                            v-else-if="customer">{{
                                                customer.user ? customer.user.name : 'Sin dueño' }}
                                        </h6>
                                    </div>
                                </div>
                                <select v-model="newOwner" v-show="showOptionOwner" @blur="hideOptionOwner"
                                    @change="updateOwner" id="smallSelect" class="form-select form-select-sm">
                                    <option :value="owner.id" v-for="owner in owners">{{ owner.name }}</option>
                                </select>
                            </div>
                        </div>
                    </h5>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <template v-if="quotation && quotation.customers">
                            <div class="col-12 col-lg-6" v-for="customer in quotation.customers">
                                <div class="alert alert-primary d-flex" role="alert">
                                    <span @click="showModalUpdateData(customer)"
                                        class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
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
                            </div>
                        </template>
                        <template v-else-if="customer">
                            <div class="col-12 col-lg-6">
                                <div class="alert alert-primary d-flex" role="alert">
                                    <span @click="showModalUpdateData(customer)"
                                        class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
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
                            </div>
                        </template>
                        <template v-if="customer">
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
                        <template v-if="quotation">
                            <template v-for="customer in quotation.customers">
                                <template v-for="comunication in customer.comunications">
                                    <div class="col-12">
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

                            </template>
                        </template>
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
                null: '😶',
                1: '😒',
                2: '😐',
                3: '😄'
            }
        }
    },
    props: {
        customer: Object,
        owners: Array,
        quotation: Object
    },
    methods: {
        deleteQuotation(quotation) {
            $('#funnelModal').modal('hide')
            this.$swal.fire({
                title: '¿Deseas eliminar esta cotización?',
                showDenyButton: true,
                confirmButtonText: 'Si',
                denyButtonText: 'No',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.delete('/api/quotations/' + quotation.id)
                        .then((result) => {
                            this.$emit('getAllQuotations')
                        }).catch((err) => {

                        });
                }
            })

        },
        callModalUpdateComunication() {
            $('#funnelModal').modal('hide')
            if (this.customer) {
                this.$emit('callModalComunication', this.customer)
            } else if (this.quotation) {
                console.log(this.quotation);
                this.$emit('callModalComunication', this.quotation.customers[0])
            }

        },
        toQuotation(customerId) {
            $('#funnelModal').modal('hide')
            this.$router.push({ name: 'home-docs', params: { customerId: customerId } })
        },
        toOrder(quotation) {
            console.log(quotation);
            $('#funnelModal').modal('hide')
            if (quotation.amount <= 1500) {
                this.$router.push({ name: 'home-docs', params: { customerId: quotation.customer_id } })
            } else {
                this.$router.push({ name: 'home-docs', params: { customerId: quotation.customer_id } })
            }

            /* $('#funnelModal').modal('hide')
            this.$router.push({ name: 'edit-quotation', params: { idQuotation: quotationId } }) */
        },
        changeInterest(quotation) {

            console.log(quotation);

            var quotationId = quotation.id

            if (quotation.interest == null) {
                var newInterest = 1
            } else if (quotation.interest < 3) {
                var newInterest = parseInt(quotation.interest) + 1
            } else {
                var newInterest = 1
            }

            axios.get('/api/changeInterest/' + quotationId + '/' + newInterest)
                .then((res) => {
                    this.$emit('updateInterest', res.data)
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        hideOptionOwner() {
            this.showOptionOwner = false
        },
        updateOwner() {

            if (this.quotation) {
                var newOwner = this.owners.find(owner => owner.id == this.newOwner)
                this.quotation.customers.forEach(customer => {
                    const fd = new FormData()
                    fd.append('customer_id', customer.id)
                    fd.append('user_id', this.newOwner)

                    axios.post('/api/updateOwner', fd)
                        .then((res) => {
                            this.$emit('updateOwnerQuotation', this.quotation, newOwner)
                            alert('Dueño actualizado')
                        })
                        .catch((err) => {
                            console.error(err)
                        })
                });

            } else {
                var newOwner = this.owners.find(owner => owner.id == this.newOwner)

                const fd = new FormData()
                fd.append('customer_id', this.customer.id)
                fd.append('user_id', this.newOwner)

                axios.post('/api/updateOwner', fd)
                    .then((res) => {
                        this.$emit('updateOwner', this.customer, newOwner)
                        alert('Dueño actualizado')
                    })
                    .catch((err) => {
                        console.error(err)
                    })

                this.showOptionOwner = false
            }

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
                                this.$emit('getAllPreleads')
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
            if (this.quotation) {
                var newStatus = parseInt(this.quotation.status) + 1
                if (newStatus == 11) {
                    this.$emit('updateStatusSpace', this.quotation.id, 11)
                    $('#funnelModal').modal('hide')
                    this.$swal('Felicidades!, ha conseguido un nuevo proyecto para Inbestiga!!')
                } else {
                    this.$emit('updateStatusSpace', this.quotation.id, newStatus)
                }
            } else {
                if (parseInt(this.customer.status) + 1 == 5) {
                    console.log('entrando al if')
                    $('#funnelModal').modal('hide')
                    this.$router.push({ name: 'home-docs', params: { customerId: this.customer.id } })
                }
                var newStatus = parseInt(this.customer.status) + 1
                this.$emit('updateStatusSpace', this.customer.id, newStatus)
            }

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
            console.log(customer);
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
