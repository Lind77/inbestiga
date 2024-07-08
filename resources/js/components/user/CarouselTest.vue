<template>
    <swiper
        :modules="modules"
        :slides-per-view="3"
        :space-between="10"
        navigation
        :loop="true"
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
import { Navigation, Pagination, Scrollbar, A11y } from "swiper/modules";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/scrollbar";

// Import Swiper styles
export default {
    components: {
        Swiper,
        SwiperSlide,
        Card,
        VideoModal,
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
            modules: [Navigation, Pagination, Scrollbar, A11y],
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
                    text: "Canal oficial de comunicación",
                    link: "https://www.youtube.com/embed/6Me92Ga7SfI",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/3.png",
                    text: "Leer con atención el contrato",
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
                    text: "Reuniones cuando se requiera",
                    link: "https://www.youtube.com/embed/O1h-PK20vcM",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/6.png",
                    text: "Todos los archivos deben ser enviados a través del formulario",
                    link: "https://www.youtube.com/embed/dOHOa2XGJ4M",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/7.png",
                    text: "Trabajos serán descargados a través del aula",
                    link: "https://www.youtube.com/embed/TF_TKaFo8NM",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/8.png",
                    text: "Toda descarga de archivos es validada primero por el pago",
                    link: "https://www.youtube.com/embed/zPGjQkIJ_M0",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/9.png",
                    text: "Levantamiento de observaciones tiene un plazo de 7 días hábiles ",
                    link: "https://www.youtube.com/embed/upDmBlrd1is",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/10.png",
                    text: "Si necesitas en menos tiempo, agenda una reunión y coméntalo allí ",
                    link: "https://www.youtube.com/embed/758Y_RGou7Y",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/11.png",
                    text: "Solo se levantan observaciones de revisores académicos de la universidad ",
                    link: "https://www.youtube.com/embed/42eepglyqGI",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/12.png",
                    text: "Se te anexará un informe de levantamiento de observaciones para verificar los cambios ",
                    link: "https://www.youtube.com/embed/uN6UrUNGwk0",
                },
                {
                    imageUrl:
                        "https://inbestiga.com/inbestiga/public/img/13.png",
                    text: "Antes de reunirte con tu asesor, revisa el documento a detalle",
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
