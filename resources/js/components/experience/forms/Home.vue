<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center">
            <h4 class="fw-bold mb-0 me-2">Formularios test</h4>
            <button class="btn btn-icon btn-primary" @click="showNameInput">
                <i class="bx bx-plus"></i>
            </button>
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
                    class="btn btn-primary w-100"
                    v-for="(form, index) in allForms"
                    :key="index"
                >
                    {{ form.title }}
                </button>
            </div>
            <div class="col-8">
                <div class="card w-100">
                    <div class="card-header">Tipos de Forms</div>
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
            nameForm: "",
            form: {},
        };
    },
    methods: {
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
    },
};
</script>
<style lang=""></style>
