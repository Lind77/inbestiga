<template>
    <ul class="dropdown-menu dropdown-menu-end mt-2">
        <li>
            <a class="dropdown-item cursor-pointer" @click="toHome">
                <span class="align-middle">Mi estación</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item cursor-pointer">
                <span class="align-middle">Mi experiencia</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item cursor-pointer" @click="toMyProjects">
                <span class="align-middle">Mis proyectos</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item cursor-pointer">
                <span class="align-middle">Mis cursos</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item cursor-pointer">
                <span class="align-middle">Facturación</span>
            </a>
        </li>
    </ul>
</template>
<script>
export default {
    props: {
        customerId: Number,
    },
    methods: {
        toMyProjects() {
            this.$router.push({
                name: "project-user",
                params: { customerId: this.customerId },
            });
        },
        toHome() {
            this.$router.push({
                path: "/home-user/" + this.customerId,
            });
        },
    },
};
</script>
<style scoped>
.dropdown-menu {
    position: absolute;
    background: rgba(255, 255, 255, 0.112);
    /*  backdrop-filter: blur(20px); */
    -webkit-backdrop-filter: blur(5px);
    color: #fff;
}
.dropdown-menu::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(10px);
    z-index: -1;
}
</style>
