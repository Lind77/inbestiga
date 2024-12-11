<template>
    <div class="card invoice-preview-card">
        <div class="card-header">
            <span class="h5 mt-2 demo text-body fw-bold">Nuevo Post </span>
        </div>
        <div class="card-body">
            <input
                type="text"
                v-model="newUpdate.question"
                placeholder="Título"
                class="form-control"
            />
            <textarea
                placeholder="Cuerpo"
                v-model="newUpdate.answer"
                class="form-control mt-2"
                rows="5"
            ></textarea>
            <div class="mt-2">
                <button class="btn btn-info w-100" @click="postNewUpdate">
                    Publicar
                </button>
                <button
                    id="btnFilePost"
                    class="btn btn-secondary mt-2 w-100"
                    @click="chooseFile"
                >
                    Adjuntar archivo <i class="bx bx-paperclip"></i>
                </button>
                <input
                    type="file"
                    ref="inputHidden"
                    hidden
                    @change="archivePost"
                />
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            newUpdate: {
                question: "",
                answer: "",
                type: 0,
            },
            filePostUploaded: {},
        };
    },
    props: {
        projectId: Number,
    },
    methods: {
        chooseFile() {
            this.$refs.inputHidden.click();
        },
        archivePost(event) {
            var file = event.target.files[0];
            this.filePostUploaded = file;

            var reader = new FileReader();
            reader.onload = function (event) {
                // El texto del archivo se mostrará por consola aquí
                $("#btnFilePost").removeClass("btn-secondary");
                $("#btnFilePost").addClass("btn-success");
                $("#btnFilePost").html(file.name);
            };
            reader.readAsText(file);
        },
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
            fd.append("project_id", this.projectId);
            fd.append("postable_type", postable_type);
            fd.append("user_id", this.store.authUser.id);

            axios
                .post("/api/file-post", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((result) => {
                    this.$swal("Post publicado correctamente");
                    this.newUpdate.question = "";
                    this.newUpdate.answer = "";
                    this.filePostUploaded = {};
                    $("#btnFilePost").removeClass("btn-success");
                    $("#btnFilePost").addClass("btn-secondary");
                    $("#btnFilePost").html("Adjuntar archivo");
                    this.$emit("getQuotation");
                })
                .catch((err) => {
                    this.$swal("Hubo un error: " + err.message);
                });
        },
    },
};
</script>
<style lang=""></style>
