<template>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <Sidebar :hidden = "hidden"/>
      <div class="layout-page">
        <Navbar @hideSidebar="hideSidebar"/> 
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
      components: { Sidebar, Navbar },
      data(){
        return{
          hidden: true
        }
      },
      methods:{
        hideSidebar(){
          this.hidden = !this.hidden
        }
      }
    }
  </script>
  <style scoped>
    @media (max-width: 140px){
      .layout-menu{
        position: relative !important;
        transform: none;
      }
    }
  </style>  