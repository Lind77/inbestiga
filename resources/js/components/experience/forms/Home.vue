<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center">
            <h4 class="fw-bold mb-0 me-2">Formularios</h4>
        </div>
        <div class="row mt-2">
            <div class="col-4">
                <input
                    type="text"
                    v-model="nameForm"
                    class="form-control"
                    @keyup.enter="setNameForm"
                    v-show="nameInput"
                />
                <button
                    @click="selectForm(form)"
                    class="btn btn-primary w-100"
                    v-for="(form, index) in allForms"
                    :key="index"
                >
                    {{ form.name }}
                </button>
            </div>
            <div class="col-8">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="demo-inline-spacing">
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="addFieldForm(3)"
                                >
                                    Texto
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-success"
                                    @click="addFieldForm(6)"
                                >
                                    Seleccionable
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-warning"
                                    @click="addFieldForm(4)"
                                >
                                    Bicondicional
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 @click="editNameForm" v-show="!showInput">
                            {{ nameForm }}
                        </h4>
                        <input
                            type="text"
                            class="form-control w-auto"
                            v-show="showInput"
                            @blur="closeEditNameForm"
                            ref="nameInputRef"
                        />

                        <template v-for="newQuestion in questions">
                            <template v-if="newQuestion.type == 4">
                                <div class="d-flex align-items-center my-2">
                                    <input
                                        type="text"
                                        name=""
                                        id=""
                                        class="form-control"
                                    />
                                    <div class="form-check form-switch ps-5">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="flexSwitchCheckDefault"
                                            v-model="newQuestion.answer"
                                        />
                                    </div>
                                    <button
                                        class="btn btn-icon btn-danger ms-2"
                                        @click="deleteQuestion(newQuestion)"
                                    >
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </template>

                            <template v-if="newQuestion.type == 3">
                                <div class="d-flex">
                                    <input
                                        type="text"
                                        v-model="newQuestion.question"
                                        class="form-control"
                                        placeholder="Por favor escriba su pregunta"
                                    />
                                    <button
                                        class="btn btn-icon btn-danger ms-2"
                                        @click="deleteQuestion(newQuestion)"
                                    >
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>

                                <textarea
                                    disabled
                                    v-model="newQuestion.answer"
                                    class="form-control my-2"
                                ></textarea>
                            </template>

                            <template v-if="newQuestion.type == 6">
                                <div class="d-flex">
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
                                    <input
                                        type="text"
                                        name=""
                                        id=""
                                        class="form-control ms-2"
                                    />

                                    <button
                                        class="btn btn-icon btn-success ms-2"
                                    >
                                        <i
                                            class="bx bx-check"
                                            @click="
                                                addSelection(newQuestion.id)
                                            "
                                        ></i>
                                    </button>
                                    <button
                                        class="btn btn-icon btn-danger ms-2"
                                    >
                                        <i
                                            class="bx bx-trash"
                                            @click="deleteQuestion(newQuestion)"
                                        ></i>
                                    </button>
                                </div>
                            </template>
                        </template>
                        <div class="my-4">
                            <button class="btn btn-success" @click="saveForm">
                                Guardar Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            allForms: [],
            nameInput: false,
            nameForm: "Nombre del Form",
            questions: [],
            showInput: false,
        };
    },
    methods: {
        selectForm(form) {
            console.log("nani");
            this.questions = JSON.parse(form.forms);
        },
        closeEditNameForm() {
            this.nameForm = this.$refs.nameInputRef.value;
            this.showInput = false;
        },
        editNameForm() {
            this.showInput = true;
            this.$nextTick(() => {
                this.$refs.nameInputRef.focus();
            });
        },
        getForms() {
            axios
                .get("/api/forms")
                .then((result) => {
                    this.allForms = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        showNameInput() {
            this.nameInput = true;
            console.log(this.$refs);
        },
        setNameForm() {
            const fd = new FormData();

            fd.append("name", this.nameForm);
            fd.append(JSON.stringify(this.form));

            axios
                .post("/api/forms", fd)
                .then((result) => {})
                .catch((err) => {
                    console.log(err);
                });
        },
        addFieldForm(typeQuestion) {
            var typeQuestions = {
                3: {
                    id: this.questions.length + 1,
                    question: "",
                    answer: "",
                    type: typeQuestion,
                },
                6: {
                    id: this.questions.length + 1,
                    question: "",
                    options: [],
                    type: typeQuestion,
                },
                4: {
                    id: this.questions.length + 1,
                    question: "",
                    answer: false,
                    type: typeQuestion,
                },
            };

            this.questions.push(typeQuestions[typeQuestion]);
        },
        deleteQuestion(question) {
            this.questions.splice(this.questions.indexOf(question), 1);
        },
        saveForm() {
            const fd = new FormData();

            fd.append("name", this.nameForm);
            fd.append("questions", JSON.stringify(this.questions));

            axios
                .post("/api/forms", fd)
                .then((result) => {
                    this.getForms();
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    mounted() {
        this.getForms();
    },
};
</script>
<style lang=""></style>
