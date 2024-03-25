<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Departamento Académico /</span> Inicio</h4>
    <h3>Te damos la bienvenida, {{ store.authUser ? store.authUser.name : '' }}</h3>
    <div class="card bg-info" v-if="store.authUser.roles[0].name == 'CoordAcad'">
      <div class="card-header">
        <h4 class="fw-semibold text-white">Tareas pendientes de revisión</h4>
      </div>
      <div class="card-body">
        <template v-for="task in tasksToRevision">
          <CardTask :activity="task" />
        </template>
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
    }
  },
  mounted() {
    this.getRevisionTaks()
  }
}
</script>