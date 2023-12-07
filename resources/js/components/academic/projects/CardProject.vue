<template>
    <div class="col-4">
        <div class="card mb-3 bg-red cursor-move">
            <p>{{ project }}</p>
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