<template>
    <div
        class="bs-toast toast toast-placement-ex position-fixed bg-primary top-0 end-0 m-4"
        id="toastPost"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        @click="toProject"
    >
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Nuevo Post</div>
            <small>hace unos instantes</small>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>
        </div>
        <div class="toast-body" v-if="post && post.postable">
            <span class="fw-bold">{{ post.postable.name }}</span> ha subido un
            nuevo post en la timeline de su proyecto.
        </div>
    </div>
</template>
<script>
export default {
    props: {
        post: Object,
    },
    methods: {
        toProject() {
            this.$router.push({
                name: "home-documentation",
                params: {
                    quotationId: this.post.project.projectable.quotationId,
                },
            });
        },
    },
};
</script>
