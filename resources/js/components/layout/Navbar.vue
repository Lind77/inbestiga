<template>
  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0">
      <a @click="toggleAside" class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <!-- Search -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
          <!-- <i class="bx bx-search fs-4 lh-0"></i> -->
          <!-- <input type="text" class="form-control border-0 shadow-none" placeholder="Buscar..." aria-label="Buscar..."
            autocomplete="off" /> -->
        </div>
      </div>
      <!-- /Search -->

      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
            @click="darkMode">
            <i id="toggleIcon" class="bx bx-sm bx-moon"></i>
          </a>
        </li>
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
          <a @click="clearCantNotifications" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i class="bx bx-chat bx-sm"></i><span v-if="numberMessages != 0"
              class="badge bg-danger rounded-pill badge-notifications">{{ numberMessages
              }}</span>
            <span class="badge bg-danger rounded-pill badge-notifications" v-if="numberNotifications > 0">{{
              numberNotifications }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end py-0">
            <li class="dropdown-menu-header border-bottom">
              <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Chats</h5>
                <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip"
                  data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i
                    class="bx fs-4 bx-envelope-open"></i></a>
              </div>
            </li>
            <li class="dropdown-notifications-list scrollable-container ps">
              <ul class="list-group list-group-flush">
                <template v-for="message in messages">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">{{ message.emisor.name }}</h6>
                        <p>{{ message.message }}</p>
                        <!-- <small class="text-muted">{{ dateFormatted(notification.created_at) }}</small> -->
                      </div>
                      <!--  <div class="flex-grow-1">
                        <i @click="confirmSeen(notification.users[0].pivot.id, notification.id)"
                          :id="`checkNot${notification.users[0].pivot.id}`" class='bx bx-check-circle text-secondary'></i>
                      </div> -->
                    </div>
                  </li>
                </template>
              </ul>
              <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
              </div>
              <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
              </div>
            </li>
            <router-link v-if="store.authUser" :to="{ name: 'real-time', params: { userId: store.authUser.id } }"
              class="dropdown-menu-footer border-top">
              <template class="dropdown-item d-flex justify-content-center p-3">
                Ver todos los chats
              </template>
            </router-link>
          </ul>
        </li>
        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
          <a @click="clearCantNotifications" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i class="bx bx-bell bx-sm"></i><span v-if="cantNotifications != 0"
              class="badge bg-danger rounded-pill badge-notifications">{{ cantNotifications }}</span>
            <span class="badge bg-danger rounded-pill badge-notifications" v-if="numberNotifications > 0">{{
              numberNotifications }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end py-0">
            <li class="dropdown-menu-header border-bottom">
              <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Notificaciones</h5>
                <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip"
                  data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i
                    class="bx fs-4 bx-envelope-open"></i></a>
              </div>
            </li>
            <li class="dropdown-notifications-list scrollable-container ps">
              <ul class="list-group list-group-flush">
                <template v-for="notification in notifications">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item"
                    :id="`notification${notification.id}`">
                    <div class="d-flex">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">{{ notification.emisor.name }} {{ notification.content }}</h6>
                        <small class="text-muted">{{ dateFormatted(notification.created_at) }}</small>
                      </div>
                      <div class="flex-grow-1">
                        <i @click="confirmSeen(notification.users[0].pivot.id, notification.id)"
                          :id="`checkNot${notification.users[0].pivot.id}`" class='bx bx-check-circle text-secondary'></i>
                      </div>
                    </div>
                  </li>
                </template>
              </ul>
              <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
              </div>
              <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
              </div>
            </li>
            <router-link v-if="store.authUser" :to="{ name: 'notifications', params: { idUser: store.authUser.id } }"
              class="dropdown-menu-footer border-top">
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
              <span class="avatar-initial rounded-circle bg-primary">{{ store.authUser.name[0] }}</span>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" @click="toProfile(store.authUser.id)">
                <div class="d-flex">
                  <!-- <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/avatars/1.png" class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </div> -->
                  <div class="flex-grow-1 cursor-pointer" v-if="store.authUser">
                    <span class="fw-semibold d-block">{{ store.authUser.name }}</span>
                    <small class="text-muted">{{ store.authUser.roles[0].name }}</small>
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
  <Toast />
</template>
<script>
import moment from 'moment'
import sound from '../../../../public/sound/tone-alert.mp3'
import Toast from './Toast.vue'
import { userStore } from '../../stores/UserStore'
export default {
  components: { Toast },
  emits: ['hideSidebar'],
  setup() {
    const store = userStore()
    return { store }
  },
  data() {
    return {
      token: localStorage.getItem("token"),
      name: '',
      numberNotifications: 0,
      toggle: true,
      cantNotifications: 0,
      notifications: [],
      seens: [],
      numberMessages: 0,
      messages: [],
      users: []
    }
  },
  methods: {
    darkMode() {
      this.$emit('darkMode')
    },
    getUsers() {
      axios.get('/api/users/')
        .then((result) => {
          this.users = result.data
        }).catch((err) => {

        });
    },
    getAllMessages() {
      axios.get('/api/chats/' + this.store.authUser.id)
        .then((result) => {
          this.messages = result.data
        }).catch((err) => {

        });
    },
    getNewMessages() {
      axios.get('/api/new-chat/' + this.store.authUser.id)
        .then((result) => {
          var newMessage = result.data

          var existentMessage = this.messages.find(message => message.emisor_id == newMessage.emisor_id)

          if (existentMessage) {
            existentMessage.message = newMessage.message
          } else {
            this.messages.push(newMessage)
          }

        }).catch((err) => {

        });
    },
    toProfile(id) {
      this.$router.push({ name: 'profile', params: { idUser: id } })
    },
    clearCantNotifications() {
      this.cantNotifications = 0
      if (this.notifications.length > 0) {
        this.notifications.forEach((notification) => {
          var seen_id = notification.users[0].pivot.id
          console.log(seen_id)
          axios.get('/api/registerSeen/' + seen_id)
            .then(res => {
              console.log(res)
            })
            .catch(err => {
              console.log(err)
            })
        })
      }
    },
    confirmSeen(seen, notId) {
      console.log(seen)

      this.cantNotifications--

      document.getElementById('notification' + notId).classList.add('hideNotification')

      setTimeout(() => {
        document.getElementById('notification' + notId).classList.add('killSpace')
      }, 2000);

      axios.get('/api/registerSeen/' + seen)
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    dateFormatted(date) {
      return moment(date).fromNow()
    },
    getNotifications() {
      this.axios.get('/api/getNotifications')
        .then((res) => {
          var filteredNotifications = res.data.filter(notification => notification.user.id != this.store.authUser.id)
          this.notifications = filteredNotifications
          this.cantNotifications = this.notifications.length
        }).catch((err) => {
          console.log(err)
        });
    },
    getNoSeenNotifications() {
      this.axios.get('/api/notifications/' + this.store.authUser.id)
        .then((res) => {
          this.notifications = res.data
          this.cantNotifications = this.notifications.length
        }).catch((err) => {
          console.log(err)
        });
    },
    updateNotifications() {
      console.log('ha llegado una nueva notificacion atraves de pusher')
      if (this.store.authUser.roles[0].name == 'Experience') {
        this.cantNotifications = this.cantNotifications + 1
        this.getNoSeenNotifications()
        this.playSound()
        $('#toast').toast('show')
      }
    },
    playSound() {
      const audio = new Audio(sound)
      audio.play()
    },
    logout() {
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
    toggleAside() {
      this.$emit('hideSidebar')
    },
    newDirectionProject() {
      if (this.store.authUser.roles[0].name == 'AdminAcad') {
        alert('tienes un nuevo proyecto')
      }
    }
  },
  mounted() {
    this.getAllMessages()
    this.getUsers()
    this.getNoSeenNotifications()


    Echo.private(`message.${this.store.authUser.id}`)
      .listen('NewMessage', (e) => {
        console.log(e.message)
        this.getNewMessages()
        this.numberMessages = this.numberMessages + 1
        Notification.requestPermission()
          .then((result) => {
            if (result === 'granted') {
              new Notification('Tienes un nuevo mensaje', {
                body: e.message.message
              })
            }
          }).catch((err) => {

          });
      })



    if (this.store.authUser.roles[0].name == 'Seller') {
      /* Echo.private('documents')
        .listen('NewDocument', (e) => {
          this.updateNotifications()
        }) */

      /* Echo.private(`leads.${this.store.authUser.id}`)
        .listen('NewLead', (e) => {
          console.log('new lead realtime')
          this.updateNotifications()
          Notification.requestPermission()
            .then((result) => {
              if (result === 'granted') {
                new Notification('Tienes un nuevo lead asignado')
              }
            }).catch((err) => {

            });
        }) */
    }

    /* if (this.store.authUser.roles[0].name == 'Experience') {
      Echo.private('projects')
        .listen('NewProject', (e) => {
          this.updateNotifications()
        })

      Echo.private('updates')
        .listen('NewUpdate', (e) => {
          this.getNoSeenNotifications()
        })

    } else if (this.store.authUser.roles[0].name == 'AdminAcad') {
      Echo.private('direction')
        .listen('NewDirection', (e) => {
          this.getNoSeenNotifications()
        })

      Echo.private('updates')
        .listen('NewUpdate', (e) => {
          this.getNoSeenNotifications()
        })
    } */

  }
}
</script>
<style scoped>
.badge-notifications {
  font-size: .582rem;
  line-height: .55rem;
  padding-bottom: 2px;
  margin-bottom: 10px;
  margin-left: -10px;
}

.hideNotification {
  opacity: 0;
  transition: opacity 2s;
}

.killSpace {
  display: none;
}

.dark-mode {
  background-color: #2a2b40 !important;
}

.bg-dark {
  background-color: #2b2c40 !important;
}

.navbar-border-dark {
  box-shadow: 0 0 0.375rem 0.25rem rgba(0, 0, 0, .15) !important;
}

/* nav {
  position: fixed;
} */
</style>