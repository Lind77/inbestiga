<template>
    <div
        class="modal fade"
        id="indicatorsModal"
        tabindex="-1"
        aria-hidden="true"
    >
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
                                <th>Opciones</th>
                                <th>Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="indicator in indicators">
                                <td>{{ indicator.name }}</td>
                                <td>
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
                                    <textarea
                                        v-show="indicator.status == 0"
                                        class="form-control w-100"
                                        v-model="indicator.observation"
                                    ></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input
                        @click="aproveTask"
                        type="submit"
                        class="btn btn-success"
                        value="Aprobar"
                    />
                    <input
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
export default {
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
                    $("#indicatorsModal").modal("hide");
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
                    $("#indicatorsModal").modal("hide");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
