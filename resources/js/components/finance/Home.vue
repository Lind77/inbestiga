<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar :hidden="hidden" />
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
import Sidebar from "../layout/Sidebar.vue";
import Navbar from "../layout/Navbar.vue";

export default {
    components: { Sidebar, Navbar },
    data() {
        return {
            hidden: true,
            token: localStorage.getItem("token"),
        };
    },
    methods: {
        hideSidebar() {
            this.hidden = !this.hidden;
        },
    },
};
</script>
