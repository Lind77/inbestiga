<template>
    <div class="col">
        <div class="card mb-3 bg-success">
            <div class="card-header">
                <img src="https://inbestiga.com/wp-content/uploads/2023/10/cropped-logo-Inbestiga.png" class="rounded"
                    width="30">
                <i class="bx bx-info-circle text-danger" title="No se ha rellenado la ficha"
                    v-if="project.projectable && project.projectable.properties.length == 0"></i>
            </div>
            <div class="card-body">
                <h4 class="text-white cursor-pointer" @click="showProject(project)">{{
                    project.title
                }}</h4>
                <h6 class="text-dark fw-bold" v-for="customer in project.projectable.quotation.customers">{{
                    customer.name }}</h6>
            </div>
            <div class="card-footer">
                <div class="demo-inline-spacing">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                class="bx bx-dots-vertical-rounded"></i></button>
                        <ul class="dropdown-menu dropdown-menu-start" style="">
                            <li><a class="dropdown-item" href="javascript:void(0);"
                                    @click="deleteProject(project)">Eliminar</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="toDocumentation(project)">Ver
                                    Ficha</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="showTeamModel(project)">Asignar
                                    Equipo</a></li>
                        </ul>
                        <div class="text-white ms-2" v-if="project.team">{{ project.team.name }}</div>
                        <div class="text-white ms-2 cursor-pointer" @click="showTeamModel(project)" v-else>Sin equipo</div>
                    </div>
                </div>
            </div>
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
        showTeamModel(project) {
            this.$emit('showTeamModal', project.id)
        },
        toProjectKanban() {
            console.log(this.project);
            if (project.propertiable.projects[0]) {
                this.$router.push({ name: 'kanban', params: { idProject: project.propertiable.projects[0].id } })
            }
        },
        showQualityModal() {
            var qualityActivities = this.project.activities.filter(activity => activity.type == 2)
            this.$emit('showQualityModal', qualityActivities)
        },
        deleteProject(project) {
            if (confirm('Desea eliminar este proyecto con seguridad?')) {
                axios.get(`/api/deleteProject/${project.id}`)
                    .then(res => {
                        this.$swal('Proyecto eliminado.')
                        this.$emit('getAllProjectsAcad')
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
        showProject() {
            this.$router.push({ name: 'project', params: { idProject: this.project.id } })
        },
        toDocumentation(project) {
            console.log(project);
            this.$router.push({ name: 'home-documentation', params: { quotationId: this.project.projectable.quotation_id } })
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