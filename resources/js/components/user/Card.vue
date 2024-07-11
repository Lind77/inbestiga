<template>
    <div class="glass-card mx-2 pb-2">
        <img
            :src="imageUrl"
            alt=""
            srcset=""
            class="img-card cursor-pointer"
            @click="openModalVideo"
        />
        <p class="fw-normal text-center text-white mt-3 mb-3">{{ text }}</p>
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
            this.$emit("openVideoModal", this.link);
        },
    },
};
</script>
<style scoped>
.img-card {
    height: 19em;
    width: 100%;
    object-fit: cover;
    border-radius: 8px 8px 0px 0px;
    transition: 1s;
}

.img-card:hover {
    transition: 0.5s;
    opacity: 0.8;
}

.glass-card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 8px;

    padding: 0px;
}
</style>
