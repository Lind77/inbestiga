<template>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">
                        Agregar Observaciones
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group">
                            <input
                                v-model="name"
                                type="text"
                                class="form-control"
                                placeholder="Nombre del cliente"
                                aria-label="Recipient's username"
                                aria-describedby="button-addon2"
                                @keyup.enter="searchContract"
                            />
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                                id="button-addon2"
                                @click="searchContract"
                            >
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div
                            class="alert alert-warning"
                            role="alert"
                            v-show="noResults"
                        >
                            No se han encontrado contratos ni ordenes que
                            coincidan con el nombre de este usuario.
                        </div>
                        <div class="col-6 mb-2" v-for="project in projects">
                            <button
                                class="btn btn-sm btn-success w-100"
                                @click="selectDocument(project)"
                            >
                                <p
                                    class="m-0"
                                    v-for="customer in project.customers"
                                >
                                    {{ customer.name }}
                                </p>
                                {{ formatDate(project.created_at) }}
                            </button>
                        </div>
                    </div>
                    <div class="row" v-show="showFields">
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label"
                                >Fecha</label
                            >
                            <input
                                type="date"
                                v-model="date"
                                class="form-control"
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label"
                                >Avance</label
                            >
                            <input
                                type="text"
                                v-model="advance"
                                class="form-control"
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label"
                                >Fecha Académica</label
                            >
                            <input
                                type="date"
                                v-model="dateAcad"
                                class="form-control"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Salir
                    </button>
                    <button class="btn btn-primary" @click="insertDelivery">
                        Asignar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            title: "",
            comment: "",
            link: "",
            ableFormDelivery: false,
            results: [],
            noResults: false,
            contracts: [],
            orders: [],
            showFields: false,
            resultId: 0,
            resultType: 0,
            date: "",
            advance: "",
            dateAcad: "",
            dateTime: "",
            name: "",
            projects: [],
        };
    },
    props: {
        info: Object,
    },
    methods: {
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        selectDocument(result) {
            console.log(result);
            this.showFields = true;
            this.resultId = result.id;
            if (result.type == "App\\Models\\Contract") {
                this.resultType = 1;
            } else {
                this.resultType = 2;
            }
        },
        formatOrderDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        addEvent() {
            console.log(this.dateTime);
            const dateCut = this.dateTime.substring(0, 10);
            const time = this.dateTime.substring(11, 16);

            var newEvt = {
                title: this.title,
                date: dateCut,
                start: dateCut + " " + time,
                time: time,
                comment: this.comment,
                link: this.link,
                backgroundColor: "#ccffff",
                borderColor: "#ccffff",
                textColor: "#00cc99",
            };

            this.$emit("addEvent", newEvt);

            this.title = "";
            this.link = "";
            this.comment = "";
        },
        insertDelivery() {
            const fd = new FormData();
            fd.append("project_id", this.resultId);
            fd.append("type", this.resultType);
            fd.append("date", this.date);
            fd.append("advance", this.advance);
            fd.append("dateAcad", this.dateAcad);

            axios
                .post("/api/delivery", fd)
                .then((result) => {
                    $("#eventModal").modal("hide");
                    this.$emit("getDeliveries");
                    this.$emit("getEvents");

                    this.resultType = 0;
                    this.date = "";
                    this.advance = "";
                    this.dateAcad = "";
                    this.contracts = [];
                    this.orders = [];
                    this.name = "";
                    this.results = [];
                    this.ableFormDelivery = false;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        searchContract() {
            axios
                .get("/api/projects-search/" + this.name)
                .then((result) => {
                    this.projects = result.data.projects;
                })
                .catch((err) => {});
        },
    },
};
</script>
<style lang=""></style>
