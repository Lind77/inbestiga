<template>
    <div class="d-flex">
        <div class="col-2 justify-content-center align-items-center">
            <img
                src="https://inbestiga.com/inbestiga/public/img/circle-card.png"
                alt="Avatar"
                class="rounded-circle w-50"
            />
            <div class="vl"></div>
        </div>
        <div class="col-10">
            <p class="mb-0">{{ formatDate(post.created_at) }}</p>
            <div class="card glass p-2">
                {{ post }}
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";

export default {
    props: {
        post: Object,
    },
    methods: {
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY HH:mm:ss a");
        },
    },
};
</script>
<style scoped>
img {
    z-index: 2;
    margin-top: 50%;
}
.vl {
    border-left: 3px solid #979697;
    height: 125px;
    z-index: 1;
    margin: 0px 0px 0px 40%;
    text-align: center;
}

.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}
</style>
