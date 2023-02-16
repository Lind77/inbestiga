<template>
    <div>
        <nav class="navbar navbar-dark bg-purple">
        <div class="row w-100 px-4 py-3">
            <div class="col-4 d-flex align-items-center justify-content-center">
                <img src="https://inbestiga.com/pdf-sys/logo.png" alt="" class="main-logo">
            </div>
            <div class="col-4">
                <p class="header-text">Prol. Cuzco 921 Huancayo.</p>
                <p class="header-text">Elías Aguirre N° 180 - 3er Piso - Miraflores - Lima</p>
                <p class="header-text">www.inbestiga.com</p>
                <p class="header-text">991 045 555</p>
            </div>
            <div class="col-4 d-flex justify-align-center align-items-center">
                <p class="order-title">ORDEN DE SERVICIO</p>
            </div>
        </div>
    </nav>
    <section class="row">
        <div class="ps-5 pt-3">
            <h2 class="name-customer">TIPO DE SERVICIO: <span class="name text-dark">SERVICIO ESPECÍFICO</span> </h2>
            
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead v-if="quotation[0]">
                    <tr>
                        <th><h2 class="name-customer">Fecha: </h2></th>
                        <th><span class="name">{{quotation[0].customer.name}}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Importe: </h2></th>
                        <th><span>{{ quotation[0].customer.cell }}</span></th>
                    </tr>
                </thead>
            </table>
            <!-- <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple"></span></p>  -->
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead v-if="quotation[0]">
                    <tr>
                        <th><h2 class="info-user">Teléfono: </h2></th>
                        <th><span>{{ quotation[0].customer.cell }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">N° DNI: </h2></th>
                        <th><span>{{ quotation[0].customer.career }}</span></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead v-if="quotation[0]">
                    <tr>
                        <th><h2 class="info-user">Universidad: </h2></th>
                        <th><span>{{ quotation[0].customer.university }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Carrera o mención: </h2></th>
                        <th><span>{{ quotation[0].customer.career }}</span></th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- <div class="col-4 info-doc pt-3" v-if="quotation[0]">
            <p class="info-doc-p">COTIZACIÓN N°: 01-EN-VL</p>
            <p class="info-doc-p">FECHA: {{ quotation[0].date}}</p>
            <p class="info-doc-p">VALIDEZ: {{ quotation[0].expiration_date}}</p>
            <p class="info-doc-p">IMPORTE: S./ {{ quotation[0].amount}}</p>
            <p class="info-doc-p">EJECUCIÓN: {{ quotation[0].term }}</p>
        </div> -->
    </section>
    <section class="d-flex justify-content-center">
       
        <table class="main-table mt-3">
            <thead>
                <tr>
                    <th class="text-purple fw-bolder py-3 ps-2">DESCRIPCIÓN DE ORDEN / SERVICIO</th>
                    <th class="text-purple fw-bolder py-3 ps-1">PRECIO</th>
                    <th class="text-purple fw-bolder py-3 ps-1">ENTREGA FINAL</th>
                    <th class="text-purple fw-bolder py-3 ps-1">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody v-if="quotation[0]">
                <tr v-for="detail in quotation[0].details" class="text-dark">
                    <th class="table-item fw-normal ps-2" v-if="detail.type == 1 ">{{detail.product.title}}</th>
                    <th class="table-item fw-normal" v-if="detail.type == 1 ">S./{{detail.price}}</th>
                    <th class="table-item fw-normal"  v-if="detail.type == 1 " >-Bajo Coordinacion(Avance del 80% martes 24 de enero)</th>
                    <th class="table-item fw-normal"  v-if="detail.type == 1 ">-</th>
                </tr>
                <tr class="sugested-title">
                    <th class="text-purple sugested py-3 ps-1">TOTAL</th>
                    <th class="text-purple sugested py-3 ps-1">S/ 0000</th>
                    <th  class="text-purple sugested py-3 ps-1">DESCUENTO S./{{quotation[0].discount}}</th>
                </tr>
               
                <tr style=" background-color: #ffffff00;">
                    <th></th>
                    <th class="text-danger"></th>
                    <th class="text-danger"></th>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="last">
        <footer class="mt-3">
            <p>Gracias por brindarnos tu confianza. Contáctanos si tienes alguna duda acerca de esta orden de servicio.</p>
            <p>Recuerda que esta orden tiene valor contractual</p>
            <p class="top-secret">* El LOCADOR tendrá una prórroga de hasta dos días hábiles para la entrega de avances</p>
        </footer>
    </section>
    <img src="https://inbestiga.com/pdf-sys/watermark_order.png" class="watermark">
    </div>
</template>
<script>
export default {
    data(){
        return{
            quotation: []
        }
    },
    methods:{
        getQuotationInfo(){
            axios.get(`/api/quotation/1`)
            .then((res) => {
                this.quotation = res.data 
                this.print()
            })
            .catch(err => console.error(err))
        },
        print(){
            setTimeout(()=>{window.print()}, 1000);
            
        }
    },
    mounted(){
        this.getQuotationInfo()
        this.print()
    },
    computed:{
        subTotalProds(){
            if(this.quotation[0]){
                var total = 0
                this.quotation[0].details.forEach(detail => {
                    if(detail.type == 1){
                        total = total + detail.price
                    }
                }); 
                return total
            }
        },
        subTotalProdsSugest(){
            if(this.quotation[0]){
                var total = 0
                this.quotation[0].details.forEach(detail => {
                    if(detail.type == 2){
                        total = total + detail.price
                    }
                }); 
                return total
            }
        }
    }
}
</script>
<style scoped>
        *{
            font-family: 'Montserrat', sans-serif !important;
        }
        .bg-purple{
            background-color: #6E26F7;
            border-radius: 0px 0px 10px 10px;
        }
        .main-logo{
            width: 300px;
        }
        .header-text{
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            margin: 0px;
        }
        .order-title{
            font-weight: 900;
            font-size: 30px;
            color: #fff;
        }
        .name-customer{
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            color: #6E26F7;
            font-size: 14px;
            text-align: left;
            margin-bottom: 0;
            margin-top: 2px;
        }
        .name-customer span{
            color: #000;
        }
        .info-user{
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #6E26F7;
            font-size: 12px;
            margin-bottom: 0;
            margin-top: 2px;
        }
        .name{
            font-weight: 900;
        }
        th span{
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #000;
            padding: 0px 0px 0px 10px;
            display: inline-block;
        }
        .main-table tr:nth-child(even) {
            background-color: #6f26f71a;
        }
        table, th{
            /* border: 1px solid #000; */
        }
        .customer-data{
            /* border: 1px solid #000; */
        }
        .customer-data tr, th{
           /*  border: 1px solid #000; */
            vertical-align:top;
        }
        .info-doc{
            font-weight: 700;
            color: #000;
        }
        .info-doc-p{
            margin: 0px !important;
        }
        .sub-header{
            margin-top: 10px;
            font-weight: 700;
        }
        .text-purple{
            color: #6E26F7;
        }
        .main-table{
            width: 100%;
        }
        .main-table thead{
            background-color: #6f26f71a;
            font-weight: 700;
        }
        .table-item{
            font-weight: 400;
            border: 1px solid #6E26F7;
        }
        .sugested{
            font-weight: 900;
        }
        .sugested-title{
            background-color: #6f26f71a;
        }
        .pig-text{
            font-weight: 700;
        }
        .pig-text span{
            color: #6E26F7;
        }
        .last{
            position: absolute;
            bottom: 0;
        }
        .watermark{
            position: absolute;
            top: 38%;
            left: 10%;
            width: 80%;
            z-index: -1;
        }
        footer{
            background-color: #6f26f71a;
            color: #000;
            font-size: 15px;
            width: 150%;
            font-weight: 700;
            padding: 15px 18px 15px 18px;
            text-align: center;
        }
        footer .top-secret{
            font-size: 6px;
            text-align: start;
        }
</style>