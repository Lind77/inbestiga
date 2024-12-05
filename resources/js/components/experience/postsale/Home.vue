<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Post venta</h4>
        <div class="card pt-2">
            <div class="w-full p-2">
                <button class="btn btn-success">Descargar</button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>PostVenta</th>
                            <th>Cuestionario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="postsale in postSales">
                            <td>
                                <p class="fw-bold mb-0">
                                    {{ postsale.name }} - {{ postsale.id }}
                                </p>
                                <small>Email: {{ postsale.email }}</small>
                                <br />
                                <small>DNI: {{ postsale.dni }} </small>
                                <br />
                                <small>Celular: {{ postsale.cell }}</small>
                                <br />
                                <small
                                    >Sexo:
                                    {{
                                        postsale.gender
                                            ? postsale.gender == 1
                                                ? "M"
                                                : "F"
                                            : "Sin asignar"
                                    }}</small
                                >
                                <br />
                                <small
                                    >Fecha de nacimiento:
                                    {{
                                        postsale.birth_date
                                            ? postsale.birth_date
                                            : "Sin asignar"
                                    }}</small
                                >
                            </td>
                            <td>
                                <small
                                    >Fecha de registro:
                                    {{
                                        postsale.quotations
                                            ? formatDate(
                                                  postsale.quotations[0]
                                                      .created_at
                                              )
                                            : "Sin cotización"
                                    }}</small
                                >
                                <br />
                                <small>Código de Contrato: </small>
                                <br />
                                <small
                                    >Ciudad de Residencia:
                                    {{
                                        postsale.province
                                            ? postsale.province.name
                                            : "Sin asignar"
                                    }}</small
                                >
                                <br />
                                <small
                                    >Universidad:
                                    {{ postsale.university }}</small
                                >
                                <br />
                                <small
                                    >Carrera:
                                    {{ postsale.career }}
                                </small>
                                <br />
                                <small>
                                    Tipo de Tesis:
                                    {{
                                        postsale.quotations
                                            ? postsale.quotations[0].contract
                                                ? postsale.quotations[0]
                                                      .contract.thesis_type_id
                                                    ? postsale.quotations[0]
                                                          .contract
                                                          .thesis_type_id
                                                    : "Sin asignar"
                                                : "Sin contrato"
                                            : "Sin cotización"
                                    }}</small
                                >
                                <br />
                                <small>
                                    Grado:
                                    {{
                                        postsale.quotations
                                            ? postsale.quotations[0].contract
                                                ? postsale.quotations[0]
                                                      .contract.thesis_degree_id
                                                    ? postsale.quotations[0]
                                                          .contract
                                                          .thesis_degree_id
                                                    : "Sin asignar"
                                                : "Sin contrato"
                                            : "Sin cotización"
                                    }}</small
                                >
                                <br />
                                <small>
                                    Monto contratado:
                                    {{
                                        postsale.quotations
                                            ? `S./ ${postsale.quotations[0].amount}`
                                            : "Sin cotización"
                                    }}
                                </small>
                            </td>
                            <td>
                                <small>Canal de comunicación preferido:</small>
                                <br />
                                <small>Lugar de estudio:</small>
                                <br />
                                <small
                                    >¿Cómo te enteraste de nuestros
                                    servicios?</small
                                >
                                <br />
                                <small>Factor principal de contrato</small>
                                <br />
                                <small>¿Cómo realizaste la contratación?</small>
                                <br />
                                <small
                                    >¿Cuál es tu situación académica
                                    actual?</small
                                >
                                <br />
                                <small>Estado profesional</small>
                                <br />
                                <small
                                    >¿Qué tanto deseas participar en la
                                    tesis?</small
                                >
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
                    this.postSales = result.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getPostSale();
    },
};
</script>
