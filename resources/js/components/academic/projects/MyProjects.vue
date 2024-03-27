<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Mis Proyectos</h4>
    <div class="row g-4">
      <div class="col-xl-4 col-lg-6 col-md-6" v-for="project in projects">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-start">
              <div class="d-flex align-items-start">
                <div class="me-2" v-if="project.id">
                  <h5 class="mb-1"><router-link :to="{ name: 'project', params: { idProject: project.id } }"
                      class="h5 stretched-link">{{ project.title }}</router-link></h5>
                  <div class="client-info" v-if="project.projectable">
                    <p v-for="customer in project.projectable.quotation.customers">{{ customer.name }}</p>
                  </div>
                </div>
              </div>
              <div class="ms-auto">
                <div class="dropdown zindex-2">
                  <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0);">Ver Kanban</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0);">Abandonar proyecto</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center flex-wrap">
              <div class="bg-lighter p-2 rounded me-auto mb-3" v-if="project.order">
                <template v-for="details in project.order.quotation.details">
                  <p class="mb-0">{{ details.product.title }}</p>
                </template>
              </div>
              <div class="text-end mb-3">
                <h6 class="mb-1">Deadline: <span class="text-body fw-normal">{{ formatDate(project.deadline) }}</span>
                </h6>
              </div>
            </div>

          </div>
          <div class="card-body border-top">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <small>Tareas: {{ project.numTasksCompleted }}/{{ project.numTasks }}</small>
              <small>{{ percentageProject(project) }}% Completado</small>
            </div>
            <div class="progress mb-3" style="height: 8px;">
              <div class="progress-bar" role="progressbar" :style="{ width: percentageProject(project) + '%' }"
                aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-start mb-3">
              <span class="badge bg-label-success ms-auto">{{ formatDays(project.deadline) }}</span>
            </div>

            <div class="d-flex align-items-center">

              <!--  <div class="ms-auto">
                <a href="javascript:void(0);" class="text-body"><i class="bx bx-chat"></i> 15</a>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { userStore } from '../../../stores/UserStore'
import moment from 'moment'
import { localeData } from 'moment_spanish_locale'

export default {
  data() {
    return {
      projects: []
    }
  },
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  created() {
    moment.locale('es', localeData)
  },
  methods: {
    getMyProjects() {
      axios.get('/api/projects-user/' + this.store.authUser.id)
        .then(res => {
          this.projects = res.data
          var numTasks = 0
          var numTasksCompleted = 0
          this.projects.forEach(project => {
            project.deliveries.forEach(delivery => {
              numTasks = numTasks + delivery.assigned_activities.length
              delivery.assigned_activities.forEach(assigned => {
                if (assigned.status == 4) {
                  numTasksCompleted++
                }
              })
            })
            project.numTasks = numTasks
            project.numTasksCompleted = numTasksCompleted
          })
        })
        .catch(err => {

        })
    },
    formatDate(date) {
      return moment(date).format('DD/MM/yyyy')
    },
    formatDays(date) {
      return moment(date).endOf('day').fromNow();
    },
    percentageProject(project) {
      return parseFloat((100 / project.numTasks) * project.numTasksCompleted).toFixed(2)
    }
  },
  mounted() {
    this.getMyProjects()
  }
}
</script>
<style scoped></style>