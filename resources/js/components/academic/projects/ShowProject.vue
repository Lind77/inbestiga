<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card w-100">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-2">
                        <img
                            src="https://inbestiga.com/inbestiga/public/files/1709671609.png"
                            class="w-100 rounded"
                        />
                    </div>
                    <div class="col-9">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h3 class="fw-bold mb-0">
                                        {{ project.title }}
                                    </h3>
                                    <span class="badge bg-success ms-3">{{
                                        formatStatus(project.status)
                                    }}</span>
                                    <span
                                        class="badge bg-warning ms-3"
                                        v-if="project && project.team"
                                        >{{ project.team.name }}</span
                                    >
                                </div>
                                <template v-if="project.projectable">
                                    <div
                                        class="d-flex align-items-center avatar-group my-2"
                                    >
                                        <div
                                            class="avatar avatar-sm me-2"
                                            v-for="customer in project
                                                .projectable.quotation
                                                .customers"
                                            :title="customer.name"
                                        >
                                            <span
                                                class="avatar-initial rounded-circle bg-primary"
                                                >{{ customer.name[0] }}</span
                                            >
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div
                                    class="card shadow-none bg-transparent border border-success mb-3"
                                >
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 fw-semibold">
                                            {{ formatDate(project.created_at) }}
                                        </h6>
                                        <p class="card-text">Fecha de Inicio</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div
                                    class="card shadow-none bg-transparent border border-danger mb-3"
                                >
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 fw-semibold">
                                            {{
                                                project.deadline
                                                    ? formatDate(
                                                          project.deadline
                                                      )
                                                    : "-"
                                            }}
                                        </h6>
                                        <p class="card-text">
                                            Fecha de Entrega
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div
                                    class="card shadow-none bg-transparent border border-info mb-3"
                                >
                                    <div class="card-body p-2">
                                        <h6
                                            class="card-title mb-1 fw-semibold"
                                            v-if="project.projectable"
                                        >
                                            S/. {{ project.projectable.amount }}
                                        </h6>
                                        <p class="card-text">Presupuesto</p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-3">
                                <div class="card shadow-none bg-transparent border border-warning mb-3">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 fw-semibold">
                                            {{ project.team.name }}
                                        </h6>
                                        <p class="card-text">
                                            Equipo
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="d-flex justify-content-between">
                        <ul class="nav nav-pills mb-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    type="button"
                                    class="nav-link active"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-sprints"
                                    aria-controls="navs-pills-top-sprints"
                                    aria-selected="true"
                                    tabindex="-1"
                                >
                                    Sprints
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-home"
                                    aria-controls="navs-pills-top-home"
                                    aria-selected="false"
                                >
                                    Tabla
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-profile"
                                    aria-controls="navs-pills-top-profile"
                                    aria-selected="false"
                                    tabindex="-1"
                                >
                                    Kanban
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-calendar"
                                    aria-controls="navs-pills-top-calendar"
                                    aria-selected="false"
                                    tabindex="-1"
                                >
                                    Calendario
                                </button>
                            </li>
                        </ul>
                        <div>
                            <button
                                class="btn btn-danger mx-1"
                                @click="showModalFiles"
                            >
                                <i class="bx bx-file"></i>Archivos
                            </button>
                            <button class="btn btn-danger mx-1">
                                <i class="bx bx-file"></i>Videos
                            </button>
                            <button class="btn btn-danger mx-1">
                                <i class="bx bx-link-alt"></i>Links
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-align-top mb-4 pt-2">
            <div class="card tab-content">
                <div
                    class="tab-pane fade active show"
                    id="navs-pills-top-sprints"
                    role="tabpanel"
                >
                    <Sprint
                        :deliveries="deliveries"
                        :productsFiltered="productsFiltered"
                        @getProject="getProject"
                        @filterAcademicProducts="filterAcademicProducts"
                        @openModalTask="openModalTask"
                        :team="project.team"
                        :processes="processes"
                    />
                </div>
                <div
                    class="tab-pane fade"
                    id="navs-pills-top-home"
                    role="tabpanel"
                >
                    <p>Tabla</p>
                </div>

                <div
                    class="tab-pane fade"
                    id="navs-pills-top-profile"
                    role="tabpanel"
                >
                    <Kanban
                        :deliveries="deliveries"
                        @getProject="getProject"
                        v-if="deliveries"
                    />
                </div>
                <div
                    class="tab-pane fade"
                    id="navs-pills-top-calendar"
                    role="tabpanel"
                >
                    <p>Calendario</p>
                </div>
            </div>
        </div>
    </div>
    <TeamModal :contract="contractId" />
    <ModalFiles :files="files" @updateFilesModal="updateFilesModal" />
    <NewTaskModal @getProject="getProject" :deliveryId="deliveryId" />
</template>

<script>
import axios from "axios";
import moment from "moment";
import Sprint from "./Sprint.vue";
import Kanban from "./kanban/Kanban.vue";
import TeamModal from "./TeamModal.vue";
import ModalFiles from "./ModalFiles.vue";
import NewTaskModal from "./NewTaskModal.vue";

export default {
    components: { Sprint, Kanban, TeamModal, ModalFiles, NewTaskModal },
    data() {
        return {
            project: {},
            deliveries: [],
            products: [],
            productsFiltered: [],
            productSelected: {},
            deliverySelected: {},
            totalActivitiesAssigned: [],
            search: "",
            contractId: 0,
            files: [],
            statusByNumber: {
                0: "Activo",
                1: "Completo",
            },
            deliveryId: 0,
            processes: [],
        };
    },
    methods: {
        openModalTask(deliveryId) {
            this.deliveryId = deliveryId;
            $("#newTaskModal").modal("show");
        },
        formatStatus(status) {
            return this.statusByNumber[status];
        },
        updateFilesModal() {
            this.getProject();
        },
        showModalFiles() {
            $("#filesModal").modal("show");
        },
        showTeamModal() {
            $("#teamModal").modal("show");
        },
        filterAcademicProducts(search) {
            this.productsFiltered = this.products.filter((product) =>
                product.name.toLowerCase().includes(search)
            );
        },
        getProject() {
            this.deliveries = [];
            console.log(this.deliveries.length);
            axios
                .get("/api/projects-sprints/" + this.$route.params.idProject)
                .then((result) => {
                    this.project = result.data;
                    this.deliveries = result.data.deliveries;
                    this.files = result.data.files;
                    this.deliveries.forEach((delivery) => {
                        delivery.assigned_activities.forEach((assignment) => {
                            this.totalActivitiesAssigned.push({
                                ...assignment,
                            });
                        });
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        getProducts() {
            axios
                .get("/api/academic-products")
                .then((result) => {
                    this.products = result.data.academicProducts;
                    this.productsFiltered = result.data.academicProducts;
                    this.processes = result.data.academicProcesses;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        enableProject() {
            axios
                .get("/api/enable-project/" + this.$route.params.idProject)
                .then((result) => {
                    this.$swal("Proyecto habilitado correctamente");
                })
                .catch((err) => {
                    this.$swal("Hubo un error");
                });
        },
    },
    mounted() {
        this.getProject();
        this.getProducts();
    },
};
</script>

<style scoped>
.verticaltext {
    transform: rotate(90deg);
    transform-origin: left top 0;
}
</style>
