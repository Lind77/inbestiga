<template>
    <div class="bg-user pt-5">
        <div class="container">
            <Navbar />
            <div class="row">
                <div class="col-12">
                    <div
                        class="main d-flex justify-content-center flex-column mt-5"
                    >
                        <h2
                            class="main-text subtext text-white text-center mt-4"
                        >
                            Mi
                            <span class="main-text-bold">Experiencia</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6" v-for="video in videoList">
                    <Card
                        :text="video.text"
                        :imageUrl="'https://inbestiga.com/inbestiga/public/img/valeCard.jpg'"
                        @openModalVideo="openModalVideo(video.srcVideo)"
                    />
                </div>
            </div>
        </div>
    </div>
    <VideoModal :videoSrc="srcVideoSelected" />
</template>
<script>
import moment from "moment";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import Card from "./Card.vue";
import ProjectCard from "./ProjectCard.vue";
import Carousel from "./Carousel.vue";
import CarouselTest from "./CarouselTest.vue";
import VideoModal from "./VideoModal.vue";

import { userStore } from "../../stores/UserStore";

export default {
    components: {
        Sidebar,
        Navbar,
        Card,
        ProjectCard,
        Carousel,
        CarouselTest,
        VideoModal,
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
            srcVideoSelected: "",
            videoList: [
                {
                    id: 1,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724224",
                    text: "¿Qué sucede si mi asesor universitario rechaza el tema propuesto?",
                },
                {
                    id: 2,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724185",
                    text: "¿Qué beneficios tengo al usar el aula virtual?",
                },
                {
                    id: 3,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724151",
                    text: "¿Qué recursos me brindan para ayudarme en la defensa de mi tesis?",
                },
                {
                    id: 4,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724105",
                    text: "¿Qué debo hacer después de que mis jurados aprueben mi tesis?",
                },
                {
                    id: 5,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724063",
                    text: "¿Cuanto tiempo tardan el levantar una observación?",
                },
                {
                    id: 6,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015724016",
                    text: "¿Cómo puedo conocer el progreso de mi proyecto y recibir los documentos?",
                },
                {
                    id: 7,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723836",
                    text: "¿Cuándo se agenda la primera reunión y por qué es importante?",
                },
                {
                    id: 8,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723802",
                    text: "¿Puedo elegir entre reuniones presenciales o virtuales?",
                },
                {
                    id: 9,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723761",
                    text: "¿Cómo puedo resolver mis dudas sobre mi proyecto?",
                },
                {
                    id: 10,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723725",
                    text: "¿Es posible realizar mi pago personalmente en la oficina?",
                },
                {
                    id: 11,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723685",
                    text: "¿Hasta cuándo es el acompañamiento una vez realizado el último pago?",
                },
                {
                    id: 12,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723641",
                    text: "¿Es posible revisar mi proyecto antes de realizar el pago?",
                },
                {
                    id: 13,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723597",
                    text: "¿Qué actitud debo tener si surgen obstáculos?",
                },
                {
                    id: 14,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723541",
                    text: "¿Cuál es mi compromiso como usuario durante el proceso?",
                },
                {
                    id: 15,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723497",
                    text: "Bienvenido a inbestiga",
                },
                {
                    id: 16,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/valeCard.jpg",
                    srcVideo: "https://player.vimeo.com/video/1015723450",
                    text: "¿Hasta cuándo me ayudarán con las observaciones?",
                },
            ],
        };
    },
    methods: {
        openModalVideo(srcVideo) {
            this.srcVideoSelected = srcVideo;
            $("#videoModal").modal("show");
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
        getUserInfo() {
            axios
                .get("/api/customer-by-id/" + this.$route.params.customerId)
                .then((result) => {
                    this.info = result.data;
                    this.quotations = result.data.quotations;
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
        //this.getUserInfo();
    },
};
</script>
<style scoped>
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
</style>
