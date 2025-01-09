<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-2 p-2">
                <div class="user-profile-header-banner">
                    <img
                        src="https://inbestiga.com/ficha_proyecto.jpg"
                        alt="Banner image"
                        class="rounded w-100"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 px-0">
                <GeneralInformation :quotation="quotation" />
                <Customers
                    :quotation="quotation"
                    @updateCustomer="updateCustomer"
                />
                <Adendums
                    @openAdendumsModal="openAdendumsModal"
                    @getQuotation="getQuotation"
                    :addendums="addendums"
                />
                <AcademicInfo
                    :academicType="typeQuiz"
                    :newQuestions="questions"
                    :propertiableId="contract.id"
                    :documentaryTags="documentaryTags"
                    :forms="forms"
                />
                <FilesRequired
                    :filesProject="filesProject"
                    :filesRequired="filesRequired"
                    :project="project"
                    @getQuotation="getQuotation"
                />
            </div>
            <div class="col-6 px-0 ps-2">
                <FormPost
                    :projectId="project.id"
                    @getQuotation="getQuotation"
                />
                <div
                    class="card bg-warning my-2 text-white"
                    v-for="delivery in deliveries"
                >
                    <div class="card-header">
                        <p>Entrega</p>
                        {{ formatDate(delivery.date) }}
                    </div>
                    <div class="card-body">
                        {{ delivery.advance }}
                    </div>
                </div>
                <div
                    class="card bg-primary my-2 text-white"
                    v-for="payment in payments"
                >
                    <div class="card-header">
                        <p>Pago</p>
                        {{ formatDate(payment.date) }}
                    </div>
                    <div class="card-body">S./ {{ payment.amount }}</div>
                </div>
                <div
                    class="card bg-secondary my-2 text-white"
                    v-for="voucher in externalVouchers"
                >
                    <div class="card-header">
                        Voucher Externo {{ formatDate(voucher.created_at) }}
                    </div>
                    <div class="card-body">
                        <button
                            class="btn btn-icon btn-success"
                            @click="showVoucherImage(voucher)"
                        >
                            <i class="bx bx-file text-white"></i>
                        </button>
                    </div>
                </div>
                <Post
                    :post="post"
                    v-for="post in posts"
                    @getQuotation="getQuotation"
                />
            </div>
        </div>
    </div>
    <ComunicationsModal :comunications="customer.comunications" />
    <customerModal :action="action" :customer="customerSelected" />
    <AdendumsModal
        :contract="contract"
        :payments="payments"
        @getQuotation="getQuotation"
        :project_id="project.id"
    />
</template>
<script>
import moment from "moment";
import axios from "axios";
import GeneralInformation from "./GeneralInformation.vue";
import Customers from "./Customers.vue";
import FormPost from "./FormPost.vue";
import FrontPage from "./FrontPage.vue";
import FilesRequired from "./FilesRequired.vue";
import CardMeetings from "./CardMeetings.vue";
import Attrib from "./Attrib.vue";
import ComunicationsModal from "./ComunicationsModal.vue";
import customerModal from "../../sales/customers/customerModal.vue";
import Documentary from "./Documentary.vue";
import File from "./File.vue";
import AcademicInfo from "./AcademicInfo.vue";
import Post from "./Post.vue";
import Adendums from "./Adendums.vue";
import AdendumsModal from "./AdendumsModal.vue";
import { userStore } from "../../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    components: {
        Attrib,
        ComunicationsModal,
        customerModal,
        Documentary,
        File,
        AcademicInfo,
        Post,
        FrontPage,
        FilesRequired,
        CardMeetings,
        GeneralInformation,
        Customers,
        FormPost,
        Adendums,
        AdendumsModal,
    },
    data() {
        return {
            quotation: {},
            contract: {},
            project: {},
            customer: {},
            selectedDoc: {
                propertiable_id: 0,
                propertiable_type: "",
            },
            newFields: [],
            doc: {},
            questions: [],
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
            formSelected: 0,
            typeQuiz: 0,
            forms: [],
            documentaryTags: [],
            project: {
                id: 0,
            },
            filesProject: [],
            postFiles: [],
            filesRequired: [
                {
                    label: "Reglamento / lineamientos de investigación",
                    status: 1,
                    complete: false,
                },
                {
                    label: "Estructura de plan de tesis/ informe final",
                    status: 2,
                    complete: false,
                },
                {
                    label: "Plantilla de tesis o ejemplo de tesis",
                    status: 3,
                    complete: false,
                },
                {
                    label: "Manual de redacción de su universidad (APA, ISO, Vancouver)",
                    status: 4,
                    complete: false,
                },
            ],
            posts: [],
            documentaryTags: [
                { question: "Tema", answer: false, type: 2 },
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
            ],
            deliveries: [],
            payments: [],
            externalVouchers: [],
            addendums: [],
        };
    },
    methods: {
        openAdendumsModal() {
            $("#adendumsModal").modal("show");
        },
        showVoucherImage(voucher) {
            var imageUrl = voucher.images[0].url;

            window.open(
                "https://inbestiga.com/inbestiga/public/files/" + imageUrl
            );
        },
        updateCustomer(customer) {
            console.log(customer);
            this.customerSelected = customer;
            this.action = 2;
            $("#customerModal").modal("show");
        },

        selectForm() {
            console.log(this.formSelected);
        },
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
            this.filesProject = [];
            this.$swal.fire({
                title: "Cargando...",
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            axios
                .get("/api/quotations/" + this.$route.params.quotationId)
                .then((result) => {
                    this.quotation = result.data;
                    this.contract = this.quotation.contract;
                    this.addendums = this.contract.addendums;
                    this.project = this.quotation.contract.projects[0];
                    this.deliveries =
                        this.quotation.contract.projects[0].deliveries;
                    this.payments = this.quotation.contract.payments;
                    this.posts = this.project.posts;
                    this.externalVouchers =
                        this.quotation.contract.external_vouchers;

                    this.project.files.forEach((file) => {
                        if (file.type == 1) {
                            this.filesProject.push(file);
                            var fileRequiredFound = this.filesRequired.find(
                                (fileRequired) =>
                                    fileRequired.status == file.status
                            );
                            fileRequiredFound.complete = true;
                            file.label = fileRequiredFound.label;
                        } else if (file.type == 2) {
                            this.postFiles.push(file);
                        }
                    });

                    this.filesProject.forEach((file) => {
                        if (file.type == 1) {
                            var fileRequiredFound = this.filesRequired.find(
                                (fileRequired) =>
                                    fileRequired.status == file.status
                            );
                            fileRequiredFound.complete = true;
                            file.label = fileRequiredFound.label;
                        } else if (file.type == 2) {
                            var indexFile = this.filesProject.findIndex(
                                (fileProject) => fileProject.id == file.id
                            );
                            this.filesProject.splice(indexFile, 1);
                        }
                    });

                    if (this.contract.properties[0]) {
                        if (
                            this.contract.properties[0].documentary_processing
                        ) {
                            this.documentaryTags = JSON.parse(
                                this.contract.properties[0]
                                    .documentary_processing
                            );
                        }

                        this.typeQuiz =
                            this.contract.properties[0].project_situation_id;

                        this.questions = JSON.parse(
                            this.contract.properties[0].properties
                        );
                    }

                    this.$swal.close();
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        saveFields() {
            const fd = new FormData();

            fd.append("propertiable_id", this.selectedDoc.propertiable_id);
            fd.append("propertiable_type", this.selectedDoc.propertiable_type);
            fd.append("properties", JSON.stringify(this.questions));
            fd.append(
                "documentary_processing",
                JSON.stringify(this.documentaryTags)
            );
            fd.append("project_situation_id", this.typeQuiz);

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
        getForms() {
            axios
                .get("/api/forms")
                .then((result) => {
                    this.forms = result.data.forms;
                })
                .catch((err) => {
                    console.log(err);
                });
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
    },
    mounted() {
        this.getQuotation();
        this.getForms();
    },
};
</script>
<style scoped>
.form-check {
    display: flex;
}

.form-check input {
    order: 2;
}
</style>
