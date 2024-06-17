<template>
    <div class="modal fade" id="indModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Indicadores de Calidad</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="close-progress-modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Indicadores</th>
                                <th
                                    v-if="
                                        store.authUser.roles[0].name ==
                                        'CoordAcad'
                                    "
                                >
                                    Opciones
                                </th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="indicator in indicators">
                                <td>{{ indicator.name }}</td>
                                <td
                                    v-if="
                                        store.authUser.roles[0].name ==
                                        'CoordAcad'
                                    "
                                >
                                    <div class="d-flex">
                                        <button
                                            class="btn btn-icon btn-sm btn-success ms-4"
                                            @click="acceptIndicator(indicator)"
                                        >
                                            <i class="bx bx-check"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon btn-sm btn-danger ms-2"
                                            @click="rejectIndicator(indicator)"
                                        >
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success"
                                        v-show="indicator.status == 1"
                                        >Aprobado</span
                                    >
                                    <span
                                        class="badge bg-danger mb-1"
                                        v-show="indicator.status == 0"
                                        >Rechazado</span
                                    >
                                    <textarea
                                        v-show="
                                            indicator.status == 0 &&
                                            store.authUser.roles[0].name ==
                                                'CoordAcad'
                                        "
                                        class="form-control w-100"
                                        v-model="indicator.observation"
                                    ></textarea>
                                    <p
                                        v-show="
                                            store.authUser.roles[0].name !=
                                            'CoordAcad'
                                        "
                                    >
                                        {{ indicator.observation }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input
                        v-if="confirmApprovation"
                        @click="aproveTask"
                        type="submit"
                        class="btn btn-success"
                        value="Aprobar"
                    />
                    <input
                        v-if="store.authUser.roles[0].name == 'CoordAcad'"
                        @click="rejectTask"
                        type="submit"
                        class="btn btn-danger"
                        value="Rechazar"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            detail: "",
        };
    },
    props: {
        indicators: Array,
    },
    methods: {
        acceptIndicator(indicator) {
            indicator.status = 1;
        },
        rejectIndicator(indicator) {
            indicator.status = 0;
        },
        aproveTask() {
            axios
                .get(
                    "/api/approve-activities/" +
                        this.indicators[0].quality_indicable_id
                )
                .then((result) => {
                    this.$emit("getRevisionTaks");
                    this.$emit("getProject");
                    $("#indModal").modal("hide");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        rejectTask() {
            const fd = new FormData();

            fd.append(
                "assignedActivityId",
                this.indicators[0].quality_indicable_id
            );
            fd.append("indicators", JSON.stringify(this.indicators));

            axios
                .post("/api/reject-assigned-activity", fd)
                .then((result) => {
                    this.$emit("getRevisionTaks");
                    this.$emit("getProject");
                    $("#indModal").modal("hide");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    computed: {
        confirmApprovation() {
            if (this.indicators && this.indicators[0]) {
                var approvedIndicators = this.indicators.filter(
                    (i) => i.status == 1
                );
                return approvedIndicators.length == this.indicators.length;
            }
        },
    },
};
</script>
