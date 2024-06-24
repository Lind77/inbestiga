<template>
    <div class="bg-user">
        <div class="px-0">
            <div class="row">
                <Sidebar :hidden="hidden" />
                <div :class="hidden ? 'col-9' : 'col-12'" class="px-4">
                    <Navbar @toggleSidebar="toggleSidebar" />
                    <div class="row px-3">
                        <div class="col-6 ps-5 d-none d-lg-block">
                            <h1 class="text-white title">
                                {{ store.authUser.name }}, ¡Inbestiga te da la
                                bienvenida!
                            </h1>
                            <p class="text-white">
                                Gestiona tus proyectos y vive una experiencia
                                innolvidable
                            </p>
                            <div class="d-flex w-50 mt-5">
                                <button class="menu-item text-white mb-2">
                                    <i class="bx bx-diamond"></i>
                                    Experiencia de Usuario
                                </button>
                                <button class="menu-item text-white mb-2 ms-1">
                                    <i class="bx bx-play-circle"></i>
                                    User Experience
                                </button>
                            </div>
                        </div>
                        <div
                            class="col-12 col-lg-6 order-first order-lg-last mt-5"
                        >
                            <img
                                src="https://inbestiga.com/inbestiga/public/img/homeImg.png"
                                class="img-main"
                            />
                            <img
                                src="https://jairpl.com/pdf-sys/logo.png"
                                class="mb-3 w-50 d-block d-lg-none m-auto mt-n5"
                            />
                            <h2
                                class="d-block d-lg-none text-center text-white fw-normal"
                            >
                                Bienvenido a tu aula virtual
                            </h2>
                            <div class="row my-4 d-block d-lg-none">
                                <li class="menu-item text-white mb-2 w-50">
                                    Experiencia de Usuario
                                </li>
                                <li class="menu-item text-white mb-2 w-50">
                                    Experiencia de Usuario
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-4 ps-5">
                            <h3 class="mt-n5 text-center text-white">
                                Experiencia de usuario
                            </h3>
                            <img
                                src="https://inbestiga.com/inbestiga/public/img/resource2.png"
                                class="ms-5"
                            />
                        </div>
                        <div class="col-8">
                            <div
                                class="d-flex flex-row justify-content-around w-100"
                            >
                                <Card
                                    :imageUrl="'https://i.pinimg.com/564x/63/a7/05/63a7058d7ab2fc4dbfe9540960b96aa2.jpg  '"
                                    :text="'Comienza tu tesis'"
                                />
                                <Card
                                    :imageUrl="'https://i.pinimg.com/564x/dd/d1/8a/ddd18a24e555b6b976810ca407dbcc7b.jpg'"
                                    :text="'Informes'"
                                />
                                <Card
                                    :imageUrl="'https://i.pinimg.com/564x/ab/d6/a1/abd6a1374a9bff8b84f107c9e944ea39.jpg'"
                                    :text="'Canal oficial'"
                                />
                                <Card
                                    :imageUrl="'https://i.pinimg.com/736x/0f/f8/c6/0ff8c6d78cc203314698f3d660de989a.jpg'"
                                    :text="'Reuniones infinitas'"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 pt-5 pb-5">
                        <h3 class="mt-n5 text-center text-white">
                            Mis proyectos
                        </h3>
                        <div class="col-8 ps-5 mt-2">
                            <ProjectCard />
                        </div>
                        <div class="col-4 mt-5">
                            <h3 class="mt-n5 text-center text-white">
                                Información académica
                            </h3>
                            <img
                                src="https://inbestiga.com/inbestiga/public/img/bottle.png"
                                class="ms-5"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import Card from "./Card.vue";
import ProjectCard from "./ProjectCard.vue";
import { userStore } from "../../stores/UserStore";

export default {
    components: { Sidebar, Navbar, Card, ProjectCard },
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            info: {},
            projects: [],
            hidden: false,
        };
    },
    methods: {
        toggleSidebar() {
            this.hidden = !this.hidden;
        },
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
    height: auto;
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
    border: 1px solid #7f21fb;
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
.title {
    font-size: 50px;
    font-weight: 500;
    margin: 7rem 5rem 3rem 0rem;
}
p {
    margin: 2rem 16rem 3rem 0rem;
}

.img-main {
    margin-top: -8em;
    margin-left: -8em;
    width: 140%;
    padding-right: 0%;
}

@media only screen and (max-width: 576px) {
    .menu-item {
        margin: 0px 10px;
        width: 45% !important;
        font-size: 1em;
    }
}
</style>
