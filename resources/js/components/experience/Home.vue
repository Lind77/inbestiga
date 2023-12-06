<template>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <Sidebar :hidden="hidden" />
      <div class="layout-page">
        <Navbar @hideSidebar="hideSidebar" @darkMode="darkMode" />
        <div class="content-wrapper">
          <!-- Content -->
          <router-view></router-view>
          <!-- / Content -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Sidebar from '../layout/Sidebar.vue'
import Navbar from '../layout/Navbar.vue'

export default {
  components: { Sidebar, Navbar },
  data() {
    return {
      hidden: true,
      token: localStorage.getItem('token')
    }
  },
  methods: {
    hideSidebar() {
      this.hidden = !this.hidden
    },
    darkMode() {
      $('nav').addClass('navbar-border-dark')
      $('#layout-menu').removeClass('bg-primary');
      $('#layout-menu').addClass('bg-dark');
      $('.container-xxl').addClass('bg-dark');
      $('#toggleIcon').removeClass('bx-moon')
      $('#toggleIcon').addClass('bx-sun')
      $('.card').addClass('bg-card-dark')
      $('.card').filter('.bg-success').removeClass('bg-card-dark')
      $('.layout-container').addClass('dark-mode')
      $('.layout-page').addClass('dark-mode')
      $('.content-wrapper').addClass('dark-mode')
      $('aside').addClass('navbar-border-dark')
      $('.menu-link').addClass('text-dark')
    }
  }
}
</script>  
<style scoped>
.dark-mode {
  background-color: #232333 !important;
}
</style>