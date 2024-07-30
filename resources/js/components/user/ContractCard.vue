<template>
    <div class="col-8 text-white" v-if="project && project.projectable">
        <p>
            Aplicación de instrumentos: {{ project.projectable.third_article }}
        </p>
        <p>Servicio contratado: 
            <p class="fw-normal" v-for="detail in project.projectable.quotation.details "> -{{ detail.name }}</p>

        </p>
        <p>Lugar o contexto de estudio: {{ project.projectable.third_article_place }}</p>
        <p>Desarrollo de diapositivas: {{ project.projectable.third_article_ppts}}</p>
        <button class="btn btn-gradient">Descárgalo aquí</button>
    </div>
    <div class="col-4 d-flex justify-content-center">
        <img
            src="https://inbestiga.com/inbestiga/public/img/contract_ipad.png"
        />
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
    },
};
</script>
<style scoped>
p {
    font-size: 0.8rem;
    font-weight: bold;
    margin-bottom: 3px;
}
img{
    width: 190%;
}
.btn-gradient{
    background: rgb(251,21,215);
background: linear-gradient(22deg, rgba(251,21,215,1) 0%, rgba(127,33,251,1) 73%);
color: #fff;
font-size: .8em;
font-weight: 800;
}
</style>
