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
                            class="main-text-bold subtext text-white text-center mt-4"
                        >
                            {{
                                topics[parseInt($route.params.categoryId) - 1]
                                    .title
                            }}
                        </h2>
                        <!-- <h3 class="mx-auto text-white mt-4 fw-normal">
                            ¡Tienes a tu disposición recursos diseñados
                            especialmente para ti!
                        </h3> -->
                    </div>
                </div>
                <div
                    class="col-12 col-lg-6 mt-3 mb-3 pb-5"
                    v-for="video in videosFiltered"
                >
                    <div class="glass">
                        <div class="row">
                            <div class="col-3">
                                <img
                                    :src="video.imgUrl"
                                    alt=""
                                    class="video__image"
                                />
                            </div>
                            <div class="col-9">
                                <h5 class="text-white fw-bold mt-4">
                                    {{ video.text }}
                                </h5>
                                <button
                                    class="btn btn-primary"
                                    @click="openVideoModal(video.srcVideo)"
                                >
                                    <i class="bx bx-play-circle"></i>
                                    Ver ahora
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  <Card
                        :text="video.text"
                        :imageUrl="'https://inbestiga.com/inbestiga/public/img/video-layers/2.png'"
                        
                    /> -->
                    <!--  <div class="card glass p-4 my-2 cursor-pointer">
                        <h3 class="text-white">{{ topic }}</h3>
                    </div> -->
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
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/2.png",
                    srcVideo: "https://player.vimeo.com/video/1015724185",
                    text: "¿Qué beneficios tengo al usar el aula virtual?",
                    type: 1,
                },
                {
                    id: 2,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/3.png",
                    srcVideo: "https://player.vimeo.com/video/1015724224",
                    text: "¿Qué sucede si mi asesor universitario rechaza el tema propuesto?",
                    type: 1,
                },
                {
                    id: 3,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/4.png",
                    srcVideo: "https://player.vimeo.com/video/1015723450",
                    text: "¿Hasta cuándo me ayudarán con las observaciones?",
                    type: 1,
                },
                {
                    id: 4,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/5.png",
                    srcVideo: "https://player.vimeo.com/video/1015724151",
                    text: "¿Qué recursos me brindan para ayudarme en la defensa de mi tesis?",
                    type: 1,
                },
                {
                    id: 5,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/6.png",
                    srcVideo: "https://player.vimeo.com/video/1015723836",
                    text: "¿Cuándo se agenda la primera reunión y por qué es importante?",
                    type: 2,
                },
                {
                    id: 6,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/7.png",
                    srcVideo: "https://player.vimeo.com/video/1015724016",
                    text: "¿Cómo puedo conocer el progreso de mi proyecto y recibir los documentos?",
                    type: 2,
                },
                {
                    id: 7,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/8.png",
                    srcVideo: "https://player.vimeo.com/video/1015724063",
                    text: "¿Cuánto tiempo tardan el levantar una observación?",
                    type: 2,
                },
                {
                    id: 8,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/9.png",
                    srcVideo: "https://player.vimeo.com/video/1015724105",
                    text: "¿Qué debo hacer después de que mis jurados aprueben mi tesis?",
                    type: 2,
                },
                {
                    id: 9,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/10.png",
                    srcVideo: "https://player.vimeo.com/video/1015723802",
                    text: "¿Puedo elegir si mis reuniones serán presenciales o virtuales?",
                    type: 3,
                },
                {
                    id: 10,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/11.png",
                    srcVideo: "https://player.vimeo.com/video/1015723761",
                    text: "¿Cómo puedo resolver mis dudas sobre mi proyecto?",
                    type: 3,
                },
                {
                    id: 11,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/12.png",
                    srcVideo: "https://player.vimeo.com/video/1015723725",
                    text: "¿Es posible realizar mi pago personalmente en la oficina?",
                    type: 4,
                },
                {
                    id: 12,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/13.png",
                    srcVideo: "https://player.vimeo.com/video/1015723641",
                    text: "¿Es posible revisar mi proyecto antes de realizar el pago?",
                    type: 4,
                },
                {
                    id: 13,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/14.png",
                    srcVideo: "https://player.vimeo.com/video/1015723685",
                    text: "¿Hasta cuándo es el acompañamiento una vez realizado el último pago?",
                    type: 4,
                },
                {
                    id: 14,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/15.png",
                    srcVideo: "https://player.vimeo.com/video/1015723541",
                    text: "¿Cuál es mi compromiso como usuario durante el proceso?",
                    type: 5,
                },
                {
                    id: 15,
                    imgUrl: "https://inbestiga.com/inbestiga/public/img/video-layers/16.png",
                    srcVideo: "https://player.vimeo.com/video/1015723597",
                    text: "¿Qué actitud debo tener si surgen obstáculos?",
                    type: 5,
                },
            ],
            topics: [
                { id: 1, title: "Mis beneficios" },
                { id: 2, title: "Progreso académico" },
                { id: 3, title: "Comunícate con nosotros" },
                { id: 4, title: "Mi inversión y pagos" },
                { id: 5, title: "Mi compromiso" },
            ],
        };
    },
    methods: {
        openVideoModal(videoSrc) {
            this.srcVideoSelected = videoSrc;
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
    computed: {
        videosFiltered: function () {
            return this.videoList.filter(
                (video) => video.type == this.$route.params.categoryId
            );
        },
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

    padding: 0px 0px;
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

.video__image {
    width: 95%;
    margin: 0px auto;
    border-radius: 5px 0px 0px 5px;
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
        margin: 1.4em auto;
    }

    .project-section {
        margin-top: -80% !important;
    }
}
</style>
