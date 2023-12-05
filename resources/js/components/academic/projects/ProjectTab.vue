<template>
    <div class="row">
        <div class="col-md-4" id="directionArea" v-for="project in projectsFiltered">
            <div class="container-cards">
                <div class="card">
                    <div class="card-body">
                        <p @click="openKanban(project)" class="h5 cursor-pointer" v-if="project.propertiable"
                            v-for="customer in project.propertiable.quotation.customers">
                            {{ customer.name }}
                        </p>
                        <div class="card-footer">
                            <p v-if="project.propertiable.projects[0].team">Equipo: {{
                                project.propertiable.projects[0].team.name }}</p>
                            <router-link :to="{ name: 'profile-acad', params: { idProject: project.propertiable.id } }">
                                <i class='bx bx-file text-success'></i>
                            </router-link>
                            <i class='bx bx-check-double text-info cursor-pointer'
                                @click="showModalAssignation(project)"></i>
                            <i class='bx bx-poll text-primary cursor-pointer' @click="enterProject(project)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        projectsFiltered: Array
    },
    methods: {
        openKanban(project) {
            console.log(project.propertiable.projects);
            if (project.propertiable.projects[0].status == 1) {
                this.$router.push({ name: 'kanban', params: { idProject: project.propertiable.projects[0].id } })
            } else {
                this.$swal('Este proyecto aun no tiene sprints')
            }
        },
        showModalAssignation(project) {
            this.$emit('showModalAssignation', project)
        },
        enterProject(project) {
            console.log(project.propertiable.projects[0].id)
            this.$router.push({ name: 'sprint', params: { idProject: project.propertiable.projects[0].id } })
        }
    }
}

</script>