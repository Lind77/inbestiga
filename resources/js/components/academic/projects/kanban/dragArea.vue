<template>
  <div class="col">

    <div class="kanban-header fw-bold">
      <h4>{{ title }} ({{ tasks.filter(task => task.status == status).length }})</h4>
    </div>
    <div :id="'draggableKanban' + status" class="container-cards overflow-auto vh-100" @drop="drop" @dragenter.prevent
      @dragover.prevent>
      <template v-for="(task, index) in tasks" :key="index">
        <CardTask :task="task" />
      </template>
    </div>
  </div>
</template>
<script>
import CardTask from './CardTask.vue'
import { userStore } from '../../../../stores/UserStore'

export default {
  components: { CardTask },
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  props: {
    title: String,
    tasks: Array,
    status: Number
  },
  methods: {
    drop(e) {
      let card = e.dataTransfer.getData('text')
      let owner = e.dataTransfer.getData('owner')
      /*   e.target.appendChild(document.getElementById(card)) */
      if (this.status == 2) {
        if (this.store.authUser.name == owner) {
          this.$emit('updateTask', card, this.status)
        } else {
          this.$swal('A usted no le pertenece esta tarea')
        }
      } else {
        this.$emit('updateTask', card, this.status)
      }
    }
  }
}
</script>
<style scoped>
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: rgba(67, 89, 113, 0.075);
  border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgba(67, 89, 113, .7);
}
</style>