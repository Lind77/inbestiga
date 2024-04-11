<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row p-sm-1 p-0">
                            <div class="col-md-6 mb-md-0 mb-4">
                                <div class="d-flex svg-illustration gap-2">
                                    <span class="h5 mt-2 demo text-body fw-bold">{{ titleByType[documentType]
                                        }}</span>

                                    <!-- <button @click="changeDocumentType" class="btn btn-success btn-icon">
                                        <i class='bx bx-chevrons-right'></i>
                                    </button> -->

                                    <label for="file-upload" class="btn btn-dark btn-icon">
                                        <i class='bx bx-save'></i>
                                    </label>
                                    <input id="file-upload" type="file" class="d-none" @change="uploadContract" />

                                    <button @click="addNewCustomer" class="btn btn-info btn-icon">
                                        <i class='bx bx-user-plus'></i>
                                    </button>

                                    <!-- <button><i class='bx bx-save'></i></button> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="w-100">
                                    <input type="text" v-model="search" placeholder="Buscar cliente..."
                                        class="form-control" v-on:keyup.enter="searchCustomer">

                                    <ul class="list-group">
                                        <li class="list-group-item bg-white d-flex justify-content-between align-items-center cursor-pointer"
                                            v-for="customerFound in customersFound" @click="addCustomer(customerFound)">
                                            {{ customerFound.name }} - {{ dateFormatted(customerFound.created_at) }}
                                        </li>
                                    </ul>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-2" v-for="customer in customers">
                                <Customer :customer="customer" @deleteCustomer="deleteCustomer"
                                    @getCustomer="getCustomer" @openModalCustomerEdit="openModalCustomerEdit" />
                            </div>
                            <div v-if="documentType == 1" class="bg-success rounded text-white text-center my-1 p-1"
                                @click="pickQuotation(quotation)" v-for="quotation in quotationsExistent">
                                {{ formatTime(quotation.created_at) }}
                                <i class="bx bx-trash" @click="deleteQuotaion(quotation.id)"></i>
                            </div>
                            <button v-if="documentType == 2" class="btn btn-info m-1" @click="pickOrder(order)"
                                v-for="order in ordersExistent">{{
                                        formatTime(order.created_at)
                                    }}</button>
                            <button v-if="documentType == 3" class="btn btn-info m-1" @click="pickContract(contract)"
                                v-for="contract in contractExistent">{{
                                        contract.date
                                    }}</button>
                        </div>
                    </div>
                </div>
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="h5 mt-2 demo text-body fw-bold">Detalles</span>

                                <button type="button" class="btn btn-primary btn-icon ms-2" data-repeater-create=""
                                    @click="addDetail"><i class='bx bx-plus'></i></button>
                            </div>
                        </div>
                        <div class="mb-3" data-repeater-list="group-a">
                            <template v-for="(detail, index) in details">
                                <Detail :detail="detail" :newProducts="newProducts" :index="index"
                                    @removeSuggestedCart="removeSuggestedCart" @calcPayments="calcPayments" />
                            </template>
                        </div>
                    </div>
                </div>
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <span class="h5 mt-2 demo text-body fw-bold">Pagos({{ cantPayments }})</span>
                                        <button type="button" class="btn btn-primary btn-icon ms-2"
                                            @click="minusPayment"><i class='bx bx-minus'></i></button>
                                        <button type="button" class="btn btn-primary btn-icon ms-2"
                                            @click="addPayment"><i class='bx bx-plus'></i></button>

                                    </div>


                                    <button type="button" class="btn btn-primary btn-sm ms-2"
                                        @click="calcPayments">Calcular</button>
                                </div>

                                <div class="row w-100">
                                    <table class="table" v-if="payments.length">
                                        <thead>
                                            <tr>
                                                <td>Fecha</td>
                                                <td>Monto</td>
                                                <td>Porcentaje</td>
                                                <td>Opciones</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <template v-for="(payment, index) in payments">
                                                <Payment :payment="payment" :index="index"
                                                    @deletePayment="deletePayment" :finalPrice="finalPrice" />
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card invoice-preview-card mt-2" v-if="documentType == 3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <span class="h5 mt-2 demo text-body fw-bold">Entregas</span>
                                        <button type="button" class="btn btn-primary btn-icon ms-2"
                                            @click="addDelivery"><i class='bx bx-plus'></i></button>
                                    </div>
                                </div>

                                <div class="row w-100">
                                    <table class="table" v-if="deliveries.length">
                                        <thead>
                                            <tr>
                                                <td>Fecha</td>
                                                <td>Avance</td>
                                                <td>Opciones</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <template v-for="(delivery, index) in deliveries">
                                                <Delivery :delivery="delivery" :index="index"
                                                    @deleteDelivery="deleteDelivery" />
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Invoice Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card bg-success text-white mb-3" v-if="documentType == 1">
                    <div class="row mb-2 p-2">
                        <div class="w-100">
                            <p>Necesidades</p>
                            {{ customer.needs }}
                        </div>
                    </div>
                </div>
                <div class="card mb-3" v-if="documentType == 1">
                    <div class="row mb-2 p-2">
                        <div class="w-100">
                            <label class="form-label">Fecha<span class="text-danger">*</span>:</label>
                            <input type="date" class="form-control date-picker flatpickr-input"
                                v-model="quotation.date">
                            <label class="form-label">Fecha de validez<span class="text-danger">*</span>:</label>
                            <input type="date" class="form-control date-picker flatpickr-input"
                                v-model="quotation.expiration_date" />
                            <label for="salesperson" class="form-label">Tiempo de Ejecución<span
                                    class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" v-model="quotation.term">
                            <label for="salesperson" class="form-label">Cupón de descuento:</label>
                            <input type="text" class="form-control" v-model="coupon" @keyup.enter="autoDiscount">
                            <div class="d-flex justify-content-between">
                                <span class="w-px-100">Descuento:</span>
                                <span class="fw-semibold">S./ {{ quotation.discount }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="w-px-100">TOTAL:</span>
                                <span class="fw-semibold">S./ {{ finalPrice }}</span>
                            </div>
                            <button @click="createQuotation" class="btn btn-primary d-grid w-100 my-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
                            </button>
                            <router-link v-if="quotationIdGenerated != 0"
                                :to="{ name: 'quotation-file', params: { id: quotationIdGenerated } }" target="_blank"
                                class="btn btn-primary d-grid w-100 mb-3" disabled>
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-file bx-xs me-1"></i>Cotización
                                </span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" v-else-if="documentType == 2">
                    <div class="row mb-2 p-2">
                        <div class="w-100">
                            <label for="salesperson" class="form-label">Entrega Final<span
                                    class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" v-model="order.final_delivery">
                            <label for="salesperson" class="form-label">Observaciones<span
                                    class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" v-model="order.observations">
                            <label for="salesperson" class="form-label">Cupón de descuento:</label>
                            <input type="text" class="form-control" v-model="coupon" @keyup.enter="autoDiscount">
                            <div class="d-flex justify-content-between" v-if="documentType != 1">
                                <span class="w-px-100">Descuento:</span>
                                <span class="fw-semibold">S./ {{ discount }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="w-px-100">TOTAL:</span>
                                <span class="fw-semibold">S./ {{ finalPrice }}</span>
                            </div>
                            <button @click="createOrder" class="btn btn-primary d-grid w-100 my-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
                            </button>
                            <router-link v-if="orderId != 0" target="_blank"
                                :to="{ name: 'order-file', params: { id: orderId } }"
                                class="btn btn-primary d-grid w-100 mb-3">Orden</router-link>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" v-else-if="documentType == 3">
                    <div class="row mb-2 p-2">
                        <div class="w-100">
                            <p>3er art.(Instrumentos) <input type="checkbox" class="form-check-input"
                                    v-model="thirdArticle"></p>
                            <p>3er art.(Lugar) <input type="checkbox" class="form-check-input"
                                    v-model="thirdArticlePlace">
                            </p>
                            <p>5to art.(Considerar Entregas) <input type="checkbox" class="form-check-input"
                                    v-model="fifthArticle">
                            </p>
                            <!-- <label for="salesperson" class="form-label">Tiempo de Ejecucion<span
                                    class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" v-model="quotation.term"> -->

                            <label for="salesperson" class="form-label">Fecha de contrato<span
                                    class="text-danger">*</span>:</label>
                            <input type="date" class="form-control" v-model="contract.date">

                            <label for="salesperson" class="form-label">Cupón de descuento:</label>
                            <input type="text" class="form-control" v-model="coupon" @keyup.enter="autoDiscount">
                            <div class="d-flex justify-content-between" v-if="documentType != 1">
                                <span class="w-px-100">Descuento:</span>
                                <span class="fw-semibold">S./ {{ discount }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="w-px-100">TOTAL:</span>
                                <span class="fw-semibold">S./ {{ finalPrice }}</span>
                            </div>
                            <button v-if="documentType == 1" @click="createQuotation"
                                class="btn btn-primary d-grid w-100 my-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
                            </button>
                            <button v-if="documentType == 2" @click="createOrder"
                                class="btn btn-primary d-grid w-100 my-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
                            </button>

                            <button v-else-if="documentType == 3" @click="createContract"
                                class="btn btn-primary d-grid w-100 my-3">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                        class="bx bx-paper-plane bx-xs me-1"></i> {{
                                        contractExistent ? 'Actualizar' : 'Generar'
                                    }}</span>
                            </button>
                            <router-link v-if="quotationIdGenerated != 0"
                                :to="{ name: 'quotation-file', params: { id: quotationIdGenerated } }" target="_blank"
                                class="btn btn-primary d-grid w-100 mb-3" disabled>
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-file bx-xs me-1"></i>Cotización
                                </span>
                            </router-link>
                            <a v-if="contractId != 0 && documentType == 3"
                                :href="`${appUrl}api/generateContract/${contractId}`" target="_blank"
                                class="btn btn-primary d-grid w-100 mb-3">Contrato</a>
                        </div>
                    </div>
                </div>
                <!-- <div class="card mb-4">
                    <div class="card-body">
                        <button @click="createQuotation" class="btn btn-primary d-grid w-100 mb-3">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
                        </button>
                        <router-link v-if="quotationIdGenerated != 0"
                            :to="{ name: 'quotation-file', params: { id: quotationIdGenerated } }" target="_blank"
                            class="btn btn-primary d-grid w-100 mb-3" disabled>
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-file bx-xs me-1"></i>Cotización
                            </span>
                        </router-link>
                    </div>
                </div> -->
            </div>
            <!-- /Invoice Actions -->
        </div>
    </div>
    <customerModal :action="action" :customer="customerSelected" />
</template>

<script>
import moment from 'moment'
import conversor from 'conversor-numero-a-letras-es-ar'
import Customer from './Customer.vue'
import Detail from './Detail.vue'
import Payment from './Payment.vue'
import Delivery from './Delivery.vue'
import customerModal from '../customers/customerModal.vue'
import { userStore } from '../../../stores/UserStore'
import axios from 'axios'

export default {
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    components: { Customer, Detail, Payment, Delivery, customerModal },
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
            documentType: 1,
            titleByType: {
                1: 'Nueva Cotización',
                2: 'Nueva Orden',
                3: 'Nuevo Contrato'
            },
            customer: {},
            customers: [],
            customerSelected: {},
            search: '',
            customersFound: [],
            details: [],
            newProducts: [],
            quotation: {
                id: 0,
                customer_id: 0,
                date: '',
                amount: 0,
                term: '',
                expiration_date: '',
                discount: 0,
                note: ''
            },
            order: {
                observations: '',
                final_delivery: ''
            },
            contract: {
                date: ''
            },
            quotationIdGenerated: 0,
            payments: [],
            cantPayments: 0,
            quotationExistent: {},
            coupon: '',
            discount: 0,
            deliveries: [],
            thirdArticle: false,
            thirdArticlePlace: false,
            fifthArticle: false,
            contractId: 0,
            orderId: 0,
            quotationsExistent: [],
            contractExistent: [],
            action: 1,
            ordersExistent: []
        }
    },
    methods: {
        formatTime(time) {
            return moment(time).format('DD/MM/YYYY hh:mma')
        },
        addNewCustomer() {
            this.action = 1
            $('#customerModal').modal('show')
        },
        deleteQuotaion(quotationId) {
            this.$swal.fire({
                title: '¿Deseas eliminar esta cotización?',
                showDenyButton: true,
                confirmButtonText: 'Si',
                denyButtonText: 'No',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.delete('/api/quotations/' + quotationId)
                        .then((result) => {
                            this.getCustomer()
                            this.documentType = 1
                        }).catch((err) => {

                        });
                }
            })

        },
        openModalCustomerEdit(customer) {
            this.action = 2
            this.customerSelected = customer
            $('#customerModal').modal('show')
        },
        pickContract(contract) {
            this.payments = contract.payments
            console.log(contract)
            this.deliveries = contract.projects[0].deliveries
            this.thirdArticle = this.numberToBoolean(contract.third_article)
            this.fifthArticle = this.numberToBoolean(contract.fifth_article)
            this.thirdArticlePlace = this.numberToBoolean(contract.third_article_place)
            this.contract.date = contract.date
        },
        pickQuotation(quotation) {
            this.quotation = quotation
            this.quotationIdGenerated = quotation.id
            this.details = quotation.details
        },
        pickOrder(order) {
            this.order = order
            this.orderId = order.id
            this.payments = order.payments
        },
        minusPayment() {
            if (this.finalPrice == 0.00) {
                this.$swal('Aun no hay un precio final, añadir detalles')
            } else {
                if (this.cantPayments > 0) {
                    this.cantPayments--
                }

            }
        },
        addPayment() {
            this.cantPayments++
        },
        deletePayment(index) {
            this.payments.splice(index, 1)
        },
        addDelivery() {
            var delivery = {
                date: null,
                advance: ''
            }
            this.deliveries.push({ ...delivery })
        },
        deleteDelivery(index) {
            this.deliveries.splice(index, 1)
        },
        changeDocumentType() {
            console.log(this.documentType)
            if (this.documentType <= 2) {
                this.documentType = this.documentType + 1
            } else {
                this.documentType = 1
            }
        },
        getCustomer() {
            this.contractExistent = []
            this.quotationExistent = []

            axios.get('/api/quotations/' + this.$route.params.quotationId)
                .then((res) => {

                    this.quotation = res.data
                    if (this.quotation) {
                        this.customers = res.data.customers

                        this.details = this.quotation.details
                        if (this.quotation.amount > 1500) {
                            this.documentType = 3
                        } else {
                            this.documentType = 2
                        }

                    } else {
                        this.customers.push(this.customer)
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        searchCustomer() {
            axios.get(`/api/customers/search/${this.search}`)
                .then((res) => {
                    this.customersFound = res.data.customers
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        addCustomer(customer) {
            this.customers.push(customer)
            this.customersFound = []
            this.search = ''
        },
        booleanToNumber(value) {
            return value ? 1 : 0
        },
        numberToBoolean(value) {
            return value == 1 ? true : false
        },
        deleteCustomer(customerId) {
            var customerSelected = this.customers.findIndex(customer => customer.id == customerId);
            this.customers.splice(customerSelected, 1)
        },
        dateFormatted(date) {
            return moment(date).fromNow()
        },
        addDetail() {
            this.details.push({ type: 1, level: '', title: '', mode: '', price: 0, extra_price: 0, product: { name: '' }, product_id: '' })
        },
        removeSuggestedCart(index) {
            this.details.splice(index, 1)
        },
        getAllNewProducts() {
            axios.get('/api/getAllNewProducts')
                .then((res) => {
                    this.newProducts = res.data
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        createQuotation() {

            const fd = new FormData()

            fd.append('user_id', this.store.authUser.id)
            fd.append('customers', JSON.stringify(this.customers))
            fd.append('customer_id', this.customer.id)
            fd.append('date', this.quotation.date)
            fd.append('expiration_date', this.quotation.expiration_date)
            fd.append('amount', (this.totalProducts).toFixed(2))
            fd.append('discount', this.quotation.discount)
            fd.append('term', this.quotation.term)
            fd.append('products', JSON.stringify(this.details))
            fd.append('emisor_id', this.store.authUser.id)
            fd.append('coupon', this.coupon)
            fd.append('payments', JSON.stringify(this.payments))

            axios.post('/api/quotations', fd)
                .then((res) => {
                    this.$swal('Cotización generada')
                    this.quotationIdGenerated = res.data.id
                    this.quotationExistent.id = res.data.id
                })
                .catch((err) => {
                    this.$swal(err.response.data.message)
                    console.log(err.response)
                })
        },
        createOrder(quotationId) {
            const fd = new FormData()

            fd.append('quotation_id', this.quotation.id)
            fd.append('final_delivery', this.order.final_delivery)
            fd.append('observations', this.order.observations)
            fd.append('suggested', 1)
            fd.append('payments', JSON.stringify(this.payments))
            fd.append('discount', this.discount)
            fd.append('customers', JSON.stringify(this.customers))
            fd.append('customer_id', this.customer.id)
            fd.append('products', JSON.stringify(this.details))
            fd.append('user_id', this.store.authUser.id)

            axios.post('/api/orders', fd)
                .then(res => {
                    console.log(res.data);
                    this.orderId = res.data
                    this.$swal('Orden registrada correctamente')
                })
                .catch(err => {
                    this.$swal(err.response.data.message)
                })
        },
        createContract() {
            var thirdArticleValue = this.booleanToNumber(this.thirdArticle)
            var fifthArticleValue = this.booleanToNumber(this.fifthArticle)
            var thirdArticlePlaceValue = this.booleanToNumber(this.thirdArticlePlace)

            let conversorClass = conversor.conversorNumerosALetras
            let myConverter = new conversorClass()

            const fd = new FormData()

            fd.append('quotation_id', this.quotation.id)
            fd.append('amount', this.finalPrice)
            fd.append('amount_text', myConverter.convertToText(parseInt(this.finalPrice)))
            var decimal = this.finalPrice.toString().split(".")[1] * 10
            fd.append('cent_text', myConverter.convertToText(decimal))
            fd.append('date', this.contract.date)
            fd.append('payments', JSON.stringify(this.payments))
            fd.append('deliveries', JSON.stringify(this.deliveries))
            fd.append('customers', JSON.stringify(this.customers))
            fd.append('user_id', this.store.authUser.id)
            fd.append('products', JSON.stringify(this.details))
            fd.append('emisor_id', this.store.authUser.id)
            fd.append('third_article', thirdArticleValue)
            fd.append('fifth_article', fifthArticleValue)
            fd.append('third_article_place', thirdArticlePlaceValue)
            axios.post('/api/contracts', fd)
                .then(res => {
                    this.contractId = res.data
                    this.$swal('Contrato generado correctamente')
                    //this.getCustomer()
                })
                .catch(err => {
                    this.$swal(err.response.data.message)
                    console.log(err)
                })
        },
        calcPayments() {
            if (this.finalPrice == 0.00) {
                this.$swal('Aun no hay un precio final, añadir detalles')
            } else {
                this.payments = []
                for (var i = 0; i < this.cantPayments; i++) {
                    var payment = {
                        date: null,
                        amount: (this.finalPrice / this.cantPayments).toFixed(1),
                        percentage: (100 / this.cantPayments).toFixed(1)
                    }

                    this.payments.push({ ...payment })
                }
            }
        },
        autoDiscount() {

            axios.get('/api/promotions/' + this.coupon)
                .then((result) => {
                    console.log(result)
                    if (Object.keys(result.data).length == 0) {
                        this.$swal('Código Incorrecto')
                    }
                    else if (result.data.percent == 0) {
                        this.$swal('Se ha desbloqueado el descuento por cantidad')
                        this.discount = result.data.quantity
                        this.quotation.discount = result.data.quantity
                        this.calcPayments()
                    } else {
                        this.$swal('Se ha desbloqueado el descuento por porcentaje')
                        this.discount = ((this.totalProducts * result.data.percent) / 100).toFixed(2)
                        this.calcPayments()
                    }
                }).catch((err) => {
                    console.log(err)
                });

        }
    },
    computed: {
        finalPrice(oldValue, newValue) {
            return parseFloat(this.totalProducts).toFixed(1)
        },
        totalProducts() {
            var total = 0
            this.details.forEach((product) => {
                if (product.type == 1) {
                    if (product.extra_price == null) { product.extra_price = 0 }
                    total += parseFloat(product.price) + parseFloat(product.extra_price)
                }

            })
            return (total).toFixed(2) - this.discount
        }
    },
    mounted() {
        this.getCustomer()
        this.getAllNewProducts()
    }
}
</script>

<style scoped>
.list-group {
    position: absolute;
    z-index: 9999 !important;
}
</style>