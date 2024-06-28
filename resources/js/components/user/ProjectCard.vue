<template>
    <div class="glass-card col-12 col-lg-4 p-4 ms-2 mt-2">
        <img
            src="https://i.pinimg.com/564x/8f/ee/ec/8feeec43a7ff61f24e2b7fd3791ed5b5.jpg"
            alt=""
        />
        <h4
            class="fw-normal text-white cursor-pointer"
            @click="toDocumentation(project)"
        >
            {{ project.title }}
        </h4>
        <p class="text-white">
            Fecha de Inicio:
            {{ project.deadline ? formatDate(project.deadline) : "-" }}
        </p>
    </div>
</template>
<script>
import moment from "moment";

export default {
    props: {
        project: Object,
        quotation: Object,
    },
    methods: {
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        toDocumentation(project) {
            this.$router.push({
                name: "user-documentation",
                params: { quotationId: this.quotation.id },
            });
        },
    },
};
</script>
<style scoped>
.glass-card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 8px;

    padding: 0px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.glass-card > img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 100%;
    margin-bottom: 15px;
}
</style>
