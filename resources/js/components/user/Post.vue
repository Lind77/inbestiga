<template>
    <div class="d-flex align-items-center">
        <img
            src="https://inbestiga.com/inbestiga/public/img/circle-card.png"
            alt="Avatar"
            class="rounded-circle"
        />
        <div class="ps-3 w-100">
            <p class="mb-0">{{ formatDate(post.created_at) }}</p>
            <div class="card glass p-2" v-if="post && post.postable">
                <h5 class="text-white fw-bold">{{ post.postable.name }}</h5>
                <p class="text-white fw-normal pt-2 mb-0">{{ post.title }}</p>
                <p class="text-white fst-italic">{{ post.body }}</p>
                <button
                    @click="downloadFile(post.files[0].url)"
                    class="btn btn-primary w-50 mx-auto mb-3"
                    v-if="post.files[0]"
                >
                    {{ post.files[0].url }}
                </button>
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
        downloadFile(url) {
            window.open("https://inbestiga.com/inbestiga/public/files/" + url);
        },
    },
};
</script>
<style scoped>
img {
    width: 3rem;
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
