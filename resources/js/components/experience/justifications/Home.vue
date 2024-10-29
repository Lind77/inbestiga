<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Justificaciones</h4>
        <div class="row">
            <div class="col-4" v-for="justification in justifications">
                <div class="card mb-3">
                    <div class="card-header">
                        <h6>{{ justification.user.name }}</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ justification.miss_date }}</p>
                        {{ justification.reason }}
                    </div>
                    <div class="card-footer">
                        <button
                            @click="toFile(file)"
                            class="btn btn-icon btn-success"
                            v-for="file in justification.files"
                        >
                            <i class="bx bx-file"></i>
                        </button>
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
            justifications: [],
        };
    },
    methods: {
        toFile(file) {
            window.open(
                "https://inbestiga.com/inbestiga/public/files/" + file.url
            );
        },
        getJustifications() {
            axios
                .get("/api/justifications")
                .then((result) => {
                    this.justifications = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getJustifications();
    },
};
</script>
<style></style>
