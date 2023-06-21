<template>
    <div class="d-flex justify-content-center align-items-center">
        <div class="page">
            <nav class="navbar navbar-dark bg-purple">
                <div class="row w-100 px-4 py-1">
                    <div class="col-6 d-flex align-items-center justify-content-center">
                        <img src="https://inbestiga.com/pdf-sys/logo.png" alt="" class="main-logo">
                    </div>
                    <div class="col-6">
                        <p class="header-text">Prol. Cuzco 921 Huancayo.</p>
                        <p class="header-text">Elías Aguirre N° 180 - 3er Piso - Miraflores - Lima</p>
                        <p class="header-text">www.inbestiga.com</p>
                        <p class="header-text">991 045 555</p>
                    </div>
                </div>
            </nav>
            <section class="row">
                <div class="col-6 ps-5 pt-4">
                    <table class="customer-data">
                        <thead v-if="quotation[0]">
                            <tr>
                                <th>
                                    <h2 class="name-customer">COTIZACIÓN DE: </h2>
                                </th>
                                <th><span class="name">{{ quotation[0].customer.name }}</span></th>
                            </tr>
                            <tr>
                                <th>
                                    <h2 class="info-user">Teléfono: </h2>
                                </th>
                                <th><span>{{ quotation[0].customer.cell }}</span></th>
                            </tr>
                            <tr>
                                <th>
                                    <h2 class="info-user">Carrera o mención: </h2>
                                </th>
                                <th><span>{{ quotation[0].customer.career }}</span></th>
                            </tr>
                            <tr>
                                <th>
                                    <h2 class="info-user">Universidad: </h2>
                                </th>
                                <th><span>{{ quotation[0].customer.university }}</span></th>
                            </tr>
                        </thead>
                    </table>
                    <!-- <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple"></span></p>  -->
                </div>
                <div class="col-6 info-doc pt-3" v-if="quotation[0]">
                    <p class="info-doc-p">COTIZACIÓN N°: 01-EN-VL</p>
                    <p class="info-doc-p">FECHA: {{ quotation[0].date }}</p>
                    <p class="info-doc-p">VALIDEZ: {{ quotation[0].expiration_date }}</p>
                    <p class="info-doc-p">IMPORTE: S./ {{ quotation[0].amount }}</p>
                    <p class="info-doc-p">EJECUCIÓN: {{ quotation[0].term }}</p>
                </div>
            </section>
            <section class="d-flex justify-content-center">
                <table class="main-table mt-3">
                    <thead>
                        <tr>
                            <th class="text-purple fw-bolder py-3 ps-2">PRODUCTO / SERVICIO</th>
                            <th class="text-purple fw-bolder py-3 ps-1">DESCRIPCIÓN</th>
                            <th class="text-purple fw-bolder py-3 ps-1">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody v-if="quotation[0]">
                        <tr v-for="detail in quotation[0].details" class="text-dark">
                            <th class="table-item fw-normal ps-2" v-if="detail.type == 1">{{ detail.product.title }}
                                <template v-if="detail.product_id == 34">
                                    <br>
                                    - 02 propuestas de tema (opcional)
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
                                    <br>
                                    - Levantamiento de observaciones
                                </template>
                            </th>
                            <th class="table-item fw-normal" v-if="detail.type == 1" style="white-space: pre;">
                                {{ detail.description }}</th>
                            <th class="table-item fw-normal" v-if="detail.type == 1">S./{{ detail.price }}</th>
                        </tr>

                        <tr style=" background-color: #ffffff00;">
                            <th></th>
                            <th class="text-purple">TOTAL</th>
                            <th class="text-purple">S./{{ subTotalProds }}</th>
                        </tr>
                        <tr class="sugested-title">
                            <th class="text-purple sugested py-3 ps-1" colspan="3">PRODUCTO SUGERIDO</th>
                        </tr>
                        <tr v-for="detail in quotation[0].details" class="text-dark">
                            <th class="table-item fw-normal ps-2" v-if="detail.type == 2">{{ detail.product.title }}</th>
                            <th class="table-item fw-normal" v-if="detail.type == 2" style="white-space: pre;">
                                {{ detail.description }}</th>
                            <th class="table-item fw-normal" v-if="detail.type == 2">S./{{ detail.price }}</th>
                        </tr>

                        <tr style=" background-color: #ffffff00;">
                            <th></th>
                            <th class="text-purple">TOTAL</th>
                            <th class="text-purple">S./ {{ subTotalProdsSugest }}</th>
                        </tr>
                        <tr class="sugested-title">
                            <th class="text-purple sugested py-3 ps-1" colspan="3">PRECIO FINAL</th>
                        </tr>

                        <tr style=" background-color: #ffffff00;">
                            <th></th>
                            <th class="text-danger">DESCUENTO</th>
                            <th class="text-danger">S./{{ quotation[0].discount }}</th>
                        </tr>
                        <tr style=" background-color: #ffffff00;">
                            <th></th>
                            <th class="text-purple">TOTAL</th>
                            <th class="text-purple">S./{{ quotation[0].amount }}</th>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="last">
                <div class="row mt-3">
                    <div class="col-6 ps-5 d-flex justify-content-center align-items-center">
                        <img src="https://inbestiga.com/pdf-sys/pig.png" class="w-25">
                        <p class="ps-3 pig-text">Recuerda que puedes hacer el pago en <span>CUOTAS</span>!</p>
                    </div>
                    <div class="col-6"></div>
                </div>
                <footer class="mt-2">
                    <p>Gracias por brindarnos tu confianza. Contáctanos si tienes alguna duda acerca de esta cotización.</p>
                </footer>
            </section>
            <img src="https://inbestiga.com/pdf-sys/watermark.png" class="watermark">
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            quotation: []
        }
    },
    methods: {
        getQuotationInfo() {
            axios.get(`/api/quotations/${this.$route.params.id}`)
                .then((res) => {
                    this.quotation = res.data
                })
                .catch(err => console.error(err))
        },
        print() {
            setTimeout(() => { window.print() }, 1000);

        }
    },
    mounted() {
        this.getQuotationInfo()
    },
    computed: {
        subTotalProds() {
            if (this.quotation[0]) {
                var total = 0
                this.quotation[0].details.forEach(detail => {
                    if (detail.type == 1) {
                        total = total + parseFloat(detail.price)
                    }
                });
                return total
            }
        },
        subTotalProdsSugest() {
            if (this.quotation[0]) {
                var total = 0
                this.quotation[0].details.forEach(detail => {
                    if (detail.type == 2) {
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
* {
    font-family: 'Montserrat', sans-serif !important;
}

.page {
    width: 1200px;

    background-color: #fff;
}

.bg-purple {
    background-color: #6E26F7;
    border-radius: 0px 0px 10px 10px;
}

.main-logo {
    width: 270px;
}

.header-text {
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700;
    font-size: 15px;
    color: #fff;
    margin: 0px;
}

.name-customer {
    font-family: 'Montserrat', sans-serif;
    font-weight: 900;
    color: #6E26F7;
    font-size: 18px;
    text-align: left;
    margin-bottom: 0;
    margin-top: 2px;
}

.name-customer span {
    color: #000;
}

.info-user {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    color: #6E26F7;
    font-size: 15px;
    margin-bottom: 0;
    margin-top: 2px;
}

.name {
    font-weight: 900;
    font-size: 19px;
}

th span {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    color: #000;
    padding: 0px 0px 0px 10px;
    display: inline-block;
}

.main-table tr:nth-child(even) {
    background-color: #6f26f71a;
}

table,
th {
    /* border: 1px solid #000; */
}

.customer-data {
    font-size: 16px;
}

.customer-data tr,
th {
    /*  border: 1px solid #000; */
    vertical-align: top;
}

.info-doc {
    font-weight: 700;
    color: #000;
    font-size: 16px;
    padding-left: 40px;
}

.info-doc-p {
    margin: 0px !important;
}

.sub-header {
    margin-top: 15px;
    font-weight: 700;
}

.text-purple {
    color: #6E26F7;
    font-size: 20px;
}

.main-table {
    width: 100%;
}

.main-table thead {
    background-color: #6f26f71a;
    font-weight: 700;
}

.table-item {
    font-weight: 400;
    border: 1px solid #6E26F7;
    font-size: 20px;
}

.sugested {
    font-weight: 900;
}

.sugested-title {
    background-color: #6f26f71a;
}

.pig-text {
    font-weight: 700;
}

.pig-text span {
    color: #6E26F7;
}

.last {}

.watermark {
    margin-top: -90%;
    margin-left: 33%;
    width: 33%;
    z-index: -1;
}

footer {
    background-color: #6f26f71a;
    color: #000;
    font-size: 15px;
    font-weight: 700;
    padding: 15px 18px 15px 18px;
    text-align: center;
}
</style>