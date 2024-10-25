<template>
    <div class="card-container glass-card w-100 mt-5">
        <img
            :src="imageUrl"
            alt="icon-image"
            class="img-card cursor-pointer"
            @click="openModalVideo"
        />
        <p class="fw-bold text-center text-white mb-0 pb-4">
            {{ text }}
        </p>
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
    border-radius: 8px 8px 8px 8px;
    padding: 0px;
    position: relative;
    bottom: 73px;
    transition: 0.5s;
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.glass-card p {
    font-size: 15px;
}
</style>
