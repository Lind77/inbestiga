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
      $('.layout-page').addClass('bg-dark')
    }
  }
}
</script>  