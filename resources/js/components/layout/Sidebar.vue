<template>
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-bolder ms-2">Inbestiga</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">

        <!-- Forms & Tables -->
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
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-package"></i>
            <div data-i18n="Layouts">Productos</div>
          </a>

          <ul class="menu-sub">
            <router-link :to="{name:'main-acad'}" class="menu-item">
              <div href="layouts-without-menu.html" class="menu-link">
                <div data-i18n="Without menu">Crear</div>
              </div>
            </router-link>
            <li class="menu-item">
              <div href="layouts-without-menu.html" class="menu-link">
                <div data-i18n="Without menu">Lista</div>
              </div>
            </li>
          </ul>
        </li>
        <!-- <router-link :to="{name:'home-quotation'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-detail"></i>
            <div data-i18n="Form Layouts">Cotizaciones</div>
          </div>
        </router-link> -->
        <!-- 
        <router-link :to="{name:'home-list'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-package"></i>
            <div data-i18n="Form Layouts">Lista</div>
          </div>
        </router-link>
          --><router-link :to="{name:'home-project'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-pie-chart"></i>
            <div data-i18n="Form Layouts">Proyectos</div>
          </div>
        </router-link>
        
        <!-- <router-link :to="{name:'home-owner'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Form Layouts">Inbestigadores</div>
          </div>
        </router-link>
        <router-link :to="{name:'home-owner'}" class="menu-item">
          <div class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Form Layouts">Clientes</div>
          </div>
        </router-link> -->
      </ul>
    </aside>
</template>
<script>
export default {
    name: 'Sidebar'
}
</script>
