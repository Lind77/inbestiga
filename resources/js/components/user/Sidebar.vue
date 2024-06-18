<template>
    <aside
        class="col-3 vh-100 px-5 pt-3 glass"
        :class="{ 'hide-aside': !hidden }"
    >
        <img
            src="https://jairpl.com/pdf-sys/logo.png"
            class="main-logo mb-3 w-100"
        />
        <ul class="mt-2 menu-inner d-flex flex-column">
            <li class="menu-item text-white d-flex flex-row align-items-center">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <p class="mb-0">Inicio</p>
            </li>
            <li
                class="menu-item text-white d-flex flex-row align-items-center mt-2"
            >
                <i class="menu-icon tf-icons bx bx-upload"></i>
                <p class="mb-0">Mis Proyectos</p>
            </li>
        </ul>
    </aside>
</template>
<script>
export default {
    props: {
        hidden: {
            type: Boolean,
            default: true,
        },
    },
};
</script>
<style scoped>
.menu-item {
    height: auto;
    width: 100%;
    padding: 5px;
    list-style: none;
    border: 1px solid #fb15d7;
    border-radius: 5px;
    font-size: 20px;
    text-align: center;
    cursor: pointer;
    background: linear-gradient(0deg, #7f21fb 64%, rgba(127, 33, 251, 0) 64%);
    background-size: 100% 400%;
    background-position: 100% 0%;
    transition: background 0.3s ease;
}

.menu-item:hover {
    background-position: 100% 100%;
    border: 3px solid #7f21fb;
}

.hide-aside {
    transition: all 0.4s;
    position: fixed !important;
    transform: translate3d(-100%, 0, 0) !important;
}
aside {
    transition: all 0.4s !important;
}

@media only screen and (max-width: 576px) {
    aside {
        padding: 10px 5px 0px 20px !important;
    }
    .menu-item > p {
        font-size: 8px;
    }

    .main-logo {
        width: 100% !important;
        margin-bottom: 20px;
    }
}
</style>
