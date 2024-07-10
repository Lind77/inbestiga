<template>
    <transition name="fade">
        <aside
            class="d-none d-lg-block col-2 vh-100 px-4 pt-3 position-fixed"
            v-if="hidden"
        >
            <div class="d-flex align-items-center">
                <img
                    src="https://inbestiga.com/inbestiga/public/img/ib_newlogo.png"
                    class="main-logo mb-3 w-100"
                />
            </div>

            <ul class="mt-2 menu-inner d-flex flex-column">
                <li
                    class="menu-item text-white d-flex flex-row align-items-center"
                >
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <p class="mb-0" v-show="hidden">Inicio</p>
                </li>
                <li
                    class="menu-item text-white d-flex flex-row align-items-center mt-2"
                >
                    <i class="menu-icon tf-icons bx bx-upload"></i>
                    <p class="mb-0" v-show="hidden">Mis Proyectos</p>
                </li>
            </ul>
        </aside>
        <aside
            v-else
            class="d-none d-lg-block col-1 vh-100 ps-4 pe-2 pt-3 position-fixed"
        >
            <div class="d-flex w-100 flex-column justify-content-center">
                <div class="d-flex justify-content-center">
                    <img
                        src="https://inbestiga.com/inbestiga/public/img/logo_nobg.png"
                        class="sidebar-little-logo"
                    />
                </div>

                <ul
                    class="menu-inner d-flex flex-column justify-content-center pt-4"
                >
                    <li
                        class="menu-item-hide d-flex justify-content-center py-1"
                    >
                        <i class="menu-icon tf-icons bx bx-home"></i>
                    </li>
                    <li
                        class="menu-item-hide d-flex justify-content-center py-1 mt-2"
                    >
                        <i class="menu-icon tf-icons bx bx-upload"></i>
                    </li>
                </ul>
            </div>
        </aside>
    </transition>
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
.fade-enter-active,
.fade-leave-active {
    transition: all 4s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.sidebar-little-logo {
    width: 50%;
}
.menu-item {
    height: auto;
    width: 100%;
    padding: 3px 5px;
    list-style: none;
    border-radius: 5px;
    font-size: 18px;
    text-align: center;
    cursor: pointer;
    background: linear-gradient(0deg, #7f21fb 64%, rgba(127, 33, 251, 0) 64%);
    background-size: 100% 400%;
    background-position: 100% 0%;
    transition: background 0.3s ease;
}

.menu-item-hide {
    color: #fff;
    padding: 2px 5px;
    width: 100%;
    border-radius: 2px;
    cursor: pointer;
}

.menu-item-hide i {
    font-size: 23px;
}

.menu-item-hide:hover {
    background-position: 100% 100%;
    border: 3px solid #7f21fb;
    background-color: #7f21fb;
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
    background: linear-gradient(
        22deg,
        rgba(38, 20, 38, 1) 17%,
        rgba(41, 21, 41, 1) 39%,
        rgba(95, 29, 95, 1) 60%
    );
    transition: all 0.4s !important;
    z-index: 99;
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
