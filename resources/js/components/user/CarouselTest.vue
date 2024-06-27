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
            <Card :imageUrl="card.imageUrl" :text="card.text"
        /></swiper-slide>
    </swiper>
</template>
<script>
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
                        "https://i.pinimg.com/564x/63/a7/05/63a7058d7ab2fc4dbfe9540960b96aa2.jpg",
                    text: "Comienza tu tesis",
                },
                {
                    imageUrl:
                        "https://i.pinimg.com/564x/dd/d1/8a/ddd18a24e555b6b976810ca407dbcc7b.jpg",
                    text: "Informes",
                },
                {
                    imageUrl:
                        "https://i.pinimg.com/564x/ab/d6/a1/abd6a1374a9bff8b84f107c9e944ea39.jpg",
                    text: "Canal oficial",
                },
                {
                    imageUrl:
                        "https://i.pinimg.com/736x/0f/f8/c6/0ff8c6d78cc203314698f3d660de989a.jpg",
                    text: "Reuniones infinitas",
                },
            ],
        };
    },
};
</script>
