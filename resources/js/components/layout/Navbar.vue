<template>
  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0">
      <a @click="toggleAside" class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <!-- Search -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
          <i class="bx bx-search fs-4 lh-0"></i>
          <input
            type="text"
            class="form-control border-0 shadow-none"
            placeholder="Buscar..."
            aria-label="Buscar..."
          />
        </div>
      </div>
      <!-- /Search -->

      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="bx bx-bell bx-sm"></i><span v-if="cantNotifications != 0" class="badge bg-danger rounded-pill badge-notifications">{{ cantNotifications }}</span>
              <span class="badge bg-danger rounded-pill badge-notifications" v-if="numberNotifications > 0">{{ numberNotifications }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h5 class="text-body mb-0 me-auto">Notificaciones</h5>
                  <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container ps">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item" v-for="notification in notifications">
                    <div class="d-flex">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">{{ notification.user.name }}</h6>
                        <p class="mb-0">{{ notification.content }}</p>
                        <small class="text-muted">{{ dateFormatted(notification.created_at) }}</small>
                      </div>
                    </div>
                  </li>
                </ul>
              <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
              <router-link :to="{name:'notifications', params:{ idUser: this.store.userId }}" class="dropdown-menu-footer border-top">
                <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
                  Ver todas las notificaciones
                </a>
              </router-link>
            </ul>
          </li>
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online" v-if="store.authUser">
              <span class="avatar-initial rounded-circle bg-primary">{{ store.authUser[0].name[0] }}</span>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <!-- <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/avatars/1.png" class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </div> -->
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{ store.authUser == null? '' : store.authUser[0].name }}</span>
                    <small class="text-muted">{{ store.authUser == null? '' : store.authUser[0].roles[0].name }}</small>
                  </div>
                </div>
              </a>
            </li>
            <!-- <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">Perfil</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="bx bx-cog me-2"></i>
                <span class="align-middle">Ajustes</span>
              </a>
            </li> -->
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item cursor-pointer" @click="logout">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Salir</span>
              </a>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </nav>
</template>
<script>
  import moment from 'moment'
 import sound from '../../../../public/sound/tone-alert.mp3'
 import {useCounterStore} from '../../stores/UserStore'
  export default{
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
      return{
        token: localStorage.getItem("token"),
        name: '',
        numberNotifications: 0,
        toggle: true,
        cantNotifications: 0,
        notifications: []
      }
    },
    methods:{
      dateFormatted(date){
        return moment(date).fromNow()
      },
      getNotifications(){
        this.axios.get('/api/getNotifications')
        .then((res) => {
            var filteredNotifications = res.data.filter(notification => notification.user.id != this.store.authUser[0].id)
            this.notifications = filteredNotifications
            this.cantNotifications = this.notifications.length
        }).catch((err) => {
            console.log(err)
        });
      },
      updateNotifications(){
        if(this.store.authUser[0].roles[0].name == 'Experience'){
          this.cantNotifications = this.cantNotifications + 1
          this.playSound()
        }
      },
      playSound(){
        const audio = new Audio(sound)
        audio.play()
      },
      logout(){
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        this.axios.post('/api/logout')
        .then((res) => {
            localStorage.removeItem('token')
            this.store.authUser = null
            this.$router.push('/login')
        }).catch((err) => {
            console.log(err)
        });
      },
      toggleAside(){
        this.$emit('hideSidebar')
      }
    },
    mounted(){
      this.store.getUser()
      this.getNotifications()
      Echo.private('projects')
        .listen('NewProject',()=>{
          this.updateNotifications()
      })
    }
  }
</script>
<style scoped>
  .badge-notifications{
    font-size: .582rem;
    line-height: .55rem;
    padding-bottom: 2px;
    margin-bottom: 10px;
    margin-left: -10px;
  }
</style>