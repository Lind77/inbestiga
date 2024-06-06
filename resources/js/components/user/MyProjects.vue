<template>
    <div class="bg-user">
        <div class="px-0">
            <div class="row">
                <Sidebar />
                <div class="col-9 px-4">
                    <div class="glass d-flex mt-2">
                        <ul
                            class="navbar-nav flex-row align-items-center ms-auto"
                        >
                            <li
                                class="nav-item navbar-dropdown dropdown-user dropdown"
                            >
                                <a
                                    class="nav-link dropdown-toggle hide-arrow pt-0 pe-3"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown"
                                >
                                    <div class="avatar">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-md me-4">
                                                <img
                                                    src="https://inbestiga.com/inbestiga/public/files/1709671609.png"
                                                    alt="Avatar"
                                                    class="rounded-circle"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <!-- <li>
                                        <a class="dropdown-item">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 cursor-pointer">
                                                    <span class="fw-semibold d-block">{{ }}</span>
                                                    <small class="text-muted">{{ }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li> -->
                                    <!-- <li>
                                        <div class="dropdown-divider"></div>
                                    </li> -->
                                    <li>
                                        <a
                                            class="dropdown-item cursor-pointer"
                                            @click="logout"
                                        >
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle"
                                                >Salir</span
                                            >
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <h3 class="text-white text-center mt-3">
                            Mis Proyectos
                        </h3>
                        <template v-for="quotation in info.quotations">
                            <div class="col-4" v-for="project in projects">
                                <div
                                    class="card bg-card glass mt-4 cursor-pointer"
                                    @click="showCustomerModal(quotation.id)"
                                >
                                    <div class="card-header pb-0">
                                        <img
                                            src="https://st.depositphotos.com/1380064/2259/i/450/depositphotos_22598471-stock-photo-abstract-technology-background-illustration.jpg"
                                            class="w-25 mb-2 rounded"
                                        />
                                        <h4 class="text-white">
                                            {{ project.title }}
                                        </h4>
                                        <p
                                            class="text-white"
                                            v-for="customer in quotation.customers"
                                        >
                                            {{ customer.name }}
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div
                                                    class="card shadow-none bg-transparent border border-ligth mb-3"
                                                >
                                                    <div class="card-body">
                                                        <h6
                                                            class="card-title text-white"
                                                        >
                                                            {{
                                                                project.created_at
                                                                    ? convertDate(
                                                                          project.created_at
                                                                      )
                                                                    : "Sin asignar"
                                                            }}
                                                        </h6>
                                                        <p
                                                            class="h6 card-text text-white"
                                                        >
                                                            Inicio
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div
                                                    class="card shadow-none bg-transparent border border-ligth mb-3"
                                                >
                                                    <div class="card-body">
                                                        <h6
                                                            class="card-title text-white"
                                                        >
                                                            {{
                                                                project.deadline
                                                                    ? project.deadline
                                                                    : "Sin asignar"
                                                            }}
                                                        </h6>
                                                        <p
                                                            class="h6 card-text text-white"
                                                        >
                                                            Culminación
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-3">
                                                <div
                                                    class="progress w-100 ps-0"
                                                    style="height: 8px"
                                                >
                                                    <div
                                                        class="progress-bar bg-info"
                                                        style="width: 78%"
                                                        role="progressbar"
                                                        aria-valuenow="78"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                    ></div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center avatar-group mt-3"
                                            >
                                                <div
                                                    class="avatar avatar-sm me-2"
                                                    v-for="user in project.team
                                                        .users"
                                                    :title="user.name"
                                                >
                                                    <span
                                                        class="avatar-initial rounded-circle bg-primary"
                                                        >{{
                                                            user.name[0]
                                                        }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import Sidebar from "./Sidebar.vue";

export default {
    components: { Sidebar },
    data() {
        return {
            info: {},
            projects: [],
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        showCustomerModal(quotationId) {
            this.$router.push({
                name: "user-documentation",
                params: { quotationId: quotationId },
            });
        },
        logout() {
            this.$router.push({ name: "user-login" });
        },
        getUserInfo() {
            axios
                .get("/api/customer-by-id/" + this.$route.params.customerId)
                .then((result) => {
                    this.info = result.data;
                    result.data.quotations.forEach((quotation) => {
                        quotation.contract.projects.forEach((project) => {
                            this.projects.push(project);
                        });
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getUserInfo();
    },
};
</script>
<style scoped>
.bg-user {
    width: 100%;
    height: 120vh;
    background-image: url("https://inbestiga.com/inbestiga/public/img/cuadros.png"),
        linear-gradient(
            67deg,
            rgba(38, 20, 38, 1) 19%,
            rgba(41, 21, 41, 1) 30%,
            rgba(95, 29, 95, 1) 64%
        );
    background-size: cover;
}

.main-logo {
    width: 100%;
}

.bg-card {
    background-color: rgba(0, 0, 0, 0.32);
}

.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}

.menu-item {
    height: auto;
    width: 100%;
    padding: 5px;
    list-style: none;
    border: 1px solid #fb15d7;
    border-radius: 5px;
    font-size: 20px;
    text-align: center;
    cursor: pointer;
    background: linear-gradient(0deg, #7f21fb 64%, rgba(127, 33, 251, 0) 64%);
    background-size: 100% 400%;
    background-position: 100% 0%;
    transition: background 0.3s ease;
}

.menu-item:hover {
    background-position: 100% 100%;
    border: 3px solid #7f21fb;
}

.timeline .timeline-item .timeline-point-wrapper {
    position: absolute;
    top: -0.5rem;
    left: -0.4089999999999998rem;
    z-index: 2;
    display: block;
    height: 2.25rem;
    width: 2.25rem;
    background-color: #03c3ec;
}

.timeline .timeline-item .timeline-point {
    position: absolute;
    left: 0;
    top: 0.75rem;
    z-index: 3;
    display: block;
    height: 0.75rem;
    width: 0.75rem;
    border-radius: 50%;
    background-color: #696cff;
}

.timeline .timeline-point-primary {
    background-color: #696cff !important;
    box-shadow: 0 0 0 0.1875rem rgba(105, 108, 255, 0.16);
}

.progress {
    background: #ffffff49;
}
</style>
