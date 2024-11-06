<template>
    <div class="col-12 col-lg-4">
        <div class="card my-4" @click="toProject">
            <div class="background-overlay"></div>
            <div class="content">
                <h5 class="text-white fw-bold cursor-pointer text-center py-2">
                    {{ project.title }}
                </h5>
                <p class="fw-normal text-center text-white">
                    Fecha de inicio:
                    {{
                        project.start_date ? project.start_date : "Sin asignar"
                    }}
                </p>
                <!--  <div class="progress">
                        <div
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            role="progressbar"
                            style="width: 80%"
                            aria-valuenow="80"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        ></div>
                    </div> -->
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
    position: relative;
    overflow: hidden;
    border: 1px solid #680e46;
    transition: transform 0.5s;
}

.card:hover {
    transform: scale(1.08);
}

.background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    transition: filter 0.5s;
    filter: brightness(60%);
    z-index: 1; /* Coloca la imagen detrás del contenido */
}

.card:hover .background-overlay {
    background-image: url("https://inbestiga.com/inbestiga/public/img/user/project.png");
    background-size: cover;
    background-position: center;
    filter: brightness(30%); /* Elimina el filtro en hover si lo deseas */
}

.content {
    position: relative;
    padding: 8px;
    z-index: 2; /* Asegura que el contenido esté delante de la imagen */
    /* Estiliza tu contenido como prefieras */
}

.card-header {
    color: #fff;
    font-weight: 700;
    font-size: 1.2em;
}

.card-header p {
    font-size: 0.8em;
}

.card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    transition: 0.5s;
    cursor: pointer;
}
</style>
