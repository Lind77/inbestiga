<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row" data-v-d514b8ac="">
      <div class="col-lg-12 mb-4 order-0" data-v-d514b8ac="">
        <div class="card" data-v-d514b8ac="">
          <div class="d-flex align-items-end row" data-v-d514b8ac="">
            <div class="col-sm-7" data-v-d514b8ac="">
              <div class="card-body" data-v-d514b8ac="">
                <h5 class="card-title text-primary" data-v-d514b8ac="">{{ store.authUser ? store.authUser.name : '' }}, te
                  damos la bienvenida 🎉</h5>
                <p class="mb-4" data-v-d514b8ac="">Tienes <span class="fw-bold" data-v-d514b8ac="">0</span> notas
                  pendientes para hoy, te recomendamos revisarlas.</p>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left" data-v-d514b8ac="">
              <div class="card-body pb-0 px-0 px-md-4" data-v-d514b8ac=""><img
                  src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/man-with-laptop-light.png"
                  height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png" data-v-d514b8ac=""></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 order-4 order-lg-3">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Notas</h5>
          </div>
          <div class="card-body"><!-- Activity Timeline -->
            <div class="card bg-info text-white mb-3">
              <div class="card-header">Nota</div>
              <div class="card-body">
                <h5 class="card-title text-white">Success card title</h5>
                <p class="card-text">
                  Some quick example text to build on the card title and make up.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 order-4 order-lg-3">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Entregas para hoy</h5>
          </div>
          <div class="card-body"><!-- Activity Timeline -->
            <div class="card bg-success text-white mb-3">
              <div class="card-header">Entrega de Contrato</div>
              <div class="card-body">
                <h5 class="card-title text-white">Success card title</h5>
                <p class="card-text">
                  Some quick example text to build on the card title and make up.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { userStore } from '../../stores/UserStore';

export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  }
}
</script>