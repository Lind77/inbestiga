<template>
    <div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-body">
                    <label for="" class="text-white fw-bold"
                        >Ingrese nuevo post</label
                    >
                    <input
                        type="text"
                        v-model="newUpdate.question"
                        placeholder="Ingrese un título para el post"
                        class="form-control"
                    />
                    <textarea
                        placeholder="Ingrese alguna descripción de post"
                        v-model="newUpdate.answer"
                        class="form-control mt-2"
                        rows="5"
                    ></textarea>
                    <div
                        class="d-flex justify-content-center align-items-center mt-2"
                    >
                        <button
                            id="btnFilePost"
                            class="btn btn-secondary w-50"
                            @click="chooseFile"
                        >
                            <i class="bx bxs-cloud-upload"></i>
                            Archivo
                        </button>
                        <input
                            type="file"
                            ref="inputHidden"
                            hidden
                            @change="archivePost"
                            accept=".doc,.docx,.xls,.xlsx,.pdf"
                        />
                        <button
                            class="btn btn-info ms-2 w-50"
                            @click="postNewUpdate"
                        >
                            Enviar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../../stores/UserStore";
export default {
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            newUpdate: {
                question: "",
                answer: "",
                type: 0,
            },
        };
    },
    props: {
        project: Object,
    },
    methods: {
        postNewUpdate() {
            if (this.store.authUser.subarea) {
                var postable_type = "App\\Models\\User";
            } else {
                var postable_type = "App\\Models\\Customer";
            }

            const fd = new FormData();
            fd.append("title", this.newUpdate.question);
            fd.append("body", this.newUpdate.answer);
            fd.append("file", this.filePostUploaded);
            fd.append("project_id", this.project.id);
            fd.append("postable_type", postable_type);
            fd.append("user_id", this.store.authUser.id);

            axios
                .post("/api/file-post", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((result) => {
                    $("#postModal").modal("hide");
                    this.$swal("Post publicado correctamente");
                    this.newUpdate.question = "";
                    this.newUpdate.answer = "";
                    this.filePostUploaded = {};
                    $("#btnFilePost").removeClass("btn-success");
                    $("#btnFilePost").addClass("btn-secondary");
                    $("#btnFilePost").html("Adjuntar archivo");
                    this.$emit("getProjectInfo");
                })
                .catch((err) => {
                    this.$swal("Error");
                    console.log(err);
                });
        },
        archivePost(event) {
            var file = event.target.files[0];
            this.filePostUploaded = file;

            var size = this.formatBytes(file.size);

            var reader = new FileReader();
            reader.onload = function (event) {
                // El texto del archivo se mostrará por consola aquí
                $("#btnFilePost").removeClass("btn-secondary");
                $("#btnFilePost").addClass("btn-success");
                $("#btnFilePost").html(file.name + " - " + size);
            };
            reader.readAsText(file);
        },
        formatBytes(bytes) {
            const units = ["Bytes", "KB", "MB", "GB", "TB"];

            if (bytes === 0) return "0 Bytes";

            const index = Math.floor(Math.log(bytes) / Math.log(1024));
            const formattedSize = (bytes / Math.pow(1024, index)).toFixed(2);

            return `${formattedSize} ${units[index]}`;
        },
        chooseFile() {
            this.$refs.inputHidden.click();
        },
    },
};
</script>
<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}

input[type="text"],
textarea {
    background: none !important;
    color: #fff !important;
}
</style>
