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
        <h4 class="fw-normal pt-3">Tareas pendientes de revisión</h4>
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
        };
    },
    methods: {
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
            $("#indicatorsModal").modal("show");
        },
    },
    mounted() {
        this.getRevisionTaks();
    },
};
</script>
