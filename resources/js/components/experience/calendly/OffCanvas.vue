<template>
    <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasEvent"
        aria-labelledby="offcanvasEndLabel"
    >
        <div class="offcanvas-header" v-if="info.event">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">
                {{ info.event.title }}
                <!--  <i
                    v-if="info.event.extendedProps.type == 1"
                    @click="deleteEvent(info.event.extendedProps.deliveryId)"
                    class="bx bx-trash text-danger cursor-pointer"
                ></i>
                <i
                    v-else
                    @click="deleteDelivery(info.event.extendedProps.deliveryId)"
                    class="bx bx-trash text-danger cursor-pointer"
                ></i> -->
            </h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0" v-if="info.event">
            <div class="mb-3">
                <label for="" class="form-label">Entregable</label>
                <p>
                    {{ info.event.extendedProps.comment }}
                </p>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Responsable</label>
                <Select
                    :userSelected="info.event.extendedProps.user"
                    :users="acadUsers"
                    @changeEventColor="changeEventColor"
                />
            </div>
            <!-- <p>Estado: {{ statusByNumber[info.event.extendedProps.status] }}</p> -->
            <div class="mb-3">
                <label for="" class="form-label">Fecha de Inicio</label>
                <input
                    type="date"
                    name=""
                    id=""
                    class="form-control"
                    v-model="dateFormatted"
                />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Descripción</label>
                <textarea v-model="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" @click="updateInfoEvent">
                    Guardar
                </button>
                <button class="btn btn-success mx-2">Aprobar</button>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import Select from "./Select.vue";

export default {
    components: { Select },
    data() {
        return {
            statusByNumber: {
                0: "No realizado",
                1: "Realizado",
            },
            dateFormatted: "",
            description: "",
        };
    },
    props: {
        info: Object,
        acadUsers: Array,
    },
    methods: {
        updateInfoEvent() {
            const fd = new FormData();

            fd.append("date", this.dateFormatted);
            fd.append("description", this.description);
            fd.append("_method", "put");
            axios
                .post(
                    "/api/delivery-info/" +
                        this.info.event.extendedProps.deliveryId,
                    fd
                )
                .then((result) => {
                    this.$emit("getDeliveries");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        changeEventColor(userId, userColor) {
            console.log(this.info.event);
            axios
                .get(
                    `/api/change-color-event/${this.info.event.extendedProps.deliveryId}/${userId}`
                )
                .then((result) => {
                    this.$emit(
                        "changeEventColor",
                        this.info.event.extendedProps.deliveryId,
                        result.data.user
                    );
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        deleteEvent(meetingId) {
            $("#offcanvasEvent").offcanvas("hide");
            this.$swal
                .fire({
                    title: "¿Deseas eliminar este evento?",
                    showDenyButton: true,
                    confirmButtonText: "Si",
                    denyButtonText: "No",
                })
                .then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        axios
                            .delete("/api/deliveries/" + meetingId)
                            .then((result) => {
                                this.$emit("getEvents");
                                this.$emit("getDeliveries");
                            })
                            .catch((err) => {
                                console.error(err);
                            });
                    }
                });
        },
        completeMeeting(meetingId) {
            console.log(meetingId);
            axios
                .get("/api/meetings-complete/" + meetingId)
                .then((result) => {
                    this.$emit("getEvents");
                    this.$emit("getDeliveries");
                    $("#offcanvasEvent").offcanvas("hide");
                })
                .catch((err) => {
                    console.error(err);
                });
            this.$emit("changeEventColor", this.info.event.id);
        },
        deleteDelivery(deliveryId) {
            if (confirm("Deseas eliminar esta entrega, con seguridad?")) {
                axios
                    .delete("/api/deliveries/" + deliveryId)
                    .then((result) => {
                        this.$emit("getEvents");
                        this.$emit("getDeliveries");
                        $("#offcanvasEvent").offcanvas("hide");
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
        },
    },
    watch: {
        info() {
            if (this.info.event.start) {
                const formattedDate = moment(this.info.event.start).format(
                    "YYYY-MM-DD"
                );
                this.dateFormatted = formattedDate;
            }
            console.log(this.info.event.extendedProps.description);
            if (this.info.event.extendedProps.description != null) {
                this.description = this.info.event.extendedProps.description;
            } else {
                this.description = "";
            }
        },
    },
};
</script>
<style scoped>
option:after {
    content: " ";
    height: 5px;
    width: 5px;
    border-radius: 5px;
    display: inline-block;
}

option.red:after {
    background: #c00;
}
option.green:after {
    background: #0c0;
}
option.blue:after {
    background: #00c;
}
</style>
