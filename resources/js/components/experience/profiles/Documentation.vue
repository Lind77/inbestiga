<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <FrontPage :quotation="quotation" />
            <Documentary
                :questions="documentaryTags"
                @setCleanDocumentary="setCleanDocumentary"
            />
            <div class="col-lg-6 col-12 mb-lg-0 mb-4 px-1 mt-2">
                <AcademicInfo
                    :academicType="typeQuiz"
                    :newQuestions="questions"
                    :propertiableId="contract.id"
                    :documentaryTags="documentaryTags"
                />
                <FilesRequired
                    :filesProject="filesProject"
                    :filesRequired="filesRequired"
                    :project="project"
                    @getQuotation="getQuotation"
                />
            </div>
            <div class="col-lg-6 px-1 mt-2">
                <CardMeetings :quotation="quotation" />
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <label for="">Nuevo Post</label>
                        <input
                            type="text"
                            v-model="newUpdate.question"
                            placeholder="Título"
                            class="form-control"
                        />
                        <textarea
                            placeholder="Cuerpo"
                            v-model="newUpdate.answer"
                            class="form-control mt-2"
                            rows="5"
                        ></textarea>
                        <div class="mt-2">
                            <button
                                id="btnFilePost"
                                class="btn btn-secondary w-100"
                                @click="chooseFile"
                            >
                                Adjuntar archivo <i class="bx bx-paperclip"></i>
                            </button>
                            <input
                                type="file"
                                ref="inputHidden"
                                hidden
                                @change="archivePost"
                            />
                            <button
                                class="btn btn-info mt-2 w-100"
                                @click="postNewUpdate"
                            >
                                Publicar
                            </button>
                        </div>
                    </div>
                </div>
                <!-- <div class="card mt-2 bg-success">
                    <div class="card-body text-white">
                        <h4 class="text-white">Cotización</h4>
                        <p>{{ formatDate(quotation.created_at) }}</p>
                    </div>
                </div> -->
                <Post
                    :post="post"
                    v-for="post in posts"
                    @getQuotation="getQuotation"
                />
                <div
                    class="card mt-2 bg-success"
                    v-for="comunication in customer.comunications"
                >
                    <div class="card-body text-white">
                        <h4 class="text-white">Comunicación con ventas</h4>
                        <p>{{ comunication.comment }}</p>
                        {{ formatDate(comunication.created_at) }}
                    </div>
                </div>
                <div class="card mt-2 bg-info text-white">
                    <div class="card-body">
                        <h4 class="text-white">Registro inicial</h4>
                        {{ formatDate(customer.created_at) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ComunicationsModal :comunications="customer.comunications" />
    <customerModal :action="action" :customer="customerSelected" />
</template>
<script>
import moment from "moment";
import axios from "axios";
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
            filePostUploaded: {},
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
        };
    },
    methods: {
        toCalendly() {
            var team = this.quotation.contract.projects[0].team;

            var coordSelected = team.users.find(
                (user) => user.roles[0].name == "CoordAcad"
            );

            console.log(coordSelected);

            window.open(coordSelected.calendly_user);
        },
        postNewUpdate() {
            const fd = new FormData();
            fd.append("title", this.newUpdate.question);
            fd.append("body", this.newUpdate.answer);
            fd.append("file", this.filePostUploaded);
            fd.append("project_id", this.project.id);
            fd.append("user_id", this.store.authUser.id);

            axios
                .post("/api/file-post", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((result) => {
                    this.$swal("Post publicado correctamente");
                    this.newUpdate.question = "";
                    this.newUpdate.answer = "";
                    this.filePostUploaded = {};
                    $("#btnFilePost").removeClass("btn-success");
                    $("#btnFilePost").addClass("btn-secondary");
                    $("#btnFilePost").html("Adjuntar archivo");
                    this.getQuotation();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        archivePost(event) {
            var file = event.target.files[0];
            this.filePostUploaded = file;

            var reader = new FileReader();
            reader.onload = function (event) {
                // El texto del archivo se mostrará por consola aquí
                $("#btnFilePost").removeClass("btn-secondary");
                $("#btnFilePost").addClass("btn-success");
                $("#btnFilePost").html(file.name);
            };
            reader.readAsText(file);
        },
        chooseFile() {
            this.$refs.inputHidden.click();
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
                    this.project = this.quotation.contract.projects[0];
                    this.posts = this.project.posts;

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
