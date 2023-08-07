<template>
    <div class="voucher">
        <div class="row voucher-header pb-4">
            <img src="https://inbestiga.com/pdf-sys/headerboleta.png" alt="" srcset="">
            <div class="col-md-6">
                <img src="https://inbestiga.com/pdf-sys/logoboleta2.png" alt="" class="logo ms-5">
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="voucher-subheader d-flex">
            <div class="col-md-4 px-5">
                <p class="title voucher-subheader">SEDE HUANCAYO</p>
                <p class="subtitle voucher-subheader">Prolongación Cuzco 921
                    <br> Huancayo
                </p>
            </div>
            <div class="col-md-4 px-5">
                <p class="title voucher-subheader">SEDE LIMA</p>
                <p class="subtitle voucher-subheader">Calle Elías Aguirre 180, Piso 3
                    <br> Miraflores
                </p>
            </div>
            <div class="col-md-4 px-5">
                <p class="title voucher-subheader">FECHA:</p>
            </div>
        </div>
        <div class="voucher-important-data ps-5 mt-2">
            <p class="title voucher-important-data">FECHA DE EMISIÓN: </p>
            <p class="title voucher-important-data">N° DE RECIBO: </p>
            <p class="title voucher-important-data">SEÑOR(A): </p>
            <p class="title voucher-important-data">TIPO DE MONEDA: </p>
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
                            <td class="detail-description ps-3">Tesis Total</td>
                            <td class="detail-import"> S./1000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 buttons-container">
                <p class="buttons button-gray">SUBTOTAL S./10000</p>
                <p class="buttons button-white">DESCUENTO S./1</p>
                <p class="buttons button-green">TOTAL S./9999</p>
            </div>
        </div>
        <footer class="footer">
            <img src="https://inbestiga.com/pdf-sys/payments.png" class="w-0 payments">
            <img src="https://inbestiga.com/pdf-sys/footerboleta.png" class="w-100">
        </footer>
    </div>
</template>
<script>
export default {

}
</script>
<style>
* {
    font-family: 'Montserrat', sans-serif !important;
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
    font-size: 20px;
}

.subtitle {
    font-weight: bold;
    font-size: 15px;
}

.voucher-important-data {
    color: #36bebf;
    font-size: 25px;
}

.thead {
    /*background-color: #f4f4f3;*/

    background-color: #f4f4f3;
    color: #545557;
    font-weight: bold;
    font-size: 20px;
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
    font-size: 25px;
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
    font-size: 20px;
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