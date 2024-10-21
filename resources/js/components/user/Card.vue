<template>
    <div class="card-container w-100">
        <img
            :src="imageUrl"
            alt=""
            srcset=""
            class="img-card cursor-pointer mb-4"
            @click="openModalVideo"
        />
        <div class="glass-card pb-2 w-100">
            <p class="fw-bold text-center text-white pt-1 mb-0">{{ text }}</p>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        imageUrl: String,
        text: String,
        link: String,
    },
    methods: {
        openModalVideo() {
            this.$emit("openModalVideo", this.link);
        },
    },
};
</script>
<style scoped>
.img-card {
    height: 19em;
    width: 100%;
    object-fit: cover;
    border-radius: 8px;
    transition: 1s;
    filter: brightness(0.5);
}

.img-card:hover {
    transition: 0.5s;
    filter: brightness(1);
}

.card-container:hover {
    transform: scale(1.2);
    transition: 0.5s;
}

.card-container:hover .glass-card {
    opacity: 1;
    transition: 0.5s;
}

.glass-card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 0px 0px 8px 8px;
    padding: 0px;
    position: relative;
    bottom: 73px;
    transition: 0.5s;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.glass-card p {
    font-size: 15px;
}
</style>
