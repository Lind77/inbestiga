<template>
    <div class="modal fade" id="CustomerprofileModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100" id="exampleModalLabel3">
                        <div class="row">
                            <div class="col-8">
                                Información de cliente {{ customer.name }}
                            </div>
                            <div class="col-4">
                                <p @dblclick="changeInterest(customer)" v-show="customer.status != 11"><i
                                        :class="`bx ${interest[customer.interest]} display-4 cursor-pointer`"></i></p>
                            </div>
                        </div>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 col-lg-6">
                            <div v-if="customer.quotations && customer.quotations.length == 0 && customer.status > 3"
                                class="alert alert-danger py-1 px-2" role="alert">Este usuario no tiene una cotización hecha
                                en el sistema</div>
                            <div class="card shadow-none bg-transparent border border-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ customer.name }}
                                    </h5>
                                    <p class="card-text">Celular: {{ customer.cell }}</p>
                                    <p class="card-text">Email: {{ customer.email }}</p>
                                    <p class="card-text">Universidad: {{ customer.university }}</p>
                                    <p class="card-text">Carrera: {{ customer.career }}</p>
                                    <p class="card-text">Carácter: {{ customer.attitude }}</p>
                                </div>
                            </div>
                            <div class="card shadow-none bg-transparent border border-success p-3 mb-3">
                                <h5>Detalles de documentación</h5> <button class="btn btn-icon btn-success"
                                    @click="addNewField"><i class="bx bx-plus"></i></button>
                                <p>Documento firmado: {{ signedDoc }}</p>
                                <template v-if="customer.quotations">
                                    Servicio Contratado:
                                    <p v-for="detail in customer.quotations[0].details">- {{
                                        detail.product.name }}
                                    </p>
                                </template>

                                <template v-for="newField in newFields">
                                    <div class="d-flex">
                                        <input type="text" class="form-control" v-model="newField.name">
                                        :
                                        <input type="text" class="form-control" v-model="newField.val">
                                    </div>
                                </template>
                                <button class="btn btn-success" @click="saveFields">Agregar</button>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">

                            <div class="card shadow-none bg-transparent border border-warning mb-3"
                                v-if="customer.comunications && customer.comunications.length != 0">
                                <div class="card-body">
                                    <h5 class="card-title">Comunicación más reciente</h5>
                                    <p class="card-text">Primera gestión: {{ customer.comunications[0].first_management }}
                                    </p>
                                    <p class="card-text">Última gestión: {{ customer.comunications[0].last_management }}</p>
                                    <p class="card-text">Siguiente gestión: {{ customer.comunications[0].next_management }}
                                    </p>
                                    <p class="card-text">Tipo: {{ typeComunication[customer.comunications[0].type] }}</p>
                                    <p class="card-text">Producto Tentativo: {{ customer.comunications[0].product_tentative
                                    }}</p>
                                    <p class="card-text">Comentario: {{ customer.comunications[0].comment }}</p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

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
            },
            newFields: []
        }
    },
    props: {
        customer: Object,
        owners: Array
    },
    methods: {
        saveFields() {
            console.log(this.newFields)
        },
        addNewField() {
            var newField = {
                name: '',
                val: ''
            }
            this.newFields.push({ ...newField })
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
        updateStatusSpace() {
            var newStatus = parseInt(this.customer.status) + 1
            this.$emit('updateStatusSpace', this.customer.id, newStatus)
        },
    },
    computed: {
        signedDoc() {
            if (this.customer && this.customer.quotations) {
                if (this.customer.quotations[0].contract != null) {
                    return 'Contrato'
                } else if (this.customer.quotations[0].order != null) {
                    return 'Orden'
                }
            }

        }
    }
}
</script>
