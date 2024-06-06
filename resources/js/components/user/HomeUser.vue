<template>
    <div class="bg-user">
        <div class="px-0">
            <div class="row">
                <Sidebar :hidden="hidden" />
                <div :class="hidden ? 'col-9' : 'col-12'" class="px-4">
                    <Navbar @toggleSidebar="toggleSidebar" />
                    <div class="row px-3">
                        <div class="col-6 ps-5">
                            <h1 class="text-white title">
                                ¡Inbestiga te da la bienvenida!
                            </h1>
                            <p class="text-white">
                                Bienvenido a tu aula virtual de Inbestiga, el
                                lugar para administrar y monitorear tus
                                proyectos de investigación
                            </p>
                            <li class="menu-item text-white mb-2 w-50">
                                Experiencia de Usuario
                            </li>
                        </div>
                        <div class="col-6">
                            <img
                                src="https://inbestiga.com/inbestiga/public/img/homeImg.png"
                                alt=""
                                srcset=""
                                class="w-100"
                            />
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-around w-100">
                        <Card
                            :imageUrl="'https://inbestiga.com/inbestiga/public/img/slider1.png'"
                        />
                        <Card
                            :imageUrl="'https://inbestiga.com/inbestiga/public/img/slider2.png'"
                        />
                        <Card
                            :imageUrl="'https://inbestiga.com/inbestiga/public/img/slider3.png'"
                        />
                        <Card
                            :imageUrl="'https://inbestiga.com/inbestiga/public/img/slider4.png'"
                        />
                        <Card
                            :imageUrl="'https://inbestiga.com/inbestiga/public/img/slider5.png'"
                        />
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

export default {
    components: { Sidebar, Navbar, Card },
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
    height: 140vh;
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
</style>
