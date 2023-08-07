<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1"> Comprobantes</h4>
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
                <input type="date" name="" id="" class="form-control">
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
            <p v-for="detail in quotationSelected.details ">{{ detail.product.name }}</p>
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
            <p class="h5">Subtotal: <input v-model="subtotal" @keyup="calcTotal" type="number" class="form-control w-25">
            </p>
            <p class="h5">Descuento: <input v-model="discount" @keyup="calcTotal" type="number" class="form-control w-25">
            </p>
            <p class="h4">Total: <input v-model="total" type="text" class="form-control w-25" disabled></p>
        </div>
        <div class="row">
            <button class="btn btn-success" @click="goVoucherFile">Generar</button>
        </div>
    </div>
</template>
<script>
import moment from "moment"

export default {
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
            total: 0.0
        }
    },
    methods: {
        calcTotal() {
            this.total = this.subtotal - this.discount
        },
        goVoucherFile() {
            this.$router.push({ name: 'voucher-file', params: { voucherId: 1 } });
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        showPayments(quotation) {
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