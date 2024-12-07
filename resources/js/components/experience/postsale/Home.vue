<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Post venta</h4>
        <div class="card pt-2">
            <div class="w-full p-2">
                <button class="btn btn-success" @click="downloadExcel">
                    Descargar
                </button>
            </div>
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
                                                      .comunication_channel.name
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
                                                      .study_place.name
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
                                                      .marketing_source.name
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
                                                      .hire_factor.name
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
                                                      .contract_mode.name
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
                                                      .academic_situation.name
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
                                                      .professional_status.name
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
                                                      .participation.name
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

export default {
    data() {
        return {
            postSales: [],
        };
    },
    methods: {
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
            window.open("/inbestiga/public/api/export-post-sales").focus();
        },
    },
    mounted() {
        this.getPostSale();
    },
};
</script>
