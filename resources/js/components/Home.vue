<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar
                v-if="store.authUser && store.authUser.subarea"
                :hidden="hidden"
                :user="store.authUser"
                :role="store.authUser.subarea.name"
                :permissions="store.authUser.roles[0].permissions"
                :bgColor="bg"
            />
            <div class="layout-page">
                <Navbar @hideSidebar="hideSidebar" @theme="theme" />
                <div class="content-wrapper">
                    <component
                        v-if="$route.path == '/home'"
                        :is="getComponentMain"
                        :bg="bg"
                    ></component>
                    <router-view v-else> </router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../stores/UserStore";
import Sidebar from "./layout/Sidebar.vue";
import Navbar from "./layout/Navbar.vue";
import SalesMain from "./sales/Main.vue";
import AdminMain from "./admin/Main.vue";
import ExperienceMain from "./experience/Main.vue";
import AcademicMain from "./academic/Main.vue";
import MarketingMain from "./marketing/Main.vue";
import FinanceMain from "./finance/Main.vue";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            hidden: true,
            bg: "bg-primary",
        };
    },
    components: {
        Sidebar,
        Navbar,
        SalesMain,
        AdminMain,
        ExperienceMain,
        MarketingMain,
        AcademicMain,
        FinanceMain,
    },
    methods: {
        theme(theme) {
            /*  var theme = localStorage.getItem('theme') */
            if (theme == "light") {
                $("nav").removeClass("navbar-border-dark");
                $("nav").removeClass("bg-dark");
                $("#layout-menu").removeClass("bg-dark");
                $(".container-xxl").removeClass("bg-darker");
                $("#toggleIcon").removeClass("bx-sun");
                $("#toggleIcon").addClass("bx-moon");
                $(".card").removeClass("bg-dark");
                $(".card").filter(".bg-success").removeClass("bg-dark");
                $(".layout-container").removeClass("dark-mode");
                $(".layout-page").removeClass("dark-mode");
                /* $('.content-wrapper').removeClass('dark-mode') */
                $("aside").removeClass("navbar-border-dark");
                $("aside").addClass("bg-primary");
                $(".menu-link").removeClass("text-dark");
                /* localStorage.setItem('theme', 'dark'); */
                this.bg = "bg-primary";
            } else if (theme == "dark") {
                /* localStorage.setItem('theme', 'light'); */
                $("nav").addClass("bg-dark");
                $("nav").addClass("navbar-border-dark");
                $("#layout-menu").removeClass("bg-primary");
                $("#layout-menu").addClass("bg-dark");
                $(".container-xxl").addClass("bg-darker");
                $("#toggleIcon").removeClass("bx-moon");
                $("#toggleIcon").addClass("bx-sun");
                $(".card").addClass("bg-dark");
                $(".card").filter(".bg-success").removeClass("bg-dark");
                $(".layout-container").addClass("dark-mode");
                $(".layout-page").addClass("dark-mode");
                /* $('.content-wrapper').addClass('dark-mode') */
                $("aside").addClass("navbar-border-dark");
                $(".menu-link").addClass("text-dark");
                this.bg = "bg-dark";
            }
        },
        hideSidebar() {
            this.hidden = !this.hidden;
            /* $('body').css('transform', `translate(265px, 0)`) */
        },
    },
    computed: {
        getComponentMain() {
            const subareaName = this.store.authUser.subarea.name;

            switch (subareaName) {
                case "sales":
                    return "SalesMain";
                case "acad":
                    return "AcademicMain";
                case "admin":
                    return "AdminMain";
                case "experience":
                    return "ExperienceMain";
                case "marketing":
                    return "MarketingMain";
                case "finance":
                    return "FinanceMain";
                default:
                    return "DefaultComponent"; // Puedes definir un componente por defecto
            }
        },
    },
    mounted() {
        var theme = localStorage.getItem("theme");

        this.theme(theme);

        if (this.store.authUser.roles[0].name == "Experience") {
            Echo.private("posts").listen("NewPost", (e) => {
                console.log(e.post);
                this.postNotification = e.post;
                $("#toastPost").toast("show");
            });
        }

        /* if (localStorage.getItem('reloaded')) {
            localStorage.removeItem('reloaded');
        } else {
            localStorage.setItem('reloaded', '1');
            location.reload();
        } */
    },
};
</script>
<style scoped>
.dark-mode {
    background-color: #232333 !important;
}

.bg-card-dark {
    background-color: #232333 !important;
}
</style>
