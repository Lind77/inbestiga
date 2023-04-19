<template>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <Sidebar :hidden = "hidden"/>
      <div class="layout-page">
        <Navbar @hideSidebar="hideSidebar"/> 
        <div class="content-wrapper">
              <!-- Content --> 
              <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">Mis notificaciones</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center" v-for="notification in notifications">
                        <i class='bx bx-check pe-2'></i>
                        {{ notification.emisor.name }} {{ notification.content }} - {{ dateFormatted(notification.created_at) }}
                    </li>
                </ul>
              </div>
              
              <!-- / Content -->
        </div>
      </div>
    </div>
    </div>
</template>
<script>
    import Sidebar from './Sidebar.vue'
    import Navbar from './Navbar.vue'
    import moment from 'moment/min/moment-with-locales'
    export default {
        components:{ Sidebar, Navbar },
        data(){
            return{
                hidden: true,
                notifications: []
            }
        },
        methods:{
            getAllNotifications(){
                axios.get('/api/getAllNotifications/'+ this.$route.params.idUser)
                .then(res =>{
                    console.log(res.data)
                    var data = res.data
                    this.notifications = data[0].notifications
                })
                .catch(err =>{
                    console.log(err)
                })
            },
            hideSidebar(){
                this.hidden = !this.hidden
            },
            dateFormatted(date){
                moment.locale('es')
                return moment(date).fromNow()
            }
        },
        mounted(){
            this.getAllNotifications()
        }
    }
</script>