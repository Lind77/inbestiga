<template>
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-bolder ms-2">Inbestiga </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>
     <!--  Menú departamento de ventas -->
      <ul class="menu-inner py-1" v-if="store.rol == 'Seller'">
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
          <router-link :to="{name:'main-sales'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-home"></i>
              <div data-i18n="Form Layouts">Inicio</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-product'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-package"></i>
              <div data-i18n="Form Layouts">Productos</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-quotation'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-detail"></i>
              <div data-i18n="Form Layouts">Cotizaciones</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-client'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div data-i18n="Form Layouts">Clientes</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-pre-lead'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Form Layouts">Pre-leads</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-funnel'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-table"></i>
              <div data-i18n="Form Layouts">Funnel</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-call'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-phone-call"></i>
              <div data-i18n="Form Layouts">Llamadas</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-calendar'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-calendar-event"></i>
              <div data-i18n="Form Layouts">Calendario</div>
            </div>
          </router-link>
      </ul>
      <!-- Menú departamento académico -->
      <ul class="menu-inner py-1" v-if="store.rol == 'Admin'">
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
          <router-link :to="{name:'main-admin'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-home"></i>
              <div data-i18n="Form Layouts">Inicio</div>
            </div>
          </router-link>
          <router-link :to="{name:'users-admin'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div data-i18n="Form Layouts">Usuarios</div>
            </div>
          </router-link>
          <router-link :to="{name:'roles-admin'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-user"></i>
              <div data-i18n="Form Layouts">Roles</div>
            </div>
          </router-link>
      </ul>

      <ul class="menu-inner py-1" v-if="store.rol == 'AdminAcad'">
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
          <router-link :to="{name:'main-acad'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-home"></i>
              <div data-i18n="Form Layouts">Inicio</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-product'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-package"></i>
              <div data-i18n="Form Layouts">Productos</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-project'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-pie-chart"></i>
              <div data-i18n="Form Layouts">Proyectos</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-collabs'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Form Layouts">Colaboradores</div>
          </div>
        </router-link>

        <router-link :to="{name:'home-teams'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Form Layouts">Teams</div>
          </div>
        </router-link>
      </ul>

      <ul class="menu-inner py-1" v-if="store.rol == 'Acad'">
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Menú</span></li>
          <router-link :to="{name:'main-acad'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-home"></i>
              <div data-i18n="Form Layouts">Inicio</div>
            </div>
          </router-link>
          <router-link :to="{name:'home-project'}" class="menu-item">
            <div class="menu-link">
              <i class="menu-icon tf-icons bx bx-pie-chart"></i>
              <div data-i18n="Form Layouts">Mis Proyectos</div>
            </div>
          </router-link>
      </ul>
    </aside>
</template>
<script>
import {useCounterStore} from '../../stores/UserStore'

export default {
    name: 'Sidebar',
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    }
}
</script>
