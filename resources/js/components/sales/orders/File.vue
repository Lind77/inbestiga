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
    <section class="row" v-if="order.quotation">
        <div class="ps-5 pt-3">
            <h2 class="name-customer">TIPO DE SERVICIO: <span class="name text-dark">SERVICIO ESPECÍFICO</span> </h2>
            
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead >
                    <tr>
                        <th><h2 class="name-customer">Fecha: </h2></th>
                        <th><span class="name">{{order.quotation.customer.name}}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Importe: </h2></th>
                        <th><span> S./{{ totalPrice }}</span></th>
                    </tr>
                </thead>
            </table>
            <!-- <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple"></span></p>  -->
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead>
                    <tr>
                        <th><h2 class="info-user">Teléfono: </h2></th>
                        <th><span>{{ order.quotation.customer.cell }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">N° DNI: </h2></th>
                        <th><span>{{ order.quotation.customer.dni }}</span></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-4 ps-5 pt-4">
            <table class="customer-data">
                <thead >
                    <tr>
                        <th><h2 class="info-user">Universidad: </h2></th>
                        <th><span>{{ order.quotation.customer.university }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Carrera o mención: </h2></th>
                        <th><span>{{ order.quotation.customer.career }}</span></th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
    <section class="d-flex justify-content-center">
        <table class="main-table mt-3">
            <thead>
                <tr>
                    <th class="text-purple fw-bolder py-3 ps-2">DESCRIPCIÓN DE ORDEN / SERVICIO</th>
                    <th class="text-purple fw-bolder py-3 ps-1 " style="text-align: center;">PRECIO</th>
                    <th class="text-purple fw-bolder py-3 ps-1">ENTREGA FINAL</th>
                    <th class="text-purple fw-bolder py-3 ps-1">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody v-if="order.quotation">
                <tr class="text-dark" v-for="(detail, index) in order.quotation.details" :key="index">
                    <td class="table-item ps-2" width="30%" v-if="detail.type <= order.suggested">
                            <template v-if="detail.type <= order.suggested">
                                <h5 class="fw-bold text-dark m-0 pb-0">{{ detail.new_product.name }}</h5>
                            <template v-if="detail.product_id == 34">
                                - Plan de tesis o proyecto de investigación
                                <br>
                                - Aplicación de instrumentos y procesamiento estadístico
                                <br>
                                - Informe final de tesis o Tesis Final
                                <br>
                                - Orientación y/o asesoría extraordinaria en cualquier etapa de la tesis.
                                <br>
                                - Plantilla de diapositivas
                                <br>
                                - Reporte de similitud TURNITIN
                                <br>
                                - E-book para la sustentación
                                <br>
                                - Balotario de preguntas
                                <br>
                                - Simulación de sustentación
                            </template>
                            </template>
                    </td>
                    <td class="table-item" width="10%"  v-if="detail.type <= order.suggested">
                        <p class="mb-0" style="text-align: center;">S./ {{ detail.price }}</p>
                    </td>
                    <template v-if="index == 0">
                    <td class="table-item ps-2" width="30%" :rowspan="order.quotation.details.length">
                        <p>{{ order.final_delivery }}</p>
                    </td>
                    <td class="table-item ps-2" width="30%" :rowspan="order.quotation.details.length">
                        <p>{{ order.observations }}</p>
                    </td>
                    </template>
                    
                    <!-- <th class="table-item fw-normal ps-2" >{{detail.product.title}}</th>
                    <th class="table-item fw-normal px-3" >S./{{detail.price}}</th>
                    <th class="table-item fw-normal px-2" ></th>
                    <th class="table-item fw-normal px-2" width="30%">{{ order.observations }}</th> -->
                </tr>
                <tr class="sugested-title">
                    <th class="text-purple sugested py-3 ps-2">TOTAL</th>
                    <th class="text-purple sugested py-3" style="text-align: center;">S/ {{totalPrice }}</th>
                    <th  class="text-danger sugested py-3 ps-1">* DESCUENTO S./{{order.quotation.discount}}</th>
                </tr>
            </tbody>
        </table>
    </section>
    <section>
        <div class="row mt-3">
            <div class="col-4 px-2">
                <p v-for="(payment, index) in order.payments" class="ps-4 h5">
                    {{index+1+'° Pago'}} {{ payment.date }} S./{{ payment.amount }}
                </p>
            </div>
            <div class="col-3 signature-box">
                <h5 class="signature-text">Firma de Conformidad</h5>
                <div class="signature"></div>
            </div>
            <div class="col-3 signature-box">
                <h5 class="signature-text">Aprobación de dirección</h5>
                <div class="signature"></div>
            </div>
        </div>
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
            order: {}
        }
    },
    methods:{
        getQuotationInfo(){
            axios.get('/api/quotationByOrder/'+ this.$route.params.id)
            .then((res) => {
                console.log(res.data)
                this.order = res.data 
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
    },
    computed:{
       totalPrice(){
        var details = this.order.quotation.details
        var sumTotal = 0

        details.forEach(detail =>{
            if(detail.type <= this.order.suggested){
                sumTotal += parseFloat(detail.price)
            }
           
        })

        return sumTotal - parseFloat(this.order.quotation.discount)
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
            vertical-align: top;
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
        .signature-box{
            display: flex;
            justify-content: start;
        }
        .signature{
            height: 50px;
            border: 2px solid #6E26F7;
            border-radius: 3px;
            width: 40%;
            padding-right: -10%;
        }
        .signature-text{
            font-weight: 800;
            color: #000;
        }
        .watermark{
            position: absolute;
            top: 20%;
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