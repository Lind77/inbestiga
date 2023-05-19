<template>
    <div>
        <nav class="navbar navbar-dark bg-purple">
        <div class="row w-100 px-4 py-3">
            <div class="col-12 d-flex align-items-center justify-content-around">
                <h2 class="fw-bolder text-white mb-0">COTIZACIÓN</h2>
                <img src="https://inbestiga.com/pdf-sys/logo.png" alt="" class="main-logo mb-3">
            </div>
        </div>
    </nav>
    <section class="row user_data_layout">
        <div class="col-8 ps-5 pt-4">
            <table class="customer-data">
                <thead v-if="quotation[0]">
                    <tr>
                        <th><h2 class="name-customer">COTIZACIÓN DE: </h2></th>
                        <th><span class="name">{{quotation[0].customer.name}}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Teléfono: </h2></th>
                        <th><span>{{ quotation[0].customer.cell }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Carrera o mención: </h2></th>
                        <th><span>{{ quotation[0].customer.career }}</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Universidad: </h2></th>
                        <th><span>{{ quotation[0].customer.university }}</span></th>
                    </tr>
                </thead>
            </table>
            <!-- <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple"></span></p>  -->
        </div>
        <div class="col-4 info-doc py-3" v-if="quotation[0]">
            <p class="info-doc-p">COTIZACIÓN N°: 01-EN-VL</p>
            <p class="info-doc-p">FECHA: {{ quotation[0].date}}</p>
            <p class="info-doc-p">VALIDEZ: {{ quotation[0].expiration_date}}</p>
            <p class="info-doc-p">IMPORTE: S./ {{ Number(quotation[0].amount).toFixed(2)}}</p>
            <p class="info-doc-p">EJECUCIÓN: {{ quotation[0].term }}</p>
        </div>
    </section>
    <section class="px-3">
       
        <table class="main-table mt-3">
            <thead class="mx-5">
                <tr class="table-header">
                    <th class="text-white fw-bolder py-3 ps-2">PRODUCTO / SERVICIO</th>
                    <th class="text-white fw-bolder py-3 ps-1">TIPO</th>
                    <th class="text-white fw-bolder py-3 ps-1">TOTAL</th>
                </tr>
            </thead>
            <div style="height: 10px;"></div>
            <tbody v-if="quotation[0]">
                <tr v-for="detail in quotation[0].details" class="text-dark">
                    <th class="table-item fw-normal ps-2">{{detail.new_product.name}}
                    <template v-if="detail.new_product.id == 58">
                        <br>
                        - 02 propuestas de tema
                        <br>
                        - Plan de tesis o proyecto de investigación
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
                    </th>
                    <th class="table-item fw-normal" style="white-space: pre; text-align: center;">{{detail.type==1?'Normal':'Sugerido'}}</th>
                    <th class="table-item fw-normal" style="text-align: center;">S./{{detail.price}}</th>
                </tr>

               
               
                <tr class="sugested-title mt-3">
                    <th class="text-white sugested py-3 px-3" colspan="3">PRECIO FINAL</th>
                </tr>
                <!-- <tr>
                    <th></th>
                    <th class="text-purple" style=" background-color: red;">DESCUENTO</th>
                    <th class="text-purple" style=" background-color: red;">S./{{quotation[0].discount}}</th>
                </tr>
                <tr >
                    <th></th>
                    <th class="text-purple" style=" background-color: red;">TOTAL</th>
                    <th class="text-purple" style=" background-color: red;">S./{{Number(quotation[0].amount).toFixed(2)}}</th>
                </tr> -->
            </tbody>
        </table>
        <div class="discount-total" v-if="quotation[0]">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <p style="background-color: #f1f2f0;">DESCUENTO: S./{{ quotation[0].discount }}</p>
                    <p style="background-color: #f1f2f0;">TOTAL: S./{{ Number(quotation[0].amount).toFixed(2) }}</p>
                </div>
            </div>
        </div>
    </section>
    <div class="title-note py-2 ms-3 rounded">
        <p class="text-white mb-0">NOTA:</p>
    </div>
    <div class="section-note" v-if="quotation[0]">
        <p>{{ quotation[0].note }}</p>
    </div>
    <section class="last">
        <div class="d-flex justify-content-around">
            <div class="d-flex w-50">
                <img src="https://inbestiga.com/pdf-sys/circle.png" width="150">
                <p class="ps-3 pig-text">Recuerda que puedes hacer el pago en CUOTAS!</p>
            </div>
                <img src="https://inbestiga.com/pdf-sys/square.png" width="120" height="70">
               
        </div>
        <footer class="mt-3">
            <p>Gracias por brindarnos tu confianza. Contáctanos si tienes alguna duda acerca de esta cotización.</p>
        </footer>
    </section>
   
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
            axios.get(`/api/quotation/${this.$route.params.id}`)
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
    },
    computed:{
        subTotalProds(){
            if(this.quotation[0]){
                var total = 0
                this.quotation[0].details.forEach(detail => {
                    if(detail.type == 1){
                        total = total + parseFloat(detail.price)
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
                        total = total + parseFloat(detail.price)
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
            background: rgb(0,164,148);
            background: linear-gradient(90deg, rgba(0,164,148,1) 35%, rgba(87,72,152,1) 100%);
            border-radius: 0px 0px 10px 10px;
        }
        .main-logo{
            width: 200px;
        }

        .user_data_layout{
            background-color: #f1f2f0;
            padding: 0px 20px 0px 20px;
            margin: 15px 20px 5px 20px;
            border-radius: 5px;
        }
        .header-text{
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            margin: 0px;
        }
        .name-customer{
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            color: #000;
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
            color: #000;
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
        .main-table{
            padding-left: 2.5% !important;
            border-radius: 10px;
            border-spacing: 10px;
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
            color: #000;
        }
        .main-table{
            width: 100%;
            border-spacing: 10px;
        }
        .main-table thead{
            background: linear-gradient(90deg, rgba(0,164,148,1) 35%, rgba(87,72,152,1) 100%);
            border-radius: 10px;
            font-weight: 700;
        }
        .table-header th:first-child{
            border-radius: 10px 0px 0px 10px;
            padding-left: 15px !important;
        }
        .table-header th:nth-child(2){
            text-align: center;
            border: none;
        }
        .table-header th:nth-child(3){
            border-radius: 0px 10px 10px 0px;
            text-align: center;
        }
        .table-item{
            font-weight: 400;
            border-radius: 10px;
            background-color: #f1f2f0;
            padding: 15px 10px; 
        }
        
        .sugested{
            font-weight: 900;
            border-radius: 10px;
        }
        .sugested-title{
            background: linear-gradient(90deg, rgba(0,164,148,1) 35%, rgba(87,72,152,1) 100%);
        }

        .discount-total{
           
            font-weight: bold;
            color: #000;
            display: flex;
            flex-direction: column;
        }
        .discount-total p{
            text-align: end;
            padding-right: 10px;
            padding-left: -500px;
            margin-top: 5px;
        }
        .title-note{
            background: linear-gradient(90deg, rgba(0,164,148,1) 35%, rgba(87,72,152,1) 100%);
            width: 130px;
            font-weight: bold;
            padding: 3px 0px 3px 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0px 10px 0px 0px;
        }
        .section-note{
            background-color: #f1f2f0;
            margin: 5px 10px 0px 15px;
            padding: 5px 5px 2px 5px;
            border-radius: 10px;
            width: 95%;
        }
        .pig-text{
            font-weight: 700;
            font-size: 20px;
            color: #000;
        }
        .pig-text span{
            color: #000;
        }
        .circle{
            width: 450px;
            padding-left: 240px;
        }
        .last{
            position: absolute;
            bottom: 0;
        }
        .watermark{
            position: absolute;
            top: 28%;
            left: 30%;
            width: 40%;
            z-index: -1;
        }
        footer{
            background-color: #f1f2f0;
            color: #000;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 28px 15px 28px;
            text-align: center;
            width: 100%;
        }

</style>