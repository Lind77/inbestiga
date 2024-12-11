<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar v-if="store.authUser && store.authUser.subarea" :hidden="hidden" :user="store.authUser"
                :role="store.authUser.subarea.name" :permissions="store.authUser.roles[0].permissions" :bgColor="bg" />
            <div class="layout-page">
                <Navbar @hideSidebar="hideSidebar" @theme="theme" :notifications="notifications" />
                <div class="content-wrapper">
                    <component v-if="$route.path == '/home'" :is="getComponentMain" :bg="bg"></component>
                    <router-view v-else> </router-view>
                </div>
            </div>
            <!-- <div class="presence pt-3">
                <h6>Online</h6>
            </div> -->
        </div>
    </div>
    <ToastPost :post="postNotification" />
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
import ToastPost from "./experience/ToastPost.vue";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            hidden: true,
            bg: "bg-primary",
            postNotification: {},
            notifications: [],
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
        ToastPost,
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
        getNotifications() {
            this.axios
                .get("/api/notifications/" + this.store.authUser.id)
                .then((res) => {
                    this.notifications = res.data;
                    this.cantNotifications = 5;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    computed: {
        getComponentMain() {
            const subareaName = this.store.authUser.subarea.name;

            const componentMap = {
                sales: "SalesMain",
                acad: "AcademicMain",
                admin: "AdminMain",
                experience: "ExperienceMain",
                marketing: "MarketingMain",
                finance: "FinanceMain"
            };

            return componentMap[subareaName] || "DefaultComponent";
        },
    },
    mounted() {
        var theme = localStorage.getItem("theme");

        this.theme(theme);

        this.getNotifications();

        if (this.store.authUser.roles[0].name == "Experience") {
            Echo.private("posts").listen("NewPost", (e) => {
                //this.getNotifications();

                var newNotification = {
                    notification: {
                        notificable: {
                            name: e.post.postable.name,
                        },
                        content: "envió un nuevo post en su timeline.",
                        created_at: e.post.created_at,
                        quotationId: e.post.project.projectable.quotation_id,
                    },
                };

                this.notifications.unshift(newNotification);

                this.postNotification = e.post;
                $("#toastPost").toast("show");
            });
        }

        /* if (this.store.authUser) {
            Echo.private(`message.${this.store.authUser.id}`).listen(
                "NewMessage",
                (e) => {
                    alert(e.message.message);
                    console.log(e.message);
                    this.getNewMessages();
                      this.numberMessages = this.numberMessages + 1;
                    Notification.requestPermission()
                        .then((result) => {
                            if (result === "granted") {
                                new Notification("Tienes un nuevo mensaje", {
                                    body: e.message.message,
                                });
                            }
                        })
                        .catch((err) => {}); 
                }
            );
        } */

        /* 
        if (this.store.authUser) {
            Echo.private().listen();
        } */

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
