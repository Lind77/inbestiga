<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar :hidden="hidden" :user="store.authUser" :role="store.authUser.subarea.name"
                :permissions="store.authUser.roles[0].permissions" />
            <div class="layout-page">
                <Navbar @hideSidebar="hideSidebar" />
                <div class="content-wrapper">
                    <component :is="getComponentMain"></component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from '../stores/UserStore';
import Sidebar from './layout/Sidebar.vue';
import Navbar from './layout/Navbar.vue';
import SalesMain from './sales/Main.vue';
import AdminMain from './admin/Main.vue';
import ExperienceMain from './experience/Main.vue';
import AcademicMain from './academic/Main.vue'
import MarketingMain from './marketing/Main.vue'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    components: { Sidebar, Navbar, SalesMain, AdminMain, ExperienceMain },
    methods: {
        hideSidebar() {
            this.hidden = !this.hidden
        }
    },
    computed: {
        getComponentMain() {
            const subareaName = this.store.authUser.subarea.name;

            switch (subareaName) {
                case 'sales':
                    return 'SalesMain';
                case 'acad':
                    return 'AcademicMain';
                case 'admin':
                    return 'AdminMain';
                case 'experience':
                    return 'ExperienceMain';
                case 'marketing':
                    return 'MarketingMain';
                default:
                    return 'DefaultComponent'; // Puedes definir un componente por defecto
            }
        }
    }
}
</script>