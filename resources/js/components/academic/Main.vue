<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Departamento Académico /</span> Inicio</h4>
    <h3>Te damos la bienvenida, {{ store.authUser ? store.authUser.name : '' }}</h3>
    <h4 class="fw-normal pt-3">Tareas pendientes de revisión</h4>
    <div class="row" v-if="store.authUser.roles[0].name == 'CoordAcad'">
      <div class="col-lg-3 col-sm-6 mb-4" v-for="task in tasksToRevision">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="card-info">
                <p class="card-text">{{ task.user.name }}</p>
                <div class="d-flex align-items-end mb-2">
                  <h4 class="card-title mb-0 me-2">{{ task.points }}</h4>
                  <small class="text-success" @click="approveTask(task.id)">Aprobar</small>
                </div>
                <small :title="task.name">{{ task.name.substring(0, 20) + '...' }}</small>
              </div>
              <div class="card-icon">
                <span class="badge bg-label-primary rounded p-2">
                  <i class="bx bx-trending-up bx-sm"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { userStore } from '../../stores/UserStore';
import CardTask from './projects/kanban/CardTask.vue';

export default {
  components: { CardTask },
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  data() {
    return {
      tasksToRevision: []
    }
  },
  methods: {
    getRevisionTaks() {
      axios.get('/api/assigned-activities-revision')
        .then((result) => {
          this.tasksToRevision = result.data
        }).catch((err) => {
          console.log(err)
        });
    },
    approveTask(taskId) {
      axios.get('/api/approve-activities/' + taskId)
        .then((result) => {
          this.getRevisionTaks()
        }).catch((err) => {
          console.log(err)
        });
    }
  },
  mounted() {
    this.getRevisionTaks()
  }
}
</script>