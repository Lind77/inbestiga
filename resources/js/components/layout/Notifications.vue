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

                <table class="table px-5">
                    <thead>
                        <tr>
                            <th>Notificaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="notification in notifications">
                            <td>{{ notification.emisor.name }} {{ notification.content }} - {{ dateFormatted(notification.created_at) }}</td>
                        </tr>
                    </tbody>
                </table>
              </div>
              
              <!-- / Content -->
        </div>
      </div>
    </div>
    </div>
</template>
<script>
    import Sidebar from './Sidebar.vue';
    import Navbar from './Navbar.vue';
    import moment from 'moment';
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
                return moment(date).fromNow()
            }
        },
        mounted(){
            this.getAllNotifications()
        }
    }
</script>