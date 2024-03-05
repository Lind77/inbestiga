<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card w-100">
            <div class="card-body d-flex">
                <img src="https://inbestiga.com/wp-content/uploads/2023/10/cropped-logo-Inbestiga.png" class=" rounded"
                    width="100" height="100">
                <div class="ps-3 w-100">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{ project.title }}</h3>
                            <template v-if="project.projectable">
                                <p class="text-dark fw-bold"
                                    v-for="customer in project.projectable.quotation.customers">{{
                                customer.name }}</p>
                            </template>
                        </div>
                        <button class="btn btn-success h-25 btn-small">{{ project.status }}</button>
                    </div>

                    <button class="btn btn-success me-2">
                        <p class="mb-0">Fecha de inicio</p>
                        {{ project.created_at }}
                    </button>
                    <button class="btn btn-danger me-2">
                        <p class="mb-0">Fecha de entrega</p>
                        {{ project.deadline }}
                    </button>
                    <button class="btn btn-info me-2" v-if="project.projectable">
                        <p class="mb-0">Presupuesto</p>
                        S./ {{ project.projectable.amount }}
                    </button>
                    <button class="btn btn-warning" v-if="project.team">
                        <p class="mb-0">Equipo</p>
                        {{ project.team.name }}
                    </button>
                </div>
            </div>
        </div>
        <div class="card w-100">
            <div class="card-body d-flex justify-content-between">
                <div>

                </div>
                <div>
                    <button class="btn btn-danger mx-1" @click="showModalFiles"><i
                            class='bx bx-file'></i>Archivos</button>
                    <button class="btn btn-danger mx-1"><i class='bx bx-file'></i>Videos</button>
                    <button class="btn btn-danger mx-1"><i class='bx bx-link-alt'></i>Links</button>
                </div>

            </div>
        </div>
        <div class="nav-align-top mb-4 pt-2 ">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                        aria-selected="true">Tabla</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-sprints" aria-controls="navs-pills-top-sprints"
                        aria-selected="false" tabindex="-1">Sprints</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                        aria-selected="false" tabindex="-1">Kanban</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-calendar" aria-controls="navs-pills-top-calendar"
                        aria-selected="false" tabindex="-1">Calendario</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
                    <p>Tabla</p>
                </div>
                <div class="tab-pane fade" id="navs-pills-top-sprints" role="tabpanel">
                    <Sprint :deliveries="deliveries" :productsFiltered="productsFiltered" @getProject="getProject"
                        @filterAcademicProducts="filterAcademicProducts" />
                </div>
                <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                    <Kanban :deliveries="deliveries" />
                </div>
                <div class="tab-pane fade" id="navs-pills-top-calendar" role="tabpanel">
                    <p>Calendario</p>
                </div>
            </div>
        </div>


    </div>
    <TeamModal :contract="contractId" />
    <ModalFiles :files="files" @updateFilesModal="updateFilesModal" />
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Sprint from './Sprint.vue'
import Kanban from './kanban/Kanban.vue'
import TeamModal from './TeamModal.vue';
import ModalFiles from './ModalFiles.vue';

export default {
    components: { Sprint, Kanban, TeamModal, ModalFiles },
    data() {
        return {
            project: {},
            deliveries: [],
            products: [],
            productsFiltered: [],
            productSelected: {},
            deliverySelected: {},
            totalActivitiesAssigned: [],
            search: '',
            contractId: 0,
            files: []
        }
    },
    methods: {
        updateFilesModal() {
            this.getProject()
        },
        showModalFiles() {
            $('#filesModal').modal('show')
        },
        showTeamModal() {
            $('#teamModal').modal('show')
        },
        filterAcademicProducts(search) {
            this.productsFiltered = this.products.filter(product => product.name.toLowerCase().includes(search))
        },
        getProject() {
            this.deliveries = []
            axios.get('/api/projects-sprints/' + this.$route.params.idProject)
                .then((result) => {
                    this.project = result.data
                    this.deliveries = result.data.deliveries
                    this.files = result.data.files
                    this.deliveries.forEach((delivery) => {
                        delivery.assigned_activities.forEach((assignment) => {
                            this.totalActivitiesAssigned.push({ ...assignment })
                        })
                    })

                }).catch((err) => {
                    console.error(err);
                });
        },
        getProducts() {
            axios.get('/api/academic-products')
                .then((result) => {
                    this.products = result.data
                    this.productsFiltered = result.data
                }).catch((err) => {
                    console.error(err);
                });
        },
        formatDate(date) {
            return moment(date).format('DD/MM')
        },
        enableProject() {
            axios.get('/api/enable-project/' + this.$route.params.idProject)
                .then((result) => {
                    this.$swal('Proyecto habilitado correctamente')
                }).catch((err) => {
                    this.$swal('Hubo un error')
                });
        }
    },
    mounted() {
        this.getProject()
        this.getProducts()
    }
}
</script>

<style scoped>
.verticaltext {
    transform: rotate(90deg);
    transform-origin: left top 0;
}
</style>