<template>
    <div
        class="d-flex flex-row justify-content-around align-items-center w-100 mt-5"
    >
        <i class="bx bx-chevron-left fw-light" @click="moveBackCarousel"></i>
        <Card
            :imageUrl="card.imageUrl"
            :text="card.text"
            v-for="card in cards"
        />
        <i
            class="bx bx-chevron-right fw-light"
            @click="moveForewardCarousel"
        ></i>
    </div>
</template>
<script>
import Card from "./Card.vue";

export default {
    components: { Card },
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
    methods: {
        moveBackCarousel() {
            this.cards.push(this.cards.shift());
        },
        moveForewardCarousel() {
            this.cards.unshift(this.cards.pop());
        },
    },
};
</script>
<style scoped>
i {
    color: #fff;
    font-size: 6em;
}

.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s;
}

.slide-enter,
.slide-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

.slide-enter-to,
.slide-leave {
    opacity: 1;
    transform: translateX(0);
}
</style>
