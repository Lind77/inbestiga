<template>
    <div class="voucher">
        <div class="row voucher-header">
            <img src="https://jairpl.com/pdf-sys/header_boleta.png" alt="" srcset="">
        </div>
        <div class="row ms-5">
            <div class="col">
                <p class="title voucher-important-data" v-if="paymentProof.customer">SEÑOR(A): <span
                        v-for="customer in paymentProof.payment_proofable.quotation.customers">{{ customer.name + ' / ' }}
                    </span>
                </p>
                <p class="title voucher-important-data">TIPO DE MONEDA: <span>NUEVOS SOLES</span></p>
            </div>
            <div class="col">
                <p class="title voucher-important-data">FECHA DE EMISIÓN: <span>{{ formatDate(paymentProof.date) }}</span>
                </p>
                <p class="title voucher-important-data">N° DE RECIBO: <span>{{ paymentProof.id }}</span></p>
            </div>
        </div>
        <div class="voucher-important-data ps-5">


        </div>
        <div class="row">
            <div class="voucher-body">
                <table>
                    <thead class="thead">
                        <tr>
                            <th class="detail-description ps-3">DESCRIPCIÓN</th>
                            <th class="detail-import">IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="details">
                            <td class="detail-description ps-3" v-if="paymentProof.payment_proofable">
                                <template v-for="detail in paymentProof.payment_proofable.quotation.details ">
                                    <p>{{ detail.name }}</p>
                                </template>
                            </td>
                            <td class="detail-import"> S/.{{ paymentProof.subtotal }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 ms-5">
                Detalle: {{ paymentProof.pay_detail }}
            </div>
            <div class="col-md-6 buttons-container">
                <p class="buttons button-gray">SUBTOTAL S/.{{ paymentProof.subtotal }}</p>
                <p class="buttons button-white">DESCUENTO S/.{{ paymentProof.discount }}</p>
                <p class="buttons button-green">TOTAL S/.{{ paymentProof.total_price }}</p>
            </div>
        </div>
        <footer class="footer">
            <img src="https://jairpl.com/pdf-sys/footer_boleta.png" class="w-100">
        </footer>
    </div>
</template>
<script>
import moment from 'moment';

export default {
    data() {
        return {
            paymentProof: {}
        }
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        getPaymentProof() {
            axios.get('/api/payment-proof/' + this.$route.params.voucherId)
                .then((result) => {
                    this.paymentProof = result.data
                    setTimeout(() => { window.print() }, 1000);
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
    mounted() {
        this.getPaymentProof()
    }

}
</script>
<style>
* {
    font-family: 'Montserrat', sans-serif !important;
}

.ruc {
    margin-top: -130px;
    margin-left: 75%;
    color: #fff;
    font-weight: bold;
}

.logo {
    width: 45%;
    margin-top: -130px;
}

.voucher-subheader {
    color: #36bebf;
    width: 100% !important;
}

.title {
    font-weight: bold;
    margin-bottom: 0px;
    font-size: 15px;
}

.subtitle {
    font-weight: bold;
    font-size: 10px;
}

.voucher-important-data {
    color: #36bebf;
    font-size: 18px;
}

.voucher-important-data span {
    color: #000;
    font-weight: 500;
}

.thead {
    /*background-color: #f4f4f3;*/

    background: rgb(87, 108, 179);
    background: linear-gradient(149deg, rgba(87, 108, 179, 1) 0%, rgba(19, 177, 223, 1) 49%, rgba(92, 194, 166, 1) 100%);
    color: #fff;
    font-weight: bold;
    font-size: 18px;
}

table {
    margin-top: 20px;
    width: 90%;
    border-collapse: separate;
    border-spacing: 0 1em;
}

.details {
    background-color: #f4f4f3;
    padding-top: 10px;
    font-size: 18px;
    font-weight: 500;
}

.detail-description {
    border-radius: 10px 0px 0px 10px;
}

.detail-import {
    border-radius: 0px 10px 10px 0px;
}

.voucher-body {
    padding-left: 10%;
}

.buttons {
    border-radius: 12px;
    font-weight: bold;
    font-size: 17px;
    width: 25%;
    padding: 4px;
}

.button-gray {
    background-color: #f4f4f3;
}

.button-white {}

.button-green {
    background-color: #36bebf;
    color: #fff;
}

.buttons-container {
    margin-left: 60%;
}

.payments {
    padding-left: 60%;
    width: 90%;
    margin-bottom: -120px;
}

.footer {
    position: fixed;
    bottom: 0;
}
</style>