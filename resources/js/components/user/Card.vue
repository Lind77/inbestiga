<template>
    <div class="glass-card">
        <img :src="imageUrl" alt="" srcset="" class="img-card cursor-pointer" />
        <p class="fw-semibold text-center text-white">{{ text }}</p>
    </div>
</template>
<script>
export default {
    props: {
        imageUrl: String,
        text: String,
    },
};
</script>
<style scoped>
.img-card {
    height: 22em;
    width: 14em;
    object-fit: cover;
    border-radius: 8px;
}

.glass-card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 8px;

    padding: 0px;
}
</style>
