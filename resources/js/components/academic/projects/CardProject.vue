<template>
    <div class="col-md-4">
        <div class="card mb-3 bg-secondary">
            <div class="card-header">
                <img src="https://preview.keenthemes.com/metronic8/demo1/assets/media/svg/brand-logos/kanba.svg"
                    class="rounded" width="30">
            </div>
            <div class="card-body">
                <template v-if="project.propertiable">
                    <h5 class="text-white" v-if="project.propertiable.projects[0]">{{ project.propertiable.projects[0].title
                    }}</h5>
                    <p class="text-dark fw-bold" v-for="customer in project.propertiable.quotation.customers">{{
                        customer.name }}
                    </p>
                </template>

            </div>
            <div class="card-footer">
                <div class="demo-inline-spacing">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                class="bx bx-dots-vertical-rounded"></i></button>
                        <ul class="dropdown-menu dropdown-menu-start" style="">
                            <li><a class="dropdown-item" href="javascript:void(0);"
                                    @click="deleteProject(project.id)">Eliminar</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                        </ul>
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