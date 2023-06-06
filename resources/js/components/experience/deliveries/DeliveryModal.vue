<template>
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="action == 1" id="exampleModalLabel1">Insertar Entrega</h5>
                    <h5 class="modal-title" v-else id="exampleModalLabel1">Actualizar Cliente {{ customer.name ||
                        customer.cell }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nombre de Cliente</label>
                            <input type="text" v-if="action == 2" v-model="customer.name" class="form-control" />
                            <input type="text" v-else v-model="name" class="form-control" @keyup.enter="searchContract" />
                        </div>

                    </div>
                    <div class="row" v-if="result.date">
                        <div class="alert alert-success py-1 px-2" role="alert">Se encontró el contrato más reciente, del
                            día {{ result.date }}, se le asignará la nueva entrega a este.</div>
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
import { userStore } from '../../../stores/UserStore'

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
            result: {}
        }
    },
    methods: {
        insertDelivery() {

            const fd = new FormData()

            fd.append('contract_id', this.result.id)
            fd.append('date', this.date)
            fd.append('advance', this.advance)
            fd.append('dateAcad', this.dateAcad)

            axios.post('/api/delivery', fd)
                .then((result) => {
                    $('#deliveryModal').modal('hide')
                }).catch((err) => {
                    console.error(err)
                });
        },
        searchContract() {
            axios.get('/api/contract/' + this.name)
                .then((result) => {
                    this.result = result.data.contract;
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