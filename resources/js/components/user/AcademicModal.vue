<template>
    <div class="modal fade" id="academicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-body">
                    <label for="" class="text-white fw-bold"
                        >Información académica</label
                    >
                    <div class="row">
                        <div class="col-md mb-md-0 mb-2">
                            <div
                                class="form-check custom-option custom-option-icon"
                            >
                                <label
                                    class="form-check-label custom-option-content"
                                    for="customRadioBuilder"
                                >
                                    <span class="custom-option-body">
                                        <span class="custom-option-title"
                                            >T. sin avance</span
                                        >
                                    </span>
                                    <input
                                        name="plUserType"
                                        class="form-check-input"
                                        type="radio"
                                        value="1"
                                        id="customRadioBuilder"
                                        v-model="typeQuiz"
                                    />
                                </label>
                            </div>
                        </div>
                        <div class="col-md mb-md-0 mb-2">
                            <div
                                class="form-check custom-option custom-option-icon"
                            >
                                <label
                                    class="form-check-label custom-option-content"
                                    for="customRadioOwner"
                                >
                                    <span class="custom-option-body">
                                        <span class="custom-option-title">
                                            T. con avance
                                        </span>
                                    </span>
                                    <input
                                        name="plUserType"
                                        class="form-check-input"
                                        type="radio"
                                        value="2"
                                        id="customRadioOwner"
                                        v-model="typeQuiz"
                                    />
                                </label>
                            </div>
                        </div>
                        <div class="col-md mb-md-0 mb-2">
                            <div
                                class="form-check custom-option custom-option-icon"
                            >
                                <label
                                    class="form-check-label custom-option-content"
                                    for="customRadioBroker"
                                >
                                    <span class="custom-option-body">
                                        <span class="custom-option-title">
                                            Art. Científico
                                        </span>
                                    </span>
                                    <input
                                        name="plUserType"
                                        class="form-check-input"
                                        type="radio"
                                        value="3"
                                        id="customRadioBroker"
                                        v-model="typeQuiz"
                                    />
                                </label>
                            </div>
                        </div>
                        <div class="col-md mb-md-0 mb-2">
                            <div
                                class="form-check custom-option custom-option-icon"
                            >
                                <label
                                    class="form-check-label custom-option-content"
                                    for="customRadioBroker"
                                >
                                    <span class="custom-option-body">
                                        <span class="custom-option-title">
                                            Otra modalidad
                                        </span>
                                    </span>
                                    <input
                                        name="plUserType"
                                        class="form-check-input"
                                        type="radio"
                                        value="4"
                                        id="customRadioBroker"
                                        v-model="typeQuiz"
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 text-white">
                        <div
                            class="col-12"
                            v-if="
                                project &&
                                project.projectable &&
                                project.projectable.properties[0] &&
                                project.projectable.properties[0].properties
                            "
                        >
                            <div
                                v-for="newQuestion in JSON.parse(
                                    project.projectable.properties[0].properties
                                )"
                            >
                                <div v-if="newQuestion.type == 4">
                                    <div class="d-flex mb-2">
                                        <label
                                            class="form-check-label"
                                            for="flexSwitchCheckDefault"
                                            >{{ newQuestion.question }}</label
                                        >
                                        <div
                                            class="form-check form-switch ps-5"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="flexSwitchCheckDefault"
                                                v-model="newQuestion.answer"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div v-if="newQuestion.type == 3">
                                    <p class="mb-1">
                                        {{ newQuestion.question }}
                                    </p>
                                    <textarea
                                        v-model="newQuestion.answer"
                                        class="form-control mb-4"
                                    ></textarea>
                                </div>
                                <div v-if="newQuestion.type == 6">
                                    <div class="col-12 px-1">
                                        <p class="mb-1">
                                            {{ newQuestion.question }}
                                        </p>
                                        <select
                                            v-model="newQuestion.answer"
                                            class="form-select"
                                        >
                                            <option
                                                :value="`${index + 1}`"
                                                v-for="(
                                                    option, index
                                                ) in newQuestion.options"
                                            >
                                                {{ option }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button
                                    v-if="typeQuiz == 0"
                                    class="btn btn-gradient w-100 mt-2"
                                    @click="saveFields"
                                >
                                    Insertar
                                </button>
                                <button
                                    v-else
                                    class="btn btn-gradient w-25 mt-2"
                                    @click="saveFields"
                                >
                                    Actualizar
                                </button>
                            </div>
                        </div>
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
    props: {
        project: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            newUpdate: {
                question: "",
                answer: "",
                type: 0,
            },
            actualProject: {},
            typeQuiz: 0,
        };
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
                    this.getQuotation();
                })
                .catch((err) => {
                    console.log(err);
                });
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
        chooseFile() {
            this.$refs.inputHidden.click();
        },
    },
    watch: {
        project(val) {
            this.actualProject = val;
            this.typeQuiz =
                this.actualProject.projectable.properties[0].project_situation_id;
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

.custom-option-title {
    color: #fff;
}

input[type="text"],
select,
textarea {
    background: none !important;
    color: #fff !important;
}

.btn-gradient {
    background: linear-gradient(
        22deg,
        rgba(251, 21, 215, 1) 0%,
        rgba(127, 33, 251, 1) 73%
    );
    border: none;
    color: #fff;
    margin: 0px auto;
}
</style>
