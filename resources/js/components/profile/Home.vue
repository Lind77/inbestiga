<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar :hidden="hidden" />
            <div class="layout-page">
                <Navbar @hideSidebar="hideSidebar" />
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4">Mi Perfil</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div
                                        class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                                        <div class="flex-grow-1 mt-1 mt-sm-4">
                                            <div
                                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                                <div class="user-profile-info">
                                                    <h4>{{ user.name }}</h4>
                                                    <ul
                                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                        <li class="list-inline-item fw-medium" v-if="user.roles">
                                                            <i class="bx bx-pen"></i>
                                                            {{
                                                                user.roles[0]
                                                                    .name
                                                            }}
                                                        </li>
                                                        <li class="list-inline-item fw-medium">
                                                            <i class="bx bx-map"></i>
                                                            Huancayo
                                                        </li>
                                                        <li class="list-inline-item fw-medium">
                                                            <i class="bx bx-calendar-alt"></i>
                                                            Joined April 2022
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                                                    <i class="bx bx-user-check me-1"></i>Connected
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="nav-align-top mb-4">
                                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-justified-home"
                                                aria-controls="navs-pills-justified-home" aria-selected="true">
                                                <i class="tf-icons bx bx-home"></i> Mi Horario
                                                <span
                                                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger">3</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-justified-profile"
                                                aria-controls="navs-pills-justified-profile" aria-selected="false">
                                                <i class="tf-icons bx bx-user"></i> Seguridad
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-justified-messages"
                                                aria-controls="navs-pills-justified-messages" aria-selected="false">
                                                <i class="tf-icons bx bx-message-square"></i> Messages
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="navs-pills-justified-home"
                                            role="tabpanel">
                                            <div class="row">
                                                <div class="col-2">
                                                    <h3>{{ totalHours }}</h3>
                                                    <p>HORAS</p>
                                                    <a href="javascript:void(0)" @click="openModalSchedule"
                                                        class="btn btn-primary text-nowrap">
                                                        + Horario
                                                    </a>
                                                </div>
                                                <div class="col-10">
                                                    <div class="row">
                                                        <div class="col" v-for="day in days">
                                                            <p>{{ day.day }}</p>
                                                            <div class="d-flex flex-column">
                                                                <button @click="addHour" class="btn btn-primary p-2 mb-1"
                                                                    v-for="n in 14">{{ n + 7 }}:00</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                            <p>
                                                Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy
                                                oat cake ice
                                                cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread.
                                                Pastry ice cream
                                                cheesecake fruitcake.
                                            </p>
                                            <p class="mb-0">
                                                Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie
                                                tiramisu halvah
                                                cotton candy liquorice caramels.
                                            </p>
                                        </div>
                                        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                            <p>
                                                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans
                                                macaroon gummies
                                                cupcake gummi bears cake chocolate.
                                            </p>
                                            <p class="mb-0">
                                                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie
                                                brownie cake. Sweet
                                                roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert
                                                dessert. Pudding jelly
                                                jelly-o tart brownie jelly.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
            </div>
        </div>
    </div>
    <ScheduleModal />
</template>
<script>
import Sidebar from "../layout/Sidebar.vue";
import Navbar from "../layout/Navbar.vue";
import moment from "moment/min/moment-with-locales";
import ScheduleModal from "./ScheduleModal.vue"
export default {
    components: { Sidebar, Navbar, ScheduleModal },
    data() {
        return {
            hidden: true,
            user: {},
            days: [
                {
                    day: 'Lunes'
                },
                {
                    day: 'Martes'
                },
                {
                    day: 'Miércoles'
                },
                {
                    day: 'Jueves'
                },
                {
                    day: 'Viernes'
                },
                {
                    day: 'Sábado'
                }
            ],
            totalHours: 0
        };
    },
    methods: {
        openModalSchedule() {
            $("#scheduleModal").modal("show");
        },
        getUser() {
            axios
                .get("/api/users/" + this.$route.params.idUser)
                .then((result) => {
                    this.user = result.data;
                })
                .catch((err) => { });
        },
        addHour() {
            this.totalHours++;
        },
        hideSidebar() {
            this.hidden = !this.hidden
        }
    },
    mounted() {
        this.getUser();
    },
};
</script>
