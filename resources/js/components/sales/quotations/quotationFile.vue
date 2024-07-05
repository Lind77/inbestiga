<template>
    <div>
        <nav class="navbar navbar-dark bg-purple">
            <div class="row w-100 px-4 py-3">
                <div
                    class="col-12 d-flex align-items-center justify-content-around"
                >
                    <h2 class="fw-bolder text-white mb-0">COTIZACIÓN</h2>
                    <img
                        src="https://jairpl.com/pdf-sys/logo.png"
                        alt=""
                        class="main-logo mb-3"
                    />
                </div>
            </div>
        </nav>
        <!-- {{ quotation }} -->
        <section class="row user_data_layout">
            <div class="col-8 ps-3">
                <table class="customer-data mt-2">
                    <thead v-if="quotation && quotation.customers">
                        <tr>
                            <th>
                                <h2 class="name-customer">COTIZACIÓN DE:</h2>
                            </th>
                            <th>
                                <template
                                    v-for="customer in quotation.customers"
                                >
                                    <span class="name">{{
                                        customer.name
                                    }}</span>
                                </template>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <h2 class="info-user">Teléfono:</h2>
                            </th>
                            <th>
                                <template
                                    v-for="customer in quotation.customers"
                                >
                                    <span>{{ customer.cell }}</span>
                                </template>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <h2 class="info-user">Carrera o mención:</h2>
                            </th>
                            <th>
                                <span>{{ quotation.customers[0].career }}</span>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <h2 class="info-user">Universidad:</h2>
                            </th>
                            <th>
                                <span>{{
                                    quotation.customers[0].university
                                }}</span>
                            </th>
                        </tr>
                    </thead>
                </table>
                <!-- <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple"></span></p>  -->
            </div>
            <div class="col-4 info-doc py-3" v-if="quotation">
                <p class="info-doc-p">COTIZACIÓN N°: 01-EN-VL</p>
                <p class="info-doc-p">FECHA: {{ quotation.date }}</p>
                <p class="info-doc-p">
                    VALIDEZ: {{ quotation.expiration_date }}
                </p>
                <p class="info-doc-p">
                    IMPORTE: S./ {{ Number(quotation.amount).toFixed(2) }}
                </p>
                <p class="info-doc-p">EJECUCIÓN: {{ quotation.term }}</p>
            </div>
        </section>
        <section class="px-3">
            <table class="main-table mt-3">
                <thead class="mx-5">
                    <tr class="table-header">
                        <th class="text-white fw-bolder py-3 ps-2">
                            PRODUCTO / SERVICIO
                        </th>
                        <th class="text-white fw-bolder py-3 ps-1">TIPO</th>
                        <th class="text-white fw-bolder py-3 ps-1">TOTAL</th>
                    </tr>
                </thead>
                <div style="height: 10px"></div>
                <tbody v-if="quotation">
                    <tr v-for="detail in quotation.details" class="text-dark">
                        <th class="table-item fw-normal ps-2">
                            {{ detail.name }}

                            <template
                                v-if="
                                    detail.product_id == 113 ||
                                    detail.product_id == 58
                                "
                            >
                                <br />
                                - 02 propuestas de tema (opcional)
                                <br />
                                - Plan de tesis o proyecto de investigación
                                <br />
                                - Informe final de tesis o Tesis Final
                                <br />
                                - Orientación y/o asesoría extraordinaria en
                                cualquier etapa de la tesis.
                                <br />
                                - Plantilla de diapositivas
                                <br />
                                - Reporte de similitud TURNITIN
                                <br />
                                - E-book para la sustentación
                                <br />
                                - Balotario de preguntas
                                <br />
                                - Simulación de sustentación
                                <br />
                                - Levantamiento de observaciones
                            </template>
                        </th>
                        <th
                            class="table-item fw-normal"
                            style="white-space: pre; text-align: center"
                        >
                            {{ detail.type == 1 ? "Normal" : "Sugerido" }}
                        </th>
                        <th
                            class="table-item fw-normal"
                            style="text-align: center"
                            v-if="detail.extra_price"
                        >
                            S./{{
                                Number(
                                    parseFloat(detail.price) +
                                        parseFloat(detail.extra_price)
                                ).toLocaleString("en-US")
                            }}
                        </th>
                        <th
                            class="table-item fw-normal"
                            style="text-align: center"
                            v-else
                        >
                            S./{{
                                Number(parseFloat(detail.price)).toLocaleString(
                                    "en-US"
                                )
                            }}
                        </th>
                    </tr>
                    <tr class="sugested-title mt-3">
                        <th class="text-white sugested py-3 px-3" colspan="3">
                            PRECIO FINAL
                        </th>
                    </tr>
                    <!-- <tr>
                        <th></th>
                        <th class="text-purple">DESCUENTO</th>
                        <th class="text-purple">S./{{ quotation.discount }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="text-purple">TOTAL</th>
                        <th class="text-purple">
                            S./{{ Number(quotation.amount).toFixed(2) }}</th>
                    </tr> -->
                </tbody>
            </table>
            <div class="discount-total" v-if="quotation">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <p style="background-color: #f1f2f0">
                            DESCUENTO: S./{{
                                Number(quotation.discount).toLocaleString(
                                    "en-US"
                                )
                            }}
                        </p>
                        <p style="background-color: #f1f2f0">
                            PRECIO FINAL: S./{{
                                Number(quotation.amount).toLocaleString("en-US")
                            }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- <div class="title-note py-2 ms-3 rounded" v-if="quotation[0] && quotation[0].note">
            <p class="text-white mb-0">NOTA:</p>
        </div>
        <div class="section-note" v-if="quotation[0]">
            <p>{{ quotation[0].note }}</p>
        </div> -->
        <section class="last">
            <div class="consideration-title text-white py-3 px-3 mb-3">
                CONSIDERACIONES
            </div>
            <div class="ps-5">
                <p class="ps-2 mb-0 fw-semibold text-dark">
                    *Formalizamos los servicios con un contrato.
                </p>
                <p class="ps-2 mb-0 fw-semibold text-dark">
                    *El contrato finaliza cuando el tesista se titula.
                </p>
                <p class="ps-2 mb-0 fw-semibold text-dark">
                    *Todos los derechos de la tesis pasan a ser del tesista.
                </p>
                <p class="ps-2 mb-0 fw-semibold text-dark">
                    *Protegemos tu identidad, nuestros servicios son
                    confindenciales.
                </p>
            </div>

            <footer class="mt-3">
                <p>
                    Gracias por brindarnos tu confianza. Contáctanos si tienes
                    alguna duda acerca de esta cotización.
                </p>
            </footer>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            quotation: [],
        };
    },
    methods: {
        getQuotationInfo() {
            axios
                .get(`/api/quotations/${this.$route.params.id}`)
                .then((res) => {
                    this.quotation = res.data;
                    this.print();
                })
                .catch((err) => console.error(err));
        },
        print() {
            setTimeout(() => {
                window.print();
            }, 1000);
        },
    },
    mounted() {
        this.getQuotationInfo();
    },
    computed: {
        subTotalProds() {
            if (this.quotation[0]) {
                var total = 0;
                this.quotation[0].details.forEach((detail) => {
                    if (detail.type == 1) {
                        total = total + parseFloat(detail.price);
                    }
                });
                return total;
            }
        },
        subTotalProdsSugest() {
            if (this.quotation[0]) {
                var total = 0;
                this.quotation[0].details.forEach((detail) => {
                    if (detail.type == 2) {
                        total = total + parseFloat(detail.price);
                    }
                });
                return total;
            }
        },
    },
};
</script>

<style scoped>
* {
    font-family: "Montserrat", sans-serif !important;
}

.bg-purple {
    background: rgb(0, 164, 148);
    background: linear-gradient(180deg, #fb15d7 10%, #7f21fb 100%);
    border-radius: 0px 0px 10px 10px;
}

.main-logo {
    width: 200px;
}

.user_data_layout {
    background-color: #f1f2f0;
    padding: 0px 20px 0px 20px;
    margin: 15px 20px 5px 20px;
    border-radius: 5px;
}

.header-text {
    font-family: "Montserrat", sans-serif !important;
    font-weight: 700;
    font-size: 12px;
    color: #fff;
    margin: 0px;
}

.name-customer {
    font-family: "Montserrat", sans-serif;
    font-weight: 900;
    color: #000;
    font-size: 14px;
    text-align: left;
    margin-bottom: 0;
    margin-top: 2px;
}

.name-customer span {
    color: #000;
}

.info-user {
    font-family: "Montserrat", sans-serif;
    font-weight: 700;
    color: #000;
    font-size: 12px;
    margin-bottom: 0;
    margin-top: 2px;
}

.name {
    font-weight: 900;
}

th span {
    font-family: "Montserrat", sans-serif;
    font-weight: 700;
    color: #000;
    padding: 0px 0px 0px 10px;
    display: inline-block;
}

.main-table {
    padding-left: 2.5% !important;
    border-radius: 10px;
    border-spacing: 10px;
}

.main-table tr:nth-child(even) {
    background-color: #6f26f71a;
}

table,
th {
    /* border: 1px solid #000; */
}

.customer-data {
    /* border: 1px solid #000; */
    border-spacing: 0 0;
}

.customer-data tr,
th {
    /*  border: 1px solid #000; */
    vertical-align: top;
}

.info-doc {
    font-weight: 700;
    color: #000;
}

.info-doc-p {
    margin: 0px !important;
}

.sub-header {
    margin-top: 10px;
    font-weight: 700;
}

.text-purple {
    color: #000;
}

.main-table {
    width: 100%;
    border-spacing: 0px;
}

.main-table thead {
    background: linear-gradient(180deg, #fb15d7 10%, #7f21fb 100%);
    border-radius: 10px;
    font-weight: 700;
}

.table-header th:first-child {
    border-radius: 10px 0px 0px 10px;
    padding-left: 15px !important;
}

.table-header th:nth-child(2) {
    text-align: center;
    border: none;
}

.table-header th:nth-child(3) {
    border-radius: 0px 10px 10px 0px;
    text-align: center;
}

.table-item {
    font-weight: 400;
    border-radius: 10px;
    background-color: #f1f2f0;
    padding: 15px 10px;
}

.sugested {
    font-weight: 900;
    border-radius: 10px;
}

.sugested-title {
    background: linear-gradient(180deg, #fb15d7 10%, #7f21fb 100%);
}

.consideration-title {
    background: linear-gradient(180deg, #fb15d7 10%, #7f21fb 100%);
    border-radius: 10px 10px 10px 10px;
    margin: 0px 15px 0px 50px;
    font-weight: 900;
}

.discount-total {
    font-weight: bold;
    color: #000;
    display: flex;
    flex-direction: column;
}

.discount-total p {
    text-align: end;
    padding-right: 10px;
    padding-left: -500px;
    margin-top: 5px;
}

.title-note {
    background: linear-gradient(
        90deg,
        rgba(0, 164, 148, 1) 35%,
        rgba(87, 72, 152, 1) 100%
    );
    width: 130px;
    font-weight: bold;
    padding: 3px 0px 3px 0px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0px 10px 0px 0px;
}

.section-note {
    background-color: #f1f2f0;
    margin: 5px 10px 0px 15px;
    padding: 5px 5px 2px 5px;
    border-radius: 10px;
    width: 95%;
}

.pig-text {
    font-weight: 700;
    font-size: 20px;
    color: #000;
}

.pig-text span {
    color: #000;
}

.circle {
    width: 450px;
    padding-left: 240px;
}

.last {
    margin-top: 20px;
}

.watermark {
    position: absolute;
    top: 28%;
    left: 30%;
    width: 40%;
    z-index: -1;
}

footer {
    background-color: #f1f2f0;
    color: #000;
    font-size: 15px;
    font-weight: 700;
    padding: 15px 28px 15px 28px;
    text-align: center;
    width: 100%;
}
</style>
