<template>
    <div :class="`card mb-3 bg-light cursor-move`" draggable="true" @dragstart="drag" :id="`${project.id}`">
        <!-- <div class="card-header">
        <p class="mb-0">{{ project.textStatus }}</p>
    </div> -->
        <div class="card-body">
            <div class="badge rounded-pill bg-label-success"> {{ project.title }}</div>
            <!-- <div class="h6 text-white" v-if="project.team">Equipo {{ project.team.name }}</div> -->
            <h4 class="card-title h5 mt-3">{{ project.title }}</h4>
            <router-link v-if="project.status == 1" :to="{ name: 'kanban', params: { idProject: project.id } }">
                <i class='bx bx-table'></i>
            </router-link>
            <router-link v-if="project.status == 1" :to="{ name: 'profile-acad', params: { idProject: project.id } }">
                <i class='bx bx-file text-success'></i>
            </router-link>
            <i v-if="project.status == 2" class='bx bx-list-check text-primary cursor-pointer'
                @click="showQualityModal"></i>
            <router-link v-if="project.status == 0" target="_blank"
                :to="{ name: 'ecard', params: { id: project.customer.id } }"><i
                    class='bx bx-credit-card-alt'></i></router-link>
            <i class='bx bx-trash text-danger cursor-pointer' @click="deleteProject(project.id)"></i>

            <i v-if="project.numTasksCompleted / project.numTasks == 1 && project.status == 1" @click="updateQuality"
                class='bx bx-check-circle text-success cursor-pointer'></i>
            <!-- <template v-if="project.status == 0">
            <p v-for="activity in project.activities">
            {{ activity.title }}
            <i v-if="activity.isCompleted" class='bx bx-check-circle text-success'></i>
            <i v-else class='bx bx-x-circle text-danger'></i>
            </p>
        </template>
        -->
        </div>
    </div>
</template>
<script>
import { userStore } from '../../../stores/UserStore'

export default {
    name: 'CardProject',
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    data() {
        return {
            project_selected: {}
        }
    },
    props: {
        project: Object
    },
    methods: {
        showQualityModal() {
            var qualityActivities = this.project.activities.filter(activity => activity.type == 2)
            this.$emit('showQualityModal', qualityActivities)
        },
        deleteProject(id) {
            if (confirm('Desea eliminar este proyecto con seguridad?')) {
                axios.get(`/api/deleteProject/${id}`)
                    .then(res => {
                        this.$swal('Proyecto eliminado.')
                        this.$emit('getAllProjects')
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
        pointsQual() {
            $('#qualityModal').modal('show')
        },
        drag(e) {
            e.dataTransfer.setData('text', e.target.id)
        },
        updateQuality() {
            axios.get(`/api/updateQuality/${this.project.id}`)
                .then(res => {
                    console.log(res)
                    this.$emit('getAllProjects')
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    computed: {
        bgColor() {
            if (this.project.status == 0) {
                return 'bg-danger'
            } else if (this.project.status == 1) {
                return 'bg-success'
            } else if (this.project.status == 2) {
                return 'bg-warning'
            }
        }
    }
}
</script>