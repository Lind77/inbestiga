<template>
    <div
        class="modal fade"
        id="firstMeetModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Detalles para la primera reunión {{ activity.id }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="close-progress-modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="row mb-3">
                    <div class="col">
                        <label for="firstMeetingDate" class="form-label">Fecha</label>
                        <input type="date" name="" id="firstMeetingDate" class="form-control">
                    </div>
                    <div class="col">
                        <label for="firstMeetingTime" class="form-label">Hora</label>
                        <input type="time" name="" id="firstMeetingTime" class="form-control">
                    </div>
                </div> -->
                    <div class="mb-3">
                        <label for="firstMeetingDetails" class="form-label"
                            >Detalles de la primera reunión</label
                        >
                        <textarea
                            class="form-control"
                            id="firstMeetingDetails"
                            v-model="detail"
                            cols="30"
                            rows="4"
                        ></textarea>
                    </div>
                    <!-- <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Archivos importantes</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple="">
                </div>  -->
                </div>

                <div class="modal-footer">
                    <input
                        @click="insertDetailsFirstMeeting"
                        type="submit"
                        class="btn btn-primary"
                        value="Enviar"
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
        activity: Object,
    },
    methods: {
        insertDetailsFirstMeeting() {
            const fd = new FormData();
            fd.append("activityId", this.activity.id);
            fd.append("detail", this.detail);

            axios
                .post("/api/insertDetailsFirstMeeting", fd)
                .then((res) => {
                    this.detail = "";
                    $("#firstMeetModal").modal("hide");
                    this.$emit("colorActivity", this.activity);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
