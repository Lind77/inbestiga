<template>
    <div>
        <img
            :src="imageUrl"
            alt=""
            srcset=""
            width="190"
            height="188"
            class="cursor-pointer"
        />
    </div>
</template>
<script>
export default {
    props: {
        imageUrl: String,
    },
};
</script>
<style scoped>
img:hover {
    width: 150%;
    height: 150%;
    object-fit: cover;
    transition: 0.7s;
    margin-top: -3rem;
}
</style>
