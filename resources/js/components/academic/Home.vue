<template>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
    <Sidebar />
    <div class="layout-page">
      <Navbar /> 
      <div class="content-wrapper">
            <!-- Content --> 
            <router-view></router-view>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
    </div>
    </div>
  </div>
  </div>
 
</template>
<script>
  import Sidebar from '../layout/Sidebar.vue'
  import Navbar from '../layout/Navbar.vue'
  export default{
    components: { Sidebar, Navbar }
  }
</script>  