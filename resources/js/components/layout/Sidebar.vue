<template>
    <aside
        v-if="store.authUser"
        id="layout-menu"
        class="layout-menu menu-vertical menu bg-menu-theme"
        :class="{ 'hide-aside': !hidden }"
    >
        <div class="app-brand demo py-3 px-4 d-flex align-items-center">
            <a href="#" class="app-brand-link d-flex align-items-center">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                    </defs>
                    <use fill="#FFFFFF" xlink:href="#path-1"></use>
                </svg>
                <span class="ms-2 fw-bold text-white font-montserrat" style="font-size: 1.1rem; letter-spacing: 1px;">AVANTAGE <span class="fw-normal" style="font-size: 0.6em; letter-spacing: 2px;">GROUP</span></span>
            </a>
            <a
                href="javascript:void(0);"
                class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none"
            >
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
            <li
                class="menu-header small text-uppercase"
                v-if="store.authUser.permissions.length > 0"
            >
                <span class="menu-header-text">Premium</span>
            </li>
            <template v-for="permission in store.authUser.permissions">
                <router-link
                    :to="{ name: permission.route_name }"
                    class="menu-item"
                    v-if="permission.siderbar_name != 'Chat'"
                >
                    <div class="menu-link">
                        <i
                            :class="`menu-icon tf-icons bx ${permission.icon_class}`"
                        ></i>
                        <div data-i18n="Form Layouts">
                            {{ permission.siderbar_name }}
                        </div>
                    </div>
                </router-link>
            </template>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Menú</span>
            </li>
            <template v-for="permission in store.authUser.roles[0].permissions">
                <router-link
                    :to="{ name: permission.route_name }"
                    class="menu-item"
                    v-if="permission.siderbar_name != 'Chat'"
                >
                    <div class="menu-link">
                        <i
                            :class="`menu-icon tf-icons bx ${permission.icon_class}`"
                        ></i>
                        <div data-i18n="Form Layouts">
                            {{ permission.siderbar_name }}
                        </div>
                    </div>
                </router-link>
            </template>

            <router-link
                :to="{
                    name: 'real-time',
                    params: { userId: store.authUser.id },
                }"
                class="menu-item"
            >
                <div class="menu-link">
                    <i :class="`menu-icon tf-icons bx bx-support`"></i>
                    <div data-i18n="Form Layouts">Chat</div>
                </div>
            </router-link>

            <li
                :class="`menu-item ${toggle}`"
                @click="showToggle"
                v-if="store.authUser.roles[0].name == 'Admin'"
            >
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-check-shield"></i>
                    <div data-i18n="Invoice">Roles y Permisos</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <router-link
                            :to="{ name: 'roles-admin' }"
                            class="menu-link"
                        >
                            <div data-i18n="List">Roles</div>
                        </router-link>
                    </li>
                    <li class="menu-item">
                        <router-link
                            :to="{ name: 'permissions-admin' }"
                            class="menu-link"
                        >
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
          <div data-i18n="Form Layouts">Avantagedores</div>
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
import { userStore } from "../../stores/UserStore";

export default {
    name: "Sidebar",
    setup() {
        const store = userStore();
        return { store };
    },
    props: {
        hidden: {
            type: Boolean,
            default: true,
        },
        user: Object,
        role: String,
        permissions: Array,
        bgColor: String,
    },
    data() {
        return {
            messages: 0,
            toggle: "",
        };
    },
    methods: {
        hideToggle() {
            console.log("out");
            this.toggle = "";
        },
        showToggle() {
            console.log(this.$route.name);
            if (
                this.toggle == "" ||
                this.$route.name == "permissions-admin" ||
                this.$route.name == "roles-admin"
            ) {
                this.toggle = "open";
            } else {
                this.toggle = "";
            }
        },
    },
    watch: {
        "$route.name": {
            handler: function (name) {
                if (
                    this.$route.name != "permissions-admin" ||
                    this.$route.name != "roles-admin"
                ) {
                    this.toggle = "";
                }
            },
        },
    },
    mounted() {
        $("aside").addClass(this.bgColor);

        /* Echo.private(`message.${this.store.authUser.id}`)
      .listen('NewMessage', (e) => {
        this.messages++
      }) */
    },
};
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

.dark-mode {
    background-color: red !important;
}

.navbar-border-dark {
    box-shadow: 0 0 0.375rem 0.25rem rgba(0, 0, 0, 0.15) !important;
}

.text-dark {
    color: #a2a3cb !important;
}

/* Removed to use global CSS */
</style>
