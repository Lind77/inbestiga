<template>
    <div id="bg-user" class="bg-user pt-5">
        <div class="container">
            <Navbar />
            <div class="row">
                <div class="col-12">
                    <div
                        class="main d-flex justify-content-center flex-column mt-5"
                    >
                        <h2
                            class="main-text subtext text-white text-center mt-4 mb-5"
                        >
                            <span class="main-text-bold">
                                {{ project.title }}</span
                            >
                        </h2>

                        <CollapseCard
                            class="mb-5"
                            :title="'Historial de mi proyecto'"
                            :componentSelected="'TimeLine'"
                            :project="project"
                            @openModal="openModal"
                            @openModalAcademic="openModalAcademic"
                            @changeBackground="changeBackground"
                        />

                        <!--   
                        <CollapseCard
                            :title="'Integrantes'"
                            :componentSelected="'CustomerCard'"
                            :project="project"
                        />
                        <CollapseCard
                            :title="'Información académica'"
                            :componentSelected="'FormCard'"
                        /> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Postmodal :project="project" />
    <AcademicModal :project="project" />
</template>
<script>
import moment from "moment";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import Card from "./Card.vue";
import ProjectCard from "./ProjectCard.vue";
import Carousel from "./Carousel.vue";
import CarouselTest from "./CarouselTest.vue";
import { userStore } from "../../stores/UserStore";
import CollapseCard from "./CollapseCard.vue";
import FormCard from "./FormCard.vue";
import Postmodal from "./Postmodal.vue";
import AcademicModal from "./AcademicModal.vue";

export default {
    components: {
        Sidebar,
        Navbar,
        Card,
        ProjectCard,
        Carousel,
        CarouselTest,
        CollapseCard,
        FormCard,
        Postmodal,
        AcademicModal,
    },
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            info: {},
            projects: [],
            hidden: false,
            quotations: [],
            project: {},
        };
    },
    methods: {
        openModalAcademic() {
            $("#academicModal").modal("show");
        },
        changeBackground(collapsed) {
            if (!collapsed) {
                $("#bg-user").addClass("auto-height");
            } else {
                $("#bg-user").removeClass("auto-height");
            }
        },
        openModal() {
            $("#postModal").modal("show");
        },
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
        getProjectInfo() {
            axios
                .get("/api/projects/" + this.$route.params.projectId)
                .then((result) => {
                    this.project = result.data;
                    if (this.project.posts.length == 0) {
                        $("#bg-user").addClass("auto-height");
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getProjectInfo();
    },
};
</script>
<style scoped>
.auto-height {
    height: 100vh !important;
}

.input-icons {
    display: flex;
    align-items: center;
}

.input-icons i {
    position: absolute;
    color: #fff;
    margin-left: 2rem;
    z-index: 99;
}

.search {
    border-radius: 10px;
    color: #fff;
    padding: 10px 35px !important;
    width: 90%;
    margin: 0px auto;
    border: none;
}

.main-logo {
    width: 50%;
}

.main-text {
    font-size: 25px;
    font-weight: 300;
}

.main-text-bold {
    font-weight: 600;
}
.subtext {
    font-size: 45px;
}

.main-video {
    object-fit: cover;
    width: 100%;
}

.sub-text {
    font-size: 30px;
    font-weight: 300;
}

.sub-text-bold {
    font-weight: 600;
}

.pink {
    color: #fb15d7;
    font-weight: 700;
}

.swiper-button-prev {
    padding-right: 30px !important; /* Ajusta el valor del padding según tus necesidades */
}

.effect-transition {
    transition: 1s;
}

.bg-user {
    width: 100%;
    height: auto;
    background-image: linear-gradient(
        135deg,
        rgba(95, 29, 95, 1) 2%,
        rgba(41, 21, 41, 1) 25%,
        rgba(41, 21, 41, 1) 57%,
        rgba(95, 29, 95, 1) 92%
    );
    background-size: cover;
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
        width: 40% !important;
        font-size: 1em;
    }
    .img-main {
        margin: -4em auto;
        width: 98%;
    }

    .text-logo {
        margin-top: 2em !important;
    }

    h3 {
        font-size: 2em;
        margin-bottom: 1.4em;
        margin-top: 1.4em !important;
    }

    .project-section {
        margin-top: -80% !important;
    }
}

@media (min-width: 600px) {
    .input-icons i {
        position: absolute;
        color: #fff;
        margin-left: 4rem;
        z-index: 99;
    }
}
</style>
