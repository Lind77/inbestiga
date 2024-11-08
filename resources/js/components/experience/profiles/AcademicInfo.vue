<template>
    <div class="card invoice-preview-card mt-2">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="h5 my-2 demo text-body fw-bold"
                        >Información Académica
                    </span>
                </div>
                <div>
                    <!-- <span
                        v-if="customer.user"
                        class="bg-info rounded w-auto p-2 text-white fw-bold"
                    >
                        <i class="bx bx-user-pin"></i>
                        {{ customer.user.name }}
                    </span> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md mb-md-0 mb-2">
                    <div class="form-check custom-option custom-option-icon">
                        <label
                            class="form-check-label custom-option-content"
                            for="customRadioBuilder"
                        >
                            <span class="custom-option-body">
                                <i class="bx bx-building-house"></i>
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
                    <div class="form-check custom-option custom-option-icon">
                        <label
                            class="form-check-label custom-option-content"
                            for="customRadioOwner"
                        >
                            <span class="custom-option-body">
                                <i class="bx bx-crown"></i>
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
                    <div class="form-check custom-option custom-option-icon">
                        <label
                            class="form-check-label custom-option-content"
                            for="customRadioBroker"
                        >
                            <span class="custom-option-body">
                                <i class="bx bx-briefcase-alt"></i>
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
                    <div class="form-check custom-option custom-option-icon">
                        <label
                            class="form-check-label custom-option-content"
                            for="customRadioBroker"
                        >
                            <span class="custom-option-body">
                                <i class="bx bx-briefcase-alt"></i>
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
            <div class="row mt-2">
                <div class="col-12">
                    <template v-for="newQuestion in newQuestions">
                        <template v-if="newQuestion.type == 4">
                            <div class="d-flex mb-2">
                                <label
                                    class="form-check-label"
                                    for="flexSwitchCheckDefault"
                                    >{{ newQuestion.question }}</label
                                >
                                <div class="form-check form-switch ps-5">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="flexSwitchCheckDefault"
                                        v-model="newQuestion.answer"
                                    />
                                </div>
                            </div>
                        </template>
                        <template v-if="newQuestion.type == 3">
                            <p class="mb-1">
                                {{ newQuestion.question }}
                            </p>
                            <textarea
                                v-model="newQuestion.answer"
                                class="form-control mb-4"
                            ></textarea>
                        </template>
                        <template v-if="newQuestion.type == 6">
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
                        </template>
                    </template>
                    <button
                        v-if="typeQuiz == 0"
                        class="btn btn-success w-100 mt-2"
                        @click="saveFields"
                    >
                        Insertar
                    </button>
                    <button
                        v-else
                        class="btn btn-success w-100 mt-2"
                        @click="saveFields"
                    >
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        academicType: Number,
        newQuestions: Array,
        propertiableId: Number,
        documentaryTags: Array,
    },
    data() {
        return {
            typeQuiz: 0,
            questions: this.newQuestions,
        };
    },
    methods: {
        saveFields() {
            const fd = new FormData();

            fd.append("propertiable_id", this.propertiableId);
            fd.append("propertiable_type", "App\\Models\\Contract");
            fd.append("properties", JSON.stringify(this.newQuestions));
            fd.append("project_situation_id", this.typeQuiz);
            fd.append(
                "documentary_processing",
                JSON.stringify(this.documentaryTags)
            );

            axios
                .post("/api/properties", fd)
                .then((result) => {
                    this.$swal(
                        "Documentación de proyecto almacenada correctamente"
                    );
                })
                .catch((err) => {
                    this.$swal("Hubo un error");
                });
        },
        updateFields() {
            const fd = new FormData();

            fd.append("propertiable_id", this.selectedDoc.propertiable_id);
            fd.append("propertiable_type", this.selectedDoc.propertiable_type);
            fd.append("properties", JSON.stringify(this.newQuestions));
            fd.append(
                "documentary_processing",
                JSON.stringify(this.documentaryTags)
            );
            fd.append("project_situation_id", this.typeQuiz);
            fd.append("_method", "put");

            axios
                .post("/api/properties", fd)
                .then((result) => {
                    this.newUpdate = {
                        question: "",
                        answer: "",
                        type: 0,
                    };
                    this.$swal(
                        "Documentación de proyecto actualizada correctamente"
                    );
                })
                .catch((err) => {
                    this.$swal("Hubo un error");
                });
        },
    },
    watch: {
        academicType(val) {
            this.typeQuiz = val;
        },
    },
};
</script>
<style lang=""></style>
