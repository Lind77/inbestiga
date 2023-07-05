<template>
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Insertar Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group">
                            <input v-model="name" type="text" class="form-control" placeholder="Nombre del cliente"
                                aria-label="Recipient's username" aria-describedby="button-addon2"
                                @keyup.enter="searchContract">
                            <button class="btn btn-outline-primary" type="button" id="button-addon2"
                                @click="searchContract"><i class='bx bx-search'></i></button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="alert alert-warning" role="alert" v-show="noResults">No se han encontrado contratos ni
                            ordenes que
                            coincidan con el nombre de este usuario.</div>
                        <div class="col-6 mb-2" v-for="result in results">
                            <button :class="`btn btn-sm ${result.type == 1 ? 'btn-success' : 'btn-info'}  w-100`"
                                @click="selectDocument(result)">{{ result.name }} - {{
                                    result.date }}</button>
                        </div>
                    </div>
                    <div class="row" v-show="showFields">
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Fecha</label>
                            <input type="date" v-model="date" class="form-control" />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Avance</label>
                            <input type="text" v-model="advance" class="form-control" />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Fecha Académica</label>
                            <input type="date" v-model="dateAcad" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-insert-customer" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="insertDelivery" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { userStore } from '../../stores/UserStore'
import moment from 'moment'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    props: {
        action: Number,
        customer: Object
    },
    data() {
        return {
            noResults: false,
            date: '',
            advance: '',
            dateAcad: '',
            name: '',
            cell: '',
            university: '',
            career: '',
            email: '',
            first_management: null,
            last_management: null,
            next_management: null,
            comment: '',
            product_tentative: '',
            type: 0,
            origin: 0,
            users: [],
            referedFrom: 0,
            channel: 0,
            status: 0,
            contracts: [],
            orders: [],
            results: [],
            showFields: false,
            resultId: 0,
            resultType: 0
        }
    },
    methods: {
        selectDocument(result) {
            this.showFields = true
            this.resultId = result.id
            this.resultType = result.type
        },
        formatOrderDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        insertDelivery() {

            const fd = new FormData()
            fd.append('deliverable_id', this.resultId)
            fd.append('type', this.resultType)
            fd.append('date', this.date)
            fd.append('advance', this.advance)
            fd.append('dateAcad', this.dateAcad)
            fd.append('status', 3)

            axios.post('/api/delivery', fd)
                .then((result) => {
                    $('#deliveryModal').modal('hide')
                    this.$emit('getAllDeliveries')
                }).catch((err) => {
                    console.error(err)
                });
        },
        insertPayment() {
            const fd = new FormData()

            fd.append('order_id', this.resultId)
            fd.append('date', this.date)

            axios.post('/api/payment', fd)
                .then((result) => {
                    $('#deliveryModal').modal('hide')
                    this.$emit('updateDate', this.date)
                }).catch((err) => {
                    console.error(err)
                });
        },
        searchContract() {
            this.results = []
            this.noResults = false
            axios.get('/api/contract/' + this.name)
                .then((result) => {
                    this.contracts = result.data.contracts;
                    this.orders = result.data.orders;
                    if (this.contracts.length == 0 && this.orders.length == 0) {
                        this.noResults = true
                    }
                    var result = {
                        id: 0,
                        name: '',
                        date: '',
                        type: 0
                    }

                    this.contracts.forEach((contract) => {
                        result.id = contract.id
                        result.name = contract.quotation.customer.name
                        result.date = this.formatOrderDate(contract.date)
                        result.type = 1
                        this.results.push({ ...result })
                    })

                    this.orders.forEach((order) => {
                        result.id = order.id
                        result.name = order.quotation.customer.name
                        result.date = this.formatOrderDate(order.created_at)
                        result.type = 2
                        this.results.push({ ...result })
                    })


                }).catch((err) => {
                    console.error(err);
                });
        },
        updateCustomer() {
            const fd = new FormData()
            fd.append('_method', 'put');
            fd.append('id', this.customer.id)
            fd.append('name', this.customer.name)
            fd.append('cell', this.customer.cell)
            fd.append('university', this.customer.university)
            fd.append('career', this.customer.career)
            fd.append('email', this.customer.email)

            axios.post(`/api/customers/${this.customer.id}`, fd)
                .then(res => {
                    console.log(res)
                    this.$emit('getAllCustomers')
                    $('#customerModal').modal('hide')
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        },
        verifyExistence() {
            const fd = new FormData()

            fd.append('name', this.name)
            fd.append('cell', this.cell)
            axios.post('/api/customers/verify', fd)
                .then((res) => {
                    if (res.data) {
                        this.insertCustomer()
                    }

                    var coincidences = [];
                    res.data.coincidences.forEach((coincidence) => {
                        coincidences.push(`${coincidence.name}(${coincidence.cell})<br>`);
                    })
                    if (res.data.msg) {
                        $('#customerModal').modal('hide')
                        this.$swal.fire({
                            icon: 'error',
                            title: res.data.msg,
                            html: coincidences.join('') + '<br>Tienes la seguridad de continuar?',
                            showDenyButton: true,
                            confirmButtonText: 'Registrar',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                this.insertCustomer()
                            } else if (result.isDenied) {
                                this.$swal.close()
                            }
                        })
                        //$('#customerModal').modal('hide')
                        //this.$swal('Se ha encontrado un usuario con el mismo nombre')
                    } else {
                        this.insertCustomer()
                    }

                })
                .catch((err) => {

                })
        },
        insertCustomer() {
            const fd = new FormData()
            fd.append('name', this.name)
            fd.append('cell', this.cell)
            fd.append('university', this.university)
            fd.append('career', this.career)
            fd.append('email', this.email)
            fd.append('origin', this.origin)
            fd.append('status', this.status)
            fd.append('referedFrom', this.referedFrom)
            fd.append('channel', this.channel)
            fd.append('user_id', 12)
            fd.append('type', this.type)

            axios.post('/api/customers', fd)
                .then(res => {
                    console.log(res)
                    this.$emit('getAllCustomers')
                })
                .catch(err => {
                    $('#customerModal').modal('hide')
                    this.$swal(err.response.data.message)
                    console.log(err.response.data)
                })
        },
        getAllUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data
                })
                .catch(err => {
                    console.log(err.response.data)
                })
        }
    },
    mounted() {
        this.getAllUsers()
    }
}
</script>