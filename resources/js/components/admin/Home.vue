<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
        <Sidebar />
            <div class="layout-page">
                <Navbar /> 
                <div class="content-wrapper">
                    <router-view></router-view>
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
          token: localStorage.getItem('token')
        }
      }
    }
</script>  