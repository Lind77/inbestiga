<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-3">
            <h4 class="fw-bold py-1"> Comprobantes</h4>
            <button @click="showOffCanvas" class="btn btn-success btn-icon">
                <i class='bx bx-list-ol'></i>
            </button>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Cliente:</label>
                    <input type="text" @keyup="searchClient" v-model="nameClient" class="form-control"
                        placeholder="Buscar cliente...">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center cursor-pointer"
                            @click="selectClient(client)" v-for="client in foundClients">
                            {{ client.name }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <label for="">Fecha de Emisión:</label>
                    <input type="date" v-model="date" class="form-control">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="">Documentos:</label>
                    <div v-for="quotation in quotations">
                        <template v-if="quotation.order">
                            <button class="btn btn-success" @click="showPayments(quotation)"> Orden {{
                                formatDate(quotation.order.created_at) }}</button>
                        </template>
                        <template v-else-if="quotation.contract">
                            <button class="btn btn-info" @click="showPayments(quotation)"> Contrato {{
                                formatDate(quotation.contract.created_at) }}</button>
                        </template>
                    </div>
                </div>
            </div>
            <div class="row">
                <p class="h5">Productos</p>
                <p v-for="detail in quotationSelected.details ">{{ detail.name }}</p>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments">
                            <td>{{ payment.advance }}</td>
                            <td>S./ {{ payment.amount }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <p class="h5">Subtotal: <input v-model="subtotal" @keyup="calcTotal" type="number"
                                class="form-control">
                        </p>
                        <p class="h5">Descuento: <input v-model="discount" @keyup="calcTotal" type="number"
                                class="form-control">
                        </p>
                        <p class="h4">Total: <input v-model="total_price" type="text" class="form-control" disabled></p>
                    </div>
                    <div class="col-md-6">
                        <p class="h5">Descripción pequeña: <input v-model="pay_detail" @keyup="calcTotal" type="text"
                                class="form-control">
                        </p>
                        <p class="h5">Monto restante de la cuota(opcional): <input v-model="remaining_amount"
                                @keyup="calcTotal" type="text" class="form-control">
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <button class="btn btn-success" @click="goVoucherFile">Generar</button>
            </div>
        </div>
    </div>
    <OffCanvas />
</template>
<script>
import moment from "moment"
import OffCanvas from './OffCanvas.vue'

export default {
    components: {
        OffCanvas
    },
    data() {
        return {
            clients: [],
            nameClient: '',
            foundClients: [],
            quotations: [],
            payments: [],
            quotationSelected: {},
            subtotal: 0.0,
            discount: 0.0,
            total_price: 0.0,
            date: '',
            pay_detail: '',
            remaining_amount: 0
        }
    },
    methods: {
        showOffCanvas() {
            $('#offcanvas').offcanvas('show')
        },
        calcTotal() {
            this.total_price = this.subtotal - this.discount
        },
        goVoucherFile() {
            console.log(this.quotationSelected);
            const fd = new FormData()

            if (this.quotationSelected.order) {
                var typeProof = 'App\\Models\\Order'
                var documentId = this.quotationSelected.order.id
            } else if (this.quotationSelected.contract) {
                var typeProof = 'App\\Models\\Contract'
                var documentId = this.quotationSelected.contract.id
            }

            fd.append('payment_proofable_id', documentId)
            fd.append('payment_proofable_type', typeProof)
            fd.append('customer_id', this.quotationSelected.customer_id)
            fd.append('date', this.date)
            fd.append('subtotal', this.subtotal)
            fd.append('discount', this.discount)
            fd.append('total_price', this.total_price)
            fd.append('pay_detail', this.pay_detail)
            fd.append('remaining_amount', this.remaining_amount)

            axios.post('/api/voucher', fd)
                .then((result) => {
                    this.$router.push({ name: 'voucher-file', params: { voucherId: result.data } });
                }).catch((err) => {
                    this.$swal('Error: ' + err.message)
                });

            //
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        showPayments(quotation) {
            console.log(quotation)
            this.quotationSelected = quotation
            if (quotation.order == null) {
                this.payments = quotation.contract.payments
            } else if (quotation.contract == null) {
                this.payments = quotation.order.payments
            }

        },
        selectClient(client) {
            this.foundClients = []
            this.quotations = client.quotations
        },
        getCustomers() {
            axios.get('/api/clients')
                .then((result) => {
                    this.clients = result.data;
                }).catch((err) => {
                    console.log(err);
                });
        },
        searchClient() {
            if (this.nameClient == '') {
                this.foundClients = []
            } else {
                this.foundClients = this.clients.filter(client => client.name.toLowerCase().includes(this.nameClient))
            }

        }
    },
    mounted() {
        this.getCustomers()
    }
}
</script>
<style lang="">
    
</style>