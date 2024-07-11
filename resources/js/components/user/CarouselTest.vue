<template>
    <swiper
        :modules="modules"
        :breakpoints="{
            '0': {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            '768': {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            '1024': {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        }"
        :space-between="10"
        navigation
        delay
        :loop="true"
        :autoplay="{ delay: 2000 }"
        @swiper="onSwiper"
        @slideChange="onSlideChange"
    >
        <swiper-slide v-for="card in cards">
            <Card
                :imageUrl="card.imageUrl"
                :text="card.text"
                :link="card.link"
                @openVideoModal="openVideoModal"
        /></swiper-slide>
    </swiper>
    <VideoModal :videoSrc="linkSelected" />
</template>
<script>
import VideoModal from "./VideoModal.vue";
import Card from "./Card.vue";
// import Swiper core and required modules
import {
    Navigation,
    Pagination,
    Scrollbar,
    A11y,
    Autoplay,
} from "swiper/modules";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import "swiper/css/autoplay";

// Import Swiper styles
export default {
    components: {
        Swiper,
        SwiperSlide,
        Card,
        VideoModal,
        Autoplay,
    },
    setup() {
        const onSwiper = (swiper) => {
            console.log(swiper);
        };
        const onSlideChange = () => {
            console.log("slide change");
        };
        return {
            onSwiper,
            onSlideChange,
            modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay],
        };
    },
    data() {
        return {
            cards: [
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/1.png",
                    text: "Bienvenida",
                    link: "https://www.youtube.com/embed/P3H5DwGXUh8",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/2.png",
                    text: "Conoce el Aula virtual",
                    link: "https://www.youtube.com/embed/6Me92Ga7SfI",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/3.png",
                    text: "Lee con atención tu contrato",
                    link: "https://www.youtube.com/embed/_kmmTqjIOtQ",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/4.png",
                    text: "Horario de atención",
                    link: "https://www.youtube.com/embed/fff_oGT3wvg",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/5.png",
                    text: "Acerca de las reuniones",
                    link: "https://www.youtube.com/embed/O1h-PK20vcM",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/6.png",
                    text: "Acerca de los archivos requeridos",
                    link: "https://www.youtube.com/embed/dOHOa2XGJ4M",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/7.png",
                    text: "Descargar archivos",
                    link: "https://www.youtube.com/embed/TF_TKaFo8NM",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/8.png",
                    text: "⁠Validación de pagos para descargas",
                    link: "https://www.youtube.com/embed/zPGjQkIJ_M0",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/9.png",
                    text: "⁠Plazo de levantamiento de observaciones",
                    link: "https://www.youtube.com/embed/upDmBlrd1is",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/10.png",
                    text: "Si necesitas tus observaciones en menos tiempo",
                    link: "https://www.youtube.com/embed/758Y_RGou7Y",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/11.png",
                    text: "Observaciones de revisores universitarios",
                    link: "https://www.youtube.com/embed/42eepglyqGI",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/12.png",
                    text: "Informe de levantamiento de observaciones",
                    link: "https://www.youtube.com/embed/uN6UrUNGwk0",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/13.png",
                    text: "Sugerencia antes de reunirte con tu asesor",
                    link: "https://www.youtube.com/embed/DR9ZJ53uqO8",
                },
            ],
            linkSelected: "",
        };
    },
    methods: {
        openVideoModal(link) {
            this.linkSelected = link;
            $("#videoModal").modal("show");
        },
    },
};
</script>
