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
                        <div class="card glass p-2 text-white">
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-white">
                                        Porfavor rellena el formulario a
                                        continuación
                                    </h5>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label for=""
                                                >Canal de comunicación
                                                preferido</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="comunicationChanelId"
                                            >
                                                <option
                                                    :value="
                                                        comunicationChanel.id
                                                    "
                                                    v-for="comunicationChanel in comunicationChanels"
                                                >
                                                    {{
                                                        comunicationChanel.name
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for=""
                                                >¿Cómo te enteraste de nuestros
                                                servicios?</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="mktSourceId"
                                            >
                                                <option
                                                    :value="mktSource.id"
                                                    v-for="mktSource in mktSources"
                                                >
                                                    {{ mktSource.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for=""
                                                >¿Cómo realizaste la
                                                contratación de nuestros
                                                servicios?</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="contractModeId"
                                            >
                                                <option
                                                    :value="contractMode.id"
                                                    v-for="contractMode in contractModes"
                                                >
                                                    {{ contractMode.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for=""
                                                >Estado profesional</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="professionalStatusId"
                                            >
                                                <option
                                                    :value="
                                                        professionalStatus.id
                                                    "
                                                    v-for="professionalStatus in professionalStatuses"
                                                >
                                                    {{
                                                        professionalStatus.name
                                                    }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label for=""
                                                >¿Cuenta con lugar de
                                                estudio?</label
                                            >
                                            <div class="flex">
                                                <div
                                                    class="form-check form-check-inline mt-1"
                                                >
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        name="inlineRadioOptions"
                                                        id="inlineRadio1"
                                                        value="1"
                                                        v-model="studyPlaceId"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineRadio1"
                                                        >Si</label
                                                    >
                                                </div>
                                                <div
                                                    class="form-check form-check-inline mt-3"
                                                >
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        name="inlineRadioOptions"
                                                        id="inlineRadio2"
                                                        value="2"
                                                        v-model="studyPlaceId"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineRadio2"
                                                        >No</label
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label for="">
                                                <small>
                                                    ¿Cuál fue el factor
                                                    principal que te llevó a
                                                    contratar nuestros
                                                    servicios?
                                                </small>
                                            </label>
                                            <select
                                                class="form-control"
                                                v-model="hireFactorId"
                                            >
                                                <option
                                                    :value="hireFactor.id"
                                                    v-for="hireFactor in hireFactors"
                                                >
                                                    {{ hireFactor.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label for=""
                                                >¿Cuál es tu situación académica
                                                actual?</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="academicSituationId"
                                            >
                                                <option
                                                    :value="
                                                        academicSituation.id
                                                    "
                                                    v-for="academicSituation in academicSituations"
                                                >
                                                    {{ academicSituation.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label for=""
                                                >¿Qué tanto deseas participar en
                                                la elaboración de tu
                                                tesis?</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="participationId"
                                            >
                                                <option
                                                    :value="participation.id"
                                                    v-for="participation in participations"
                                                >
                                                    {{ participation.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="w-full d-flex justify-content-center"
                                    >
                                        <button
                                            @click="saveFormPostSales"
                                            class="btn btn-primary w-75 mt-3"
                                        >
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <CollapseCard
                            class="mb-5"
                            :title="'Historial de mi proyecto'"
                            :componentSelected="'TimeLine'"
                            :project="project"
                            @openModal="openModal"
                            @openModalAcademic="openModalAcademic"
                            @changeBackground="changeBackground"
                            @getProjectInfo="getProjectInfo"
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
    <Postmodal :project="project" @getProjectInfo="getProjectInfo" />
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
            comunicationChanels: [],
            mktSources: [],
            hireFactors: [],
            contractModes: [],
            academicSituations: [],
            professionalStatuses: [],
            participations: [],
            comunicationChanelId: 0,
            mktSourceId: 0,
            hireFactorId: 0,
            contractModeId: 0,
            academicSituationId: 0,
            professionalStatusId: 0,
            participationId: 0,
            studyPlaceId: 0,
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
                    var post_form = this.project.projectable.post_form;

                    if (post_form) {
                        this.comunicationChanelId =
                            post_form.comunication_channel_id;
                        this.mktSourceId = post_form.marketing_source_id;
                        this.hireFactorId = post_form.hire_factor_id;
                        this.contractModeId = post_form.contract_mode_id;
                        this.academicSituationId =
                            post_form.academic_situation_id;
                        this.professionalStatusId =
                            post_form.professional_status_id;
                        this.participationId = post_form.participation_id;
                        this.studyPlaceId = post_form.study_place_id;
                    }

                    if (this.project.posts.length == 0) {
                        $("#bg-user").addClass("auto-height");
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        saveFormPostSales() {
            const fd = new FormData();

            fd.append("contract_id", this.project.projectable.id);
            fd.append("comunicationChanelId", this.comunicationChanelId);
            fd.append("mktSourceId", this.mktSourceId);
            fd.append("hireFactorId", this.hireFactorId);
            fd.append("contractModeId", this.contractModeId);
            fd.append("academicSituationId", this.academicSituationId);
            fd.append("professionalStatusId", this.professionalStatusId);
            fd.append("participationId", this.participationId);
            fd.append("studyPlaceId", this.studyPlaceId);

            axios
                .post("/api/form-sales-posts", fd)
                .then((result) => {
                    this.$swal("Formulario enviado correctamente");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getSelectsInfo() {
            axios
                .get("/api/selects-info")
                .then((result) => {
                    this.comunicationChanels = result.data.comunicationChanels;
                    this.mktSources = result.data.mktSources;
                    this.hireFactors = result.data.hireFactors;
                    this.contractModes = result.data.contractModes;
                    this.academicSituations = result.data.academicSituations;
                    this.professionalStatuses =
                        result.data.professionalStatuses;
                    this.participations = result.data.participations;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getProjectInfo();
        this.getSelectsInfo();
    },
};
</script>
<style scoped>
.auto-height {
    height: auto !important;
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
