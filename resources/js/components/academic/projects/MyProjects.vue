<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4 text-center">Mis Proyectos</h4>
        <div class="row mb-3">
            <input
                type="text"
                class="form-control w-50 me-3"
                @keyup.enter="searchProject"
                v-model="searchWord"
            />
            <select class="form-control w-25">
                <option value="1">To Do</option>
                <option value="2">Doing</option>
                <option value="3">Done</option>
                <option value="4">Verified</option>
            </select>
        </div>

        <div class="row g-4">
            <div class="col-xl-4 col-lg-6 col-md-6" v-for="project in projects">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-start">
                                <div class="me-2" v-if="project.id">
                                    <h5 class="mb-1">
                                        <p
                                            class="cursor-pointer"
                                            @click="toProject(project)"
                                        >
                                            {{ project.title }}
                                        </p>
                                    </h5>
                                    <div
                                        class="client-info"
                                        v-if="project.projectable"
                                    >
                                        <p
                                            v-for="customer in project
                                                .projectable.quotation
                                                .customers"
                                        >
                                            {{ customer.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto">
                                <div class="dropdown zindex-2">
                                    <button
                                        type="button"
                                        class="btn dropdown-toggle hide-arrow p-0"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i
                                            class="bx bx-dots-vertical-rounded"
                                        ></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="javascript:void(0);"
                                                >Ver Kanban</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="javascript:void(0);"
                                                @click="toFile(project)"
                                                >Ver Ficha</a
                                            >
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item text-danger"
                                                href="javascript:void(0);"
                                                >Abandonar proyecto</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap">
                            <div
                                class="bg-lighter p-2 rounded me-auto mb-3"
                                v-if="project.order"
                            >
                                <template
                                    v-for="details in project.order.quotation
                                        .details"
                                >
                                    <p class="mb-0">
                                        {{ details.product.title }}
                                    </p>
                                </template>
                            </div>
                            <div class="text-end mb-3">
                                <h6 class="mb-1">
                                    Deadline:
                                    <span class="text-body fw-normal">{{
                                        formatDate(project.deadline)
                                    }}</span>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div
                            class="d-flex justify-content-between align-items-center mb-1"
                        >
                            <small
                                >Tareas: {{ project.num_tasks_completed }}/{{
                                    project.num_tasks
                                }}</small
                            >
                            <small
                                >{{ percentageProject(project) }}%
                                Completado</small
                            >
                        </div>
                        <div class="progress mb-3" style="height: 8px">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                :style="{
                                    width: percentageProject(project) + '%',
                                }"
                                aria-valuenow="95"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                        <div class="d-flex justify-content-start mb-3">
                            <span class="badge bg-label-success ms-auto">{{
                                formatDays(project.deadline)
                            }}</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <!--  <div class="ms-auto">
                <a href="javascript:void(0);" class="text-body"><i class="bx bx-chat"></i> 15</a>
              </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../../../stores/UserStore";
import moment from "moment";
import { localeData } from "moment_spanish_locale";

export default {
    data() {
        return {
            projects: [],
            searchWord: "",
        };
    },
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    created() {
        moment.locale("es", localeData);
    },
    methods: {
        searchProject() {
            axios
                .get("/api/projects-search/" + this.searchWord)
                .then((result) => {
                    this.projects = result.data.projects;
                    var numTasks = 0;
                    var numTasksCompleted = 0;
                    this.projects.forEach((project) => {
                        project.deliveries.forEach((delivery) => {
                            numTasks = +delivery.assigned_activities.length;
                            delivery.assigned_activities.forEach((assigned) => {
                                if (assigned.status == 5) {
                                    numTasksCompleted++;
                                }
                            });
                        });
                        project.numTasks = numTasks;
                        project.numTasksCompleted = numTasksCompleted;
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        toProject(project) {
            this.$router.push({
                name: "project",
                params: {
                    idProject: project.id,
                },
            });
        },
        toFile(project) {
            this.$router.push({
                name: "home-documentation",
                params: { quotationId: project.projectable.quotation_id },
            });
        },
        getMyProjects() {
            axios
                .get("/api/projects-user/" + this.store.authUser.id)
                .then((res) => {
                    this.projects = res.data;
                })
                .catch((err) => {});
        },
        formatDate(date) {
            return moment(date).format("DD/MM/yyyy");
        },
        formatDays(date) {
            return moment(date).endOf("day").fromNow();
        },
        percentageProject(project) {
            if (project.num_tasks == 0) {
                return 0;
            } else {
                return parseFloat(
                    (100 / project.num_tasks) * project.num_tasks_completed
                ).toFixed(2);
            }
        },
    },
    mounted() {
        this.getMyProjects();
    },
};
</script>
<style scoped></style>
