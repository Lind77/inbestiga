<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <div class="card mb-2 px-0">
                <div class="user-profile-header-banner">
                    <img
                        src="https://inbestiga.com/ficha_proyecto.jpg"
                        alt="Banner image"
                        class="rounded-top w-100"
                    />
                </div>
                <div
                    class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4"
                >
                    <div class="px-4 pt-4 w-100">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <span class="h5 mt-2 demo text-body fw-bold"
                                    >Información General
                                </span>
                                <div
                                    class="card bg-warning p-3 text-white mt-2"
                                >
                                    <p class="mb-2">
                                        <span class="fw-bold"
                                            >Documento Firmado:</span
                                        >
                                        {{ signedDoc }}
                                    </p>

                                    <p class="mb-2">
                                        <span class="fw-bold"
                                            >Servicio Contratado
                                        </span>
                                    </p>
                                    <p v-for="detail in quotation.details">
                                        - {{ detail.name }}
                                    </p>
                                </div>
                                <div class="mt-3" v-if="quotation.contract">
                                    <button
                                        :class="`btn btn-md btn-${
                                            quotation.contract
                                                .third_article_place == 0
                                                ? 'success'
                                                : 'secondary'
                                        } btn-icon`"
                                        title="Lugar o contexto de estudio"
                                    >
                                        <i class="bx bx-landscape"></i>
                                    </button>
                                    <button
                                        :class="`btn btn-md btn-${
                                            quotation.contract.third_article ==
                                            0
                                                ? 'info'
                                                : 'secondary'
                                        } btn-icon ms-1`"
                                        title="Aplicación de instrumentos"
                                    >
                                        <i class="bx bxs-vial"></i>
                                    </button>
                                    <button
                                        :class="`btn btn-md btn-${
                                            quotation.contract.third_article ==
                                            0
                                                ? 'warning'
                                                : 'secondary'
                                        } btn-icon ms-1`"
                                        title="Diapositivas"
                                    >
                                        <i class="bx bxs-collection"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <span class="h5 mt-2 demo text-body fw-bold"
                                    >Clientes
                                </span>

                                <div
                                    class="card bg-primary p-2 mb-2 mt-2"
                                    v-if="customerSelected"
                                >
                                    <div
                                        class="card-header d-flex align-items-center justify-content-between"
                                    >
                                        <h5
                                            class="card-title m-0 me-2 text-white"
                                            :title="customerSelected.name"
                                        >
                                            {{
                                                customerSelected.name
                                                    ? customerSelected.name.substring(
                                                          0,
                                                          13
                                                      )
                                                    : ""
                                            }}
                                        </h5>
                                        <div class="dropdown">
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                id="employeeList"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <i
                                                    class="bx bx-dots-vertical-rounded text-white"
                                                ></i>
                                            </button>
                                            <div
                                                class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="employeeList"
                                                style=""
                                            >
                                                <a
                                                    class="dropdown-item"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        updateCustomer(customer)
                                                    "
                                                    >Editar</a
                                                >
                                                <!--   <a
                                                    v-if="
                                                        quotation.customers
                                                            .length >= 2
                                                    "
                                                    class="dropdown-item"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        deleteCustomerContract(
                                                            customer.id,
                                                            quotation.id
                                                        )
                                                    "
                                                    >Eliminar</a
                                                > -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2 text-white"
                                        >
                                            <li
                                                class="list-inline-item fw-medium"
                                            >
                                                <i class="bx bx-id-card"></i>
                                                {{ customerSelected.dni }}
                                            </li>
                                            <li
                                                class="list-inline-item fw-medium"
                                            >
                                                <i class="bx bx-pen"></i>
                                                {{ customerSelected.career }}
                                            </li>
                                            <li
                                                class="list-inline-item fw-medium"
                                            >
                                                <i
                                                    class="bx bxs-graduation"
                                                ></i>
                                                {{
                                                    customerSelected.university
                                                }}
                                            </li>
                                            <li
                                                class="list-inline-item fw-medium"
                                            >
                                                <i class="bx bx-phone"></i>
                                                {{ customerSelected.cell }}
                                            </li>
                                            <li
                                                class="list-inline-item fw-medium"
                                            >
                                                <i
                                                    class="bx bx-street-view"
                                                ></i>
                                                Actitud:
                                                {{
                                                    customerSelected.attitude
                                                        ? customerSelected.attitude
                                                        : "-"
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center avatar-group my-3"
                                >
                                    <div
                                        class="avatar avatar-sm me-2"
                                        v-for="customer in quotation.customers"
                                        :title="customer.name"
                                    >
                                        <span
                                            @click="selectCustomer(customer)"
                                            class="avatar-initial rounded-circle bg-primary"
                                            >{{ customer.name[0] }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card invoice-preview-card mt-2">
                <div class="card-body">
                    <div class="row">
                        <span class="h5 mt-2 demo text-body fw-bold"
                            >Estado del trámite universitario</span
                        >
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <template
                                            v-for="newQuestion in questions"
                                        >
                                            <td v-if="newQuestion.type == 2">
                                                {{ newQuestion.question }}
                                            </td>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <template
                                            v-for="newQuestion in questions"
                                        >
                                            <td v-if="newQuestion.type == 2">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="newQuestion.answer"
                                                />
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div
                            class="d-flex align-items-center justify-content-between mb-2"
                        >
                            <div>
                                <span class="h5 m-2 demo text-body fw-bold"
                                    >Información Académica
                                </span>
                                <span> </span>
                            </div>
                            <div>
                                <span
                                    v-if="customer.user"
                                    class="bg-info rounded w-auto p-2 text-white fw-bold"
                                >
                                    <i class="bx bx-user-pin"></i>
                                    {{ customer.user.name }}
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md mb-md-0 mb-2">
                                <div
                                    class="form-check custom-option custom-option-icon"
                                >
                                    <label
                                        class="form-check-label custom-option-content"
                                        for="customRadioBuilder"
                                    >
                                        <span class="custom-option-body">
                                            <i class="bx bx-building-house"></i>
                                            <span class="custom-option-title"
                                                >T. con avance</span
                                            >
                                        </span>
                                        <input
                                            name="plUserType"
                                            class="form-check-input"
                                            type="radio"
                                            value="1"
                                            id="customRadioBuilder"
                                            v-model="typeQuiz"
                                        />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-md-0 mb-2">
                                <div
                                    class="form-check custom-option custom-option-icon"
                                >
                                    <label
                                        class="form-check-label custom-option-content"
                                        for="customRadioOwner"
                                    >
                                        <span class="custom-option-body">
                                            <i class="bx bx-crown"></i>
                                            <span class="custom-option-title">
                                                T. sin avance
                                            </span>
                                        </span>
                                        <input
                                            name="plUserType"
                                            class="form-check-input"
                                            type="radio"
                                            value="2"
                                            id="customRadioOwner"
                                            v-model="typeQuiz"
                                        />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-md-0 mb-2">
                                <div
                                    class="form-check custom-option custom-option-icon"
                                >
                                    <label
                                        class="form-check-label custom-option-content"
                                        for="customRadioBroker"
                                    >
                                        <span class="custom-option-body">
                                            <i class="bx bx-briefcase-alt"></i>
                                            <span class="custom-option-title">
                                                Art. Científico
                                            </span>
                                        </span>
                                        <input
                                            name="plUserType"
                                            class="form-check-input"
                                            type="radio"
                                            value="3"
                                            id="customRadioBroker"
                                            v-model="typeQuiz"
                                        />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-md-0 mb-2">
                                <div
                                    class="form-check custom-option custom-option-icon"
                                >
                                    <label
                                        class="form-check-label custom-option-content"
                                        for="customRadioBroker"
                                    >
                                        <span class="custom-option-body">
                                            <i class="bx bx-briefcase-alt"></i>
                                            <span class="custom-option-title">
                                                Otra modalidad
                                            </span>
                                        </span>
                                        <input
                                            name="plUserType"
                                            class="form-check-input"
                                            type="radio"
                                            value="4"
                                            id="customRadioBroker"
                                            v-model="typeQuiz"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <template v-for="newQuestion in questions">
                                    <template v-if="newQuestion.type == 4">
                                        <div class="d-flex mb-2">
                                            <label
                                                class="form-check-label"
                                                for="flexSwitchCheckDefault"
                                                >{{
                                                    newQuestion.question
                                                }}</label
                                            >
                                            <div
                                                class="form-check form-switch ps-5"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="flexSwitchCheckDefault"
                                                    v-model="newQuestion.answer"
                                                />
                                            </div>
                                        </div>
                                    </template>
                                    <template v-if="newQuestion.type == 3">
                                        <p class="mb-1">
                                            {{ newQuestion.question }}
                                        </p>
                                        <textarea
                                            v-model="newQuestion.answer"
                                            class="form-control mb-4"
                                        ></textarea>
                                    </template>
                                    <template v-if="newQuestion.type == 6">
                                        <div class="col-12 px-1">
                                            <p class="mb-1">
                                                {{ newQuestion.question }}
                                            </p>
                                            <select
                                                v-model="newQuestion.answer"
                                                class="form-select"
                                            >
                                                <option
                                                    :value="`${index + 1}`"
                                                    v-for="(
                                                        option, index
                                                    ) in newQuestion.options"
                                                >
                                                    {{ option }}
                                                </option>
                                            </select>
                                        </div>
                                    </template>
                                </template>
                                <button
                                    class="btn btn-success w-100 mt-2"
                                    @click="saveFields"
                                >
                                    Insertar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <label for="">Nueva Actualización</label>
                        <input
                            type="text"
                            v-model="newUpdate.question"
                            placeholder="Título..."
                            class="form-control"
                        />
                        <textarea
                            placeholder="Cuerpo..."
                            v-model="newUpdate.answer"
                            class="form-control mt-2"
                            rows="5"
                        ></textarea>
                        <div class="d-flex mt-2">
                            <button
                                class="btn btn-info w-50"
                                @click="updateFields"
                            >
                                Actualizar
                            </button>
                            <button class="btn btn-success w-50 ms-2">
                                Archivo
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

                <template
                    v-for="(newQuestion, index) in questions.slice().reverse()"
                >
                    <div class="col-12 mt-2" v-if="newQuestion.type == 0">
                        <div class="card bg-warning p-2 shadow">
                            <div class="card-body text-white">
                                <h4 class="text-white">
                                    {{ newQuestion.question }}
                                </h4>
                                <p>{{ newQuestion.answer }}</p>
                            </div>
                        </div>
                    </div>
                </template>
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
import Attrib from "./Attrib.vue";
import ComunicationsModal from "./ComunicationsModal.vue";
import customerModal from "../../sales/customers/customerModal.vue";

export default {
    components: {
        Attrib,
        ComunicationsModal,
        customerModal,
    },
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
        };
    },
    methods: {
        selectCustomer(customer) {
            this.customerSelected = customer;
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
                    console.log(this.quotation);
                    this.customerSelected = this.quotation.customers[0];
                    this.comunications = this.customer.comunications;
                    if (
                        this.quotation.contract &&
                        this.quotation.contract.properties[0]
                    ) {
                        var propertiesArr = this.quotation.contract.properties;

                        propertiesArr.sort(
                            (a, b) =>
                                Date.parse(b.created_at) -
                                Date.parse(a.created_at)
                        );

                        this.questions = JSON.parse(
                            this.quotation.contract.properties[0].properties
                        );
                        this.docType = 2;
                        var findDriveField = this.questions.find(
                            (question) => question.type == 5
                        );
                        var findBranchInvestigation = this.questions.find(
                            (question) => question.type == 6
                        );

                        if (!findDriveField) {
                            this.questions.push({
                                question: "Link de Drive",
                                answer: "",
                                type: 5,
                            });
                        }

                        if (!findBranchInvestigation) {
                            this.questions.push({
                                question: "Rama de investigación",
                                answer: 0,
                                type: 6,
                            });
                        }
                    } else if (this.quotation.order) {
                        if (this.quotation.order.properties[0]) {
                            this.questions = JSON.parse(
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
            fd.append("properties", JSON.stringify(this.questions));

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
                    this.forms = result.data;
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
    watch: {
        typeQuiz(val) {
            var formSelected = this.forms.find(
                (f) => f.project_situation_id == val
            );
            if (formSelected) {
                this.questions = JSON.parse(formSelected.forms);
            } else {
                this.$swal("Aun no hay un form para esta modalidad");
                this.questions = [];
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
