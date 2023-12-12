<template>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proyecto</th>
                    <th>Equipo</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Fechas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr v-for="project in projects">
                    <td>
                        <i class="bx bxl-angular bx-sm text-danger me-3"></i>
                    </td>
                    <td><span class="fw-medium" v-if="project.propertiable && project.propertiable.projects[0]">{{
                        project.propertiable.projects[0].title
                    }}</span>
                    </td>
                    <td>
                        <p v-if="project.propertiable && project.propertiable.projects[0]">{{
                            project.propertiable.projects[0].team_id }}</p>
                    </td>
                    <td>
                        <template v-if="project.propertiable && project.propertiable.projects[0]">
                            <p v-for="customer in project.propertiable.quotation.customers">{{ customer.name }}</p>
                        </template>
                    </td>
                    <td><span v-if="project.propertiable && project.propertiable.projects[0]"
                            class="badge bg-label-primary me-1">{{ project.propertiable.projects[0].status }}</span></td>
                    <td>
                        <p v-if="project.propertiable && project.propertiable.projects[0]">{{
                            project.propertiable.projects[0].deadline }}</p>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                    class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                    Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                    Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        projects: Array
    },
}
</script>
<style lang="">
    
</style>