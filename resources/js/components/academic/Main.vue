<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Departamento Académico /</span>
            Inicio
        </h4>
        <h3>
            Te damos la bienvenida,
            {{ store.authUser ? store.authUser.name : "" }}
        </h3>
        <h4
            v-if="store.authUser.roles[0].name == 'CoordAcad'"
            class="fw-normal pt-3"
        >
            Tareas pendientes de revisión
        </h4>
        <div class="row" v-else>
            <div class="col-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="card-title d-flex align-items-start justify-content-between fw-semibold"
                        >
                            Mi Puntaje Mensual
                        </div>
                        <!-- <span class="d-block mb-1">Puntaje mensual</span> -->
                        <h3 class="card-title text-nowrap mb-2">
                            {{ points }}
                        </h3>
                        <small class="text-danger fw-medium"
                            ><i class="bx bx-down-arrow-alt"></i> -14.82%</small
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="store.authUser.roles[0].name == 'CoordAcad'">
            <div class="col-lg-3 col-sm-6 mb-4" v-for="task in tasksToRevision">
                <div class="card">
                    <div class="card-header">
                        <p class="card-text">
                            {{ task.user.name }}
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p>
                                    <small>{{
                                        task.assigned_activitiable.project.title
                                    }}</small>
                                </p>

                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">
                                        {{ task.points }}
                                    </h4>

                                    <button
                                        @click="showIndicators(task)"
                                        type="button"
                                        class="btn btn-secondary btn-sm text-nowrap"
                                    >
                                        Revisar
                                    </button>
                                </div>
                                <small :title="task.name">{{
                                    task.name.substring(0, 20) + "..."
                                }}</small>
                            </div>
                            <div class="card-icon">
                                <span
                                    class="badge bg-label-primary rounded p-2"
                                >
                                    <i class="bx bx-trending-up bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="fw-normal pt-3">Tabla de puntaje de mi Equipo</h4>
        </div>
    </div>
    <IndicatorsModal
        :indicators="indicators"
        @getRevisionTaks="getRevisionTaks"
    />
</template>

<script>
import axios from "axios";
import { userStore } from "../../stores/UserStore";
import CardTask from "./projects/kanban/CardTask.vue";
import IndicatorsModal from "./IndicatorsModal.vue";

export default {
    components: { CardTask, IndicatorsModal },
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            indicators: [],
            tasksToRevision: [],
            points: 0,
        };
    },
    methods: {
        getTaskApproved() {
            axios
                .get("/api/approved-activities/" + this.store.authUser.id)
                .then((result) => {
                    this.points = result.data.points;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getRevisionTaks() {
            axios
                .get("/api/assigned-activities-revision")
                .then((result) => {
                    this.tasksToRevision = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        approveTask(taskId) {
            axios
                .get("/api/approve-activities/" + taskId)
                .then((result) => {
                    this.getRevisionTaks();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        showIndicators(task) {
            this.indicators = task.quality_indicators;
            $("#indModal").modal("show");
        },
    },
    mounted() {
        this.getRevisionTaks();
        this.getTaskApproved();
    },
};
</script>
