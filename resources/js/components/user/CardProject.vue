<template>
    <div class="card glass my-4">
        <div class="row">
            <div class="col-8">
                <div class="card-header">
                    <h5
                        class="text-white fw-bold cursor-pointer"
                        @click="toProject"
                    >
                        {{ project.title }}
                    </h5>
                    <p class="fw-normal">
                        Fecha de inicio:
                        {{
                            project.start_date
                                ? project.start_date
                                : "Sin asignar"
                        }}
                    </p>
                    <div class="progress">
                        <div
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            role="progressbar"
                            style="width: 80%"
                            aria-valuenow="80"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <img
                    src="https://inbestiga.com/inbestiga/public/img/circle-card.png"
                    alt="Avatar"
                    class="rounded-circle w-75"
                />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
    },
    methods: {
        toProject() {
            console.log(this.project);
            this.$router.push({
                name: "show-project-user",
                params: { projectId: this.project.id },
            });
        },
    },
};
</script>
<style scoped>
.card {
    width: 90%;
    margin: 0px auto;
}

.card-header {
    color: #fff;
    font-weight: 700;
    font-size: 1.2em;
}

.card-header p {
    font-size: 0.8em;
}

.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}
</style>
