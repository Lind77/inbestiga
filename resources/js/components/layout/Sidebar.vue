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
    <ul class="menu-inner py-1" v-if="store.authUser.roles[0].name == 'Seller'">
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <router-link :to="{ name: 'main-sales' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'my-leads' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Mis Leads</div>
        </div>
      </router-link>
      <!-- <router-link :to="{name:'home-product'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-package"></i>
              <div data-i18n="Form Layouts">Productos</div>
            </div>
          </router-link> -->
      <!-- <router-link :to="{name:'home-prices'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-money"></i>
              <div data-i18n="Form Layouts">Precios</div>
            </div>
          </router-link> -->
      <router-link :to="{ name: 'home-documents' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-detail"></i>
          <div data-i18n="Form Layouts">Documentos</div>
        </div>
      </router-link>
      <!-- 
          <router-link :to="{name:'home-orders', params:{ idUser: 0}}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-detail"></i>
              <div data-i18n="Form Layouts">Ordenes</div>
            </div>
          </router-link> -->
      <router-link :to="{ name: 'home-client' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Base de datos</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-pre-lead' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-table"></i>
          <div data-i18n="Form Layouts">Pre-leads</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-funnel' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-table"></i>
          <div data-i18n="Form Layouts">Funnel</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-call' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-phone-call"></i>
          <div data-i18n="Form Layouts">Comunicaciones</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'real-time', params: { userId: store.authUser.id } }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Chat</div>
        </div>
      </router-link>

      <!--
        {{ user.permissions }} 
        <router-link :to="{name:'home-calendar'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-calendar-event"></i>
              <div data-i18n="Form Layouts">Calendario</div>
            </div>
          </router-link> -->
    </ul>
    <!-- Menú departamento admin -->
    <ul class="menu-inner py-1" v-if="store.authUser.roles[0].name == 'Admin'">
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <router-link :to="{ name: 'main-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'users-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Usuarios</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'areas-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Areas</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'subareas-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Sub-Areas</div>
        </div>
      </router-link>
      <li :class="`menu-item ${toggle}`" @click="showToggle">
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
      <router-link :to="{ name: 'promos-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Promociones</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'comissions-admin' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Comisiones</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'real-time', params: { userId: store.authUser.id } }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Chat</div>
        </div>
      </router-link>
    </ul>

    <ul class="menu-inner py-1" v-if="store.authUser.roles[0].name == 'Experience'">
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
      <router-link :to="{ name: 'main-experience' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div data-i18n="Form Layouts">Inicio</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-calendly' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-calendar"></i>
          <div data-i18n="Form Layouts">Calendario</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-deliveries' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-package"></i>
          <div data-i18n="Form Layouts">Entregas</div>
        </div>
      </router-link>
      <!-- <router-link :to="{ name: 'experience-comunications' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-message"></i>
          <div data-i18n="Form Layouts">Comunicaciones</div>
        </div>
      </router-link> -->
      <router-link :to="{ name: 'home-profiles' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Perfiles</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'home-project' }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Proyectos</div>
        </div>
      </router-link>
      <router-link :to="{ name: 'real-time', params: { userId: store.authUser.id } }" class="menu-item">
        <div class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Form Layouts">Chat</div>
          <span v-if="messages != 0" class="badge bg-danger rounded-pill badge-notifications ms-1">{{ messages }}</span>
        </div>
      </router-link>
    </ul>

    <ul class="menu-inner py-1"
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

    <ul class="menu-inner py-1" v-if="store.authUser.roles[0].name == 'Acad'">
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
    </ul>
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
    user: Object
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