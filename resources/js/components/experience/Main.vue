<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="alert alert-danger" role="alert">
                Por favor, rellenar las fichas de cliente. Aun nos quedan
                {{ numDocs }}
            </div>
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    {{
                                        store.authUser
                                            ? store.authUser.name
                                            : ""
                                    }}, te damos la bienvenida 🎉
                                </h5>
                                <p class="mb-4">
                                    Hay
                                    <span class="fw-bold">{{
                                        deliveries.length
                                    }}</span>
                                    entregas para hoy, te recomendamos
                                    revisarlas.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                    src="https://themeselection-cdn.b-cdn.net/wp-content/uploads/2022/05/github-img.png"
                                    height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-4 order-lg-3">
                <div class="card">
                    <div
                        class="card-header d-flex align-items-center justify-content-between"
                    >
                        <h5 class="card-title m-0 me-2">
                            Permisos Solicitados
                            <!-- <span @click="showModalNote"
                class="badge bg-label-primary me-1 cursor-pointer">+</span> -->
                        </h5>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <!-- Activity Timeline -->
                            <template v-for="permission in permissions">
                                <div
                                    class="card bg-success text-white"
                                    v-if="permission.status == 0"
                                >
                                    <div class="card-header">
                                        Solicitud de {{ permission.user.name }}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-white">
                                            {{ permission.miss_date }}
                                        </h5>
                                        <p class="card-text">
                                            {{ permission.reason }}
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-4 order-lg-3">
                <div class="card">
                    <div
                        class="card-header d-flex align-items-center justify-content-between"
                    >
                        <h5 class="card-title m-0 me-2">Entregas para hoy</h5>
                    </div>
                    <div class="card-body">
                        <!-- Activity Timeline -->
                        <div
                            class="card bg-success text-white mb-3"
                            v-for="delivery in deliveries"
                        >
                            <div class="card-header">
                                Entrega de
                                {{ delivery.type == 1 ? "Contrato" : "Orden" }}
                            </div>
                            <div class="card-body">
                                <template
                                    v-if="
                                        delivery.project &&
                                        delivery.project.projectable
                                    "
                                >
                                    <h5 class="card-title text-white">
                                        {{
                                            delivery.project.projectable
                                                .quotation.customers[0].name
                                        }}
                                    </h5>
                                </template>
                                <p class="card-text">
                                    {{ delivery.advance }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <NoteModal @getAllDeliveries="getAllDeliveries" />
</template>
<script>
import axios from "axios";
import { userStore } from "../../stores/UserStore";
import NoteModal from "../experience/NoteModal.vue";

export default {
    components: { NoteModal },
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            deliveries: [],
            notes: [],
            permissions: [],
            numDocs: 0,
        };
    },
    methods: {
        showModalNote() {
            $("#deliveryModal").modal("show");
        },
        getPermissionsRequest() {
            axios
                .get("/api/attendance-permits")
                .then((result) => {
                    this.permissions = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getAllDeliveries() {
            axios
                .get("/api/deliveries")
                .then((result) => {
                    this.deliveries = result.data.deliveries.filter(
                        (delivery) => delivery.status != 3
                    );
                    this.notes = result.data.deliveries.filter(
                        (delivery) => delivery.status == 3
                    );
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        pendingDocuments() {
            axios
                .get("/api/projects-pending")
                .then((result) => {
                    this.numDocs = result.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    mounted() {
        this.getPermissionsRequest();
        this.getAllDeliveries();
        this.pendingDocuments();
    },
};
</script>
