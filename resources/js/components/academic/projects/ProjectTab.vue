<template>
    <div class="row">
        <div class="col-md-4" id="directionArea" v-for="project in projectsFiltered">
            <div class="container-cards">
                <div class="card">
                    <div class="card-body">
                        <h5 @click="enterProject(project.id)" class="cursor-pointer" v-if="project.propertiable"
                            v-for="customer in project.propertiable.quotation.customers">
                            {{ customer.name }}
                        </h5>
                        <p v-if="project.propertiable.projects[0].team">Equipo: {{
                            project.propertiable.projects[0].team.name }}</p>
                        <router-link :to="{ name: 'profile-acad', params: { idProject: project.propertiable.id } }">
                            <i class='bx bx-file text-success'></i>
                        </router-link>
                        <i class='bx bx-check-double text-info cursor-pointer' @click="showModalAssignation(project)"></i>
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
        showModalAssignation(project) {
            this.$emit('showModalAssignation', project)
        },
        enterProject(projectId) {
            alert('nani' + projectId)
        }
    }
}

</script>