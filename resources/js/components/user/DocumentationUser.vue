<template>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <Documentation />
        </div>
    </div>

    <!-- <ComunicationsModal :comunications="customer.comunications" />
    <customerModal :action="action" :customer="customerSelected" /> -->
</template>
<script>
import moment from "moment";
import axios from "axios";
import Documentation from "../experience/profiles/Documentation.vue";
import { userStore } from "../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    components: { Documentation },
    data() {
        return {
            quotation: {},
            customer: {},
            selectedDoc: {
                propertiable_id: 0,
                propertiable_type: "",
            },
            newFields: [],
            doc: {},
            newQuestions: [
                {
                    question: "Tema",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Plan de Tesis",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Observaciones del Plan de Tesis",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Aprobación del Plan de Tesis",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Aplicación de instrumentos",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Elaboración de Informe Final",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Observaciones del informe final",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Revisión de jurados",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Sustentación Final",
                    answer: false,
                    type: 2,
                },
                {
                    question: "¿Sobre que desea investigar?",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Lugar de investigación",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Propuesta de población",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Levantamiento de observaciones:",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Si cuenta con un avance, ¿Cúal es?",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Otros",
                    answer: "",
                    type: 3,
                },
                {
                    question: "Reglamento / lineamientos de investigación",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question: "Estructura del plan de tesis",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question: "Estructura del informe final",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question: "Plantilla",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question:
                        "Manual de estilo de redacción (APA, ISO, Vancouver) (opcional)",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question: "Línea de investigación",
                    answer: false,
                    type: 4,
                    subtype: "a",
                },
                {
                    question: "Diapositivas",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Plantilla de diapositivas",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Balotario de preguntas",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Guía de sustentación",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Reporte de turnitin",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Otro",
                    answer: false,
                    type: 4,
                    subtype: "b",
                },
                {
                    question: "Reunión de bienvenida",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Reunión de apertura académica",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Reunión de explicación de plan de tesis",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Reunión explciativa de informe final",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Asesoría para sustentación",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Otra reunión",
                    answer: false,
                    type: 4,
                    subtype: "c",
                },
                {
                    question: "Link de Drive",
                    answer: "",
                    type: 5,
                },
                {
                    question: "Rama de investigación",
                    answer: 0,
                    type: 6,
                    options: [
                        "Ingeniería",
                        "Ciencias médicas",
                        "Derecho",
                        "Ciencias contables",
                        "Ciencias sociales",
                    ],
                },
                {
                    question: "Modalidad de titulación",
                    answer: 0,
                    type: 6,
                    options: [
                        "Curso de universidad",
                        "Curso de Maestría",
                        "Curso de titulación",
                        "Regular(Sustentación)",
                        "Por Publicación(Artículo)",
                    ],
                },
                {
                    question: "VIP",
                    answer: 0,
                    type: 6,
                    options: ["Maestría", "Doctorado", "Referido", "Ninguno"],
                },
            ],
            comunications: [],
            comunicationOptions: {
                1: "Llamar",
                2: "Escribir",
                3: "Meet",
            },
            properties: [],
            docType: 1,
            newUpdate: {
                question: "",
                answer: "",
                type: 0,
            },
            customerSelected: {},
            action: 0,
        };
    },
    methods: {
        deleteCustomerContract(customerId, quotationId) {
            if (
                confirm(
                    "Tienes la seguridad de eliminar este usuario? Recuerda que modificará el contrato y cotización"
                )
            ) {
                axios
                    .get(`/api/customer-contract/${customerId}/${quotationId}`)
                    .then((result) => {
                        console.log(result.data);
                        this.getQuotation();
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        updateCustomer(customer) {
            this.customerSelected = customer;
            this.action = 2;
            $("#customerModal").modal("show");
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        deleteNewQuestion(index) {
            console.log(index);
            this.newQuestions.splice(index, 1);
        },
        openComunicationsModal() {
            $("#ComunicationsModal").modal("show");
        },
        addNewQuestion() {
            console.log("new question");
            var newQuestion = {
                question: "",
                answer: "",
                type: 0,
            };

            this.newQuestions.push({ ...newQuestion });
        },
        getQuotation() {
            this.$swal.fire({
                title: "Cargando...",
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            axios
                .get("/api/quotations/" + this.$route.params.quotationId)
                .then((result) => {
                    this.quotation = result.data;

                    console.log(this.store.authUser);

                    this.customer = this.quotation.customers[0];
                    this.comunications = this.customer.comunications;
                    if (
                        this.quotation.contract &&
                        this.quotation.contract.properties[0]
                    ) {
                        this.newQuestions = JSON.parse(
                            this.quotation.contract.properties[0].properties
                        );
                        this.docType = 2;
                        var findDriveField = this.newQuestions.find(
                            (question) => question.type == 5
                        );
                        var findBranchInvestigation = this.newQuestions.find(
                            (question) => question.type == 6
                        );

                        if (!findDriveField) {
                            this.newQuestions.push({
                                question: "Link de Drive",
                                answer: "",
                                type: 5,
                            });
                        }

                        if (!findBranchInvestigation) {
                            this.newQuestions.push({
                                question: "Rama de investigación",
                                answer: 0,
                                type: 6,
                            });
                        }
                    } else if (this.quotation.order) {
                        if (this.quotation.order.properties[0]) {
                            this.newQuestions = JSON.parse(
                                this.quotation.order.properties[0].properties
                            );
                        }
                    }
                    this.$swal.close();
                    console.log(this.properties);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        updateFields() {
            const fd = new FormData();
            this.newQuestions.push({ ...this.newUpdate });
            fd.append("propertiable_id", this.selectedDoc.propertiable_id);
            fd.append("propertiable_type", this.selectedDoc.propertiable_type);
            fd.append("properties", JSON.stringify(this.newQuestions));
            fd.append("_method", "put");

            axios
                .post("/api/properties", fd)
                .then((result) => {
                    this.newUpdate = {
                        question: "",
                        answer: "",
                        type: 0,
                    };
                    this.$swal(
                        "Documentación de proyecto actualizada correctamente"
                    );
                })
                .catch((err) => {
                    this.$swal("Hubo un error");
                });
        },
        saveFields() {
            const fd = new FormData();

            fd.append("propertiable_id", this.selectedDoc.propertiable_id);
            fd.append("propertiable_type", this.selectedDoc.propertiable_type);
            fd.append("properties", JSON.stringify(this.newQuestions));

            axios
                .post("/api/properties", fd)
                .then((result) => {
                    this.$swal(
                        "Documentación de proyecto almacenada correctamente"
                    );
                })
                .catch((err) => {
                    this.$swal("Hubo un error");
                });
        },
        addNewField() {
            var newField = {
                name: "",
                val: "",
            };
            this.newFields.push({ ...newField });
        },
        getDocumentation() {
            var quotationFounded = this.store.authUser.quotations.find(
                (quotation) => quotation.id == this.$route.params.quotationId
            );

            console.log(quotationFounded === undefined);

            if (quotationFounded === undefined) {
                this.$swal({
                    title: "Esta cotización no te pertenece ...",
                });
                this.$router.back();
            } else {
                return "Documentation";
            }
        },
    },
    computed: {
        signedDoc() {
            if (this.quotation) {
                if (this.quotation.contract != null) {
                    this.selectedDoc.propertiable_id =
                        this.quotation.contract.id;
                    this.selectedDoc.propertiable_type =
                        "App\\Models\\Contract";
                    this.doc = this.quotation.contract;
                    return "Contrato";
                } else if (this.quotation.order != null) {
                    this.selectedDoc.propertiable_id = this.quotation.order.id;
                    this.selectedDoc.propertiable_type = "App\\Models\\Order";
                    this.doc = this.quotation.order;
                    return "Orden";
                }
            }
        },
        /* slugify(string) {
            console.log(typeof string)
            return     // Replace spaces with hyphen (-)
        } */
    },
    mounted() {
        this.getDocumentation();
    },
};
</script>
<style lang=""></style>
