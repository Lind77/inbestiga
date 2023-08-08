<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar :hidden="hidden" :user="store.authUser" :role="store.authUser.subarea.name" />
            <div class="layout-page">
                <Navbar @hideSidebar="hideSidebar" />
                <div class="content-wrapper">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from '../stores/UserStore';
import Sidebar from './layout/Sidebar.vue';
import Navbar from './layout/Navbar.vue';

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    components: { Sidebar, Navbar },
    methods: {
        hideSidebar() {
            this.hidden = !this.hidden
        }
    }
}
</script>