<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="w-full p-2 d-flex justify-content-between">
            <h4 class="fw-bold">Post venta</h4>
            <button class="btn btn-success btn-sm" @click="downloadExcel">
                Descargar
            </button>
        </div>
        <div class="card pt-2">
            <div class="w-full p-2 d-flex justify-content-between">
                <button class="btn btn-primary btn-sm" @click="backMonth">
                    Anterior
                </button>
                <p class="fw-bold">{{ currentMonth }}</p>
                <button class="btn btn-primary btn-sm" @click="nextMonth">
                    Siguiente
                </button>
            </div>
            <div class="w-full p-2"></div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha de Registro</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Sexo</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Celular</th>
                            <th>Ciudad de residencia</th>
                            <th>Universidad</th>
                            <th>Carrera o mención</th>
                            <th>Tipo de tesis</th>
                            <th>Grado</th>
                            <th>Monto contratado</th>
                            <th>Canal de comunicación preferido</th>
                            <th>Cuenta con lugar de estudio</th>
                            <th>¿Cómo te enteraste de nuestros servicios?</th>
                            <th>
                                ¿Cuál fue el factor principal que te llevó a
                                contratar nuestros servicios?
                            </th>
                            <th>
                                ¿Cómo realizaste la contratación de nuestros
                                servicios?
                            </th>
                            <th>¿Cuál es tu situación académica actual?</th>
                            <th>Estado profesional</th>
                            <th>
                                ¿Qué tanto deseas participar en la elaboración
                                de tu tesis?
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="postsale in postSales">
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .registration_date
                                            : "Sin asignar"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .code
                                            : "Sin asignar"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>{{ postsale.name }}</td>
                            <td>{{ postsale.email }}</td>
                            <td>{{ postsale.dni }}</td>
                            <td>
                                {{
                                    postsale.gender
                                        ? postsale.gender == 1
                                            ? "Masculino"
                                            : "Femenino"
                                        : "Sin asignar"
                                }}
                            </td>

                            <td>
                                {{
                                    postsale.birth_date
                                        ? postsale.birth_date
                                        : "Sin asignar"
                                }}
                            </td>

                            <td>{{ postsale.cell }}</td>

                            <td>
                                {{
                                    postsale.province
                                        ? postsale.province.name
                                        : "Sin asignar"
                                }}
                            </td>
                            <td>{{ postsale.university }}</td>
                            <td>{{ postsale.career }}</td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .thesis_type_id
                                                ? postsale.quotations[0]
                                                      .contract.thesis_type_id
                                                : "Sin asignar"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .thesis_degree_id
                                                ? postsale.quotations[0]
                                                      .contract.thesis_degree_id
                                                : "Sin asignar"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? `S./ ${postsale.quotations[0].amount}`
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .comunication_channel
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .comunication_channel
                                                          .name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .study_place
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .study_place.name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .marketing_source
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .marketing_source.name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .hire_factor
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .hire_factor.name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .contract_mode
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .contract_mode.name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .academic_situation
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .academic_situation
                                                          .name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .professional_status
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .professional_status
                                                          .name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                            <td>
                                {{
                                    postsale.quotations
                                        ? postsale.quotations[0].contract
                                            ? postsale.quotations[0].contract
                                                  .post_form
                                                ? postsale.quotations[0]
                                                      .contract.post_form
                                                      .participation
                                                    ? postsale.quotations[0]
                                                          .contract.post_form
                                                          .participation.name
                                                    : "No contestado"
                                                : "Formulario no contestado"
                                            : "Sin contrato"
                                        : "Sin cotización"
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import { localeData } from "moment_spanish_locale";

export default {
    setup() {
        moment.locale("es", localeData);
    },
    data() {
        return {
            postSales: [],
            currentMonth: moment(new Date()).format("MMMM YYYY"),
            monthWithoutFormat: moment(new Date()).format("YYYY-MM"),
        };
    },
    methods: {
        getPostSalesByMonth(month) {
            axios
                .get("/api/post-sales-month/" + month)
                .then((result) => {
                    this.postSales = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        backMonth() {
            this.monthWithoutFormat = moment(this.currentMonth, "MMMM YYYY")
                .subtract(1, "month")
                .format("YYYY-MM");
            this.getPostSalesByMonth(this.monthWithoutFormat);
            this.currentMonth = moment(this.monthWithoutFormat).format(
                "MMMM YYYY"
            );
        },
        nextMonth() {
            this.monthWithoutFormat = moment(this.currentMonth, "MMMM YYYY")
                .add(1, "month")
                .format("YYYY-MM");

            this.getPostSalesByMonth(this.monthWithoutFormat);
            this.currentMonth = moment(this.monthWithoutFormat).format(
                "MMMM YYYY"
            );
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        getPostSale() {
            axios
                .get("/api/post-sales")
                .then((result) => {
                    this.postSales = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        downloadExcel() {
            window
                .open(
                    "/inbestiga/public/api/export-post-sales/" +
                        this.monthWithoutFormat
                )
                .focus();
        },
    },
    mounted() {
        this.getPostSale();
    },
};
</script>
