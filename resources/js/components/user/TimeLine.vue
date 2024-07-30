<template lang="">
    <div class="col-12 d-flex flex-column justify-content-center">
        <div
            class="d-flex justify-content-around text-white button-multiple py-2"
        >
            <div
                class="d-flex flex-row justify-content-center align-items-center"
            >
                Información <br />
                académica <i class="bx bx-book-open ms-3"></i>
            </div>
            <div
                class="d-flex flex-row justify-content-center align-items-center"
            >
                Agenda <br />
                tu reunión <i class="bx bx-video-plus ms-3"></i>
            </div>
        </div>

        <button class="btn bg-none w-100 mt-3" @click="openModalPost">
            Ingrese un nuevo post
            <i class="bx bx-plus"></i>
        </button>

        <Post v-for="post in project.posts" :post="post" class="mt-3" />
    </div>
</template>
<script>
import Post from "./Post.vue";

export default {
    components: { Post },
    props: {
        project: Object,
    },
    methods: {
        openModalPost() {
            this.$emit("openModal");
        },
    },
};
</script>
<style scoped>
button {
    border: 1px solid #c908aa;
    color: #fff !important;
    font-weight: 500;
}

.button-multiple {
    border: 1px solid #c908aa;
    border-radius: 5px;
    padding: 3px 5px 5px;
}
</style>
