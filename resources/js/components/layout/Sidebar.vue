<template>
  <aside v-if="store.authUser" id="layout-menu" class="layout-menu menu-vertical menu bg-primary text-white"
    :class="{ 'hide-aside': !hidden }">
    <div class="app-brand demo">
      <a href="#" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder ms-2 text-white">Inbestiga </span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <!--  Menú departamento de ventas -->

    <ul class="menu-inner py-1">
      <router-link :to="{ path: '/home' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <li class="menu-header small text-uppercase" v-if="store.authUser.permissions.length > 0"><span
          class="menu-header-text">Premium</span></li>
      <template v-for="permission in store.authUser.permissions">
        <router-link :to="{ name: permission.route_name }" class="menu-item" v-if="permission.siderbar_name != 'Chat'">
          <div class="menu-link">
            <i :class="`menu-icon tf-icons bx ${permission.icon_class}`"></i>
            <div data-i18n="Form Layouts">{{ permission.siderbar_name }}</div>
          </div>
        </router-link>
      </template>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <template v-for="permission in store.authUser.roles[0].permissions">
        <router-link :to="{ name: permission.route_name }" class="menu-item" v-if="permission.siderbar_name != 'Chat'">
          <div class="menu-link">
            <i :class="`menu-icon tf-icons bx ${permission.icon_class}`"></i>
            <div data-i18n="Form Layouts">{{ permission.siderbar_name }}</div>
          </div>
        </router-link>
      </template>

      <router-link :to="{ name: 'real-time', params: { userId: store.authUser.id } }" class="menu-item">
        <div class="menu-link">
          <i :class="`menu-icon tf-icons bx bx-support`"></i>
          <div data-i18n="Form Layouts">Chat</div>
        </div>
      </router-link>


      <li :class="`menu-item ${toggle}`" @click="showToggle" v-if="store.authUser.roles[0].name == 'Admin'">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-check-shield"></i>
          <div data-i18n="Invoice">Roles y Permisos</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <router-link :to="{ name: 'roles-admin' }" class="menu-link">
              <div data-i18n="List">Roles</div>
            </router-link>
          </li>
          <li class="menu-item">
            <router-link :to="{ name: 'permissions-admin' }" class="menu-link">
              <div data-i18n="Preview">Permisos</div>
            </router-link>
          </li>
        </ul>
      </li>
    </ul>
    <!-- Menú departamento admin -->


    <!-- <ul class="menu-inner py-1"
      v-if="store.authUser.roles[0].name == 'AdminAcad' || store.authUser.roles[0].name == 'Quality'">
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <router-link :to="{ name: 'main-acad' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-product' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-package"></i>
          <div data-i18n="Form Layouts">Productos</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-project' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-pie-chart"></i>
          <div data-i18n="Form Layouts">Proyectos</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-collabs' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Inbestigadores</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-teams' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div data-i18n="Form Layouts">Teams</div>
        </div>
      </router-link>
    </ul>
 -->
    <!-- <ul class="menu-inner py-1" v-if="store.authUser.roles[0].name == 'Acad'">
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <router-link :to="{ name: 'main-acad' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'my-projects' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-pie-chart"></i>
          <div data-i18n="Form Layouts">Mis Proyectos</div>
        </div>
      </router-link>
    </ul> -->
  </aside>
</template>
<script>
import { userStore } from '../../stores/UserStore'

export default {
  name: 'Sidebar',
  setup() {
    const store = userStore()
    return { store }
  },
  props: {
    hidden: {
      type: Boolean,
      default: true
    },
    user: Object,
    role: String,
    permissions: Array
  },
  data() {
    return {
      messages: 0,
      toggle: ''
    }
  },
  methods: {
    hideToggle() {
      console.log('out');
      this.toggle = ''
    },
    showToggle() {
      console.log(this.$route.name);
      if (this.toggle == '' || this.$route.name == 'permissions-admin' || this.$route.name == 'roles-admin') {
        this.toggle = 'open'
      }
      else {
        this.toggle = ''
      }

    }
  },
  watch: {
    '$route.name': {
      handler: function (name) {
        if (this.$route.name != 'permissions-admin' || this.$route.name != 'roles-admin') {
          this.toggle = ''
        }
      },
    }
  },
  mounted() {
    Echo.private(`message.${this.store.authUser.id}`)
      .listen('NewMessage', (e) => {
        this.messages++
      })
  }
}
</script>
<style scoped>
aside {
  transition: all 0.4s !important;
}

.hide-aside {
  transition: all 0.4s;
  position: fixed !important;
  transform: translate3d(-100%, 0, 0) !important;
}
</style>