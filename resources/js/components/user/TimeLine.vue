<template>
    <div class="col-12 d-flex flex-column justify-content-center">
        <div
            class="d-flex flex-row justify-content-around text-white button-multiple py-2"
        >
            <div
                @click="openModalAcademic"
                class="d-flex flex-row justify-content-center align-items-center cursor-pointer"
            >
                Información <br />
                académica <i class="bx bx-book-open ms-3"></i>
            </div>
            <div
                @click="openModalFiles"
                class="d-flex flex-row justify-content-center align-items-center cursor-pointer"
            >
                Documentos <i class="bx bx-file ms-3"></i>
            </div>
            <div
                @click="toCalendly"
                class="d-flex flex-row justify-content-center align-items-center cursor-pointer"
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
    <FilesModal :files="files" />
</template>
<script>
import Post from "./Post.vue";
import FilesModal from "./FilesModal.vue";

export default {
    components: { Post, FilesModal },
    data() {
        return {
            files: [],
        };
    },
    props: {
        project: Object,
    },
    methods: {
        openModalFiles() {
            this.files = this.project.posts.filter((post) => post.files);
            $("#filesModal").modal("show");
        },
        openModalAcademic() {
            this.$emit("openModalAcademic");
        },
        openModalPost() {
            this.$emit("openModal");
        },
        toCalendly() {
            try {
                this.project.user.calendly_user
                    ? window.open(this.project.user.calendly_user)
                    : this.$swal("Este proyecto no ha sido asignado aun");
            } catch (e) {
                this.$swal("Este proyecto no ha sido asignado aun");
            }
        },
    },
};
</script>
<style scoped>
button {
    border: 1px solid #c908aa;
    color: #fff !important;
    font-weight: 500;
    background-color: rgba(255, 255, 255, 0); /* Color sólido inicial */
    transition: background-color 0.3s ease-in-out;
    position: relative;
    z-index: 1;
}

button::after {
    content: "";
    width: 100%;
    height: 100%;
    background: linear-gradient(
        25deg,
        rgba(244, 21, 217, 1) 0%,
        rgba(127, 33, 251, 1) 100%
    );
    position: absolute;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
    left: 0;
    top: 0;
    border-radius: 5px;
}

button:hover::after {
    opacity: 1;
}

.button-multiple {
    border: 1px solid #c908aa;
    border-radius: 5px;
    padding: 3px 5px 5px;
}

.separator-vertical {
    background-color: #c908aa;
    width: 1px;
}
</style>
