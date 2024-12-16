<template>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proyecto</th>
                    <th>Autoasignar</th>
                    <!--  <th>Fechas</th> -->
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr v-for="project in projects">
                    <td>
                        <img
                            src="https://inbestiga.com/inbestiga/public/files/1709671609.png"
                            class="rounded"
                            width="50"
                            @click="toProject(project.id)"
                        />
                    </td>
                    <td>
                        <!-- <span class="fw-semibold" @click="editProjectTitle(project)">{{ project.title }}</span> -->
                        <ProjectName
                            :id="project.id"
                            :title="project.title"
                            :customers="project.projectable.quotation.customers"
                        />
                    </td>
                    <td>
                        <UpdateUser
                            :project="project"
                            :acadUsers="acadUsers"
                            v-if="store.authUser.roles[0].name == 'AdminAcad'"
                        />
                        <button
                            v-if="
                                store.authUser.subarea_id == 4 &&
                                project.user.subarea_id != 4
                            "
                            class="btn btn-icon btn-success"
                            @click="updateUser(project)"
                        >
                            <i class="bx bx-user-check"></i>
                        </button>
                        <button class="btn btn-primary" v-else>
                            {{ project.user.name }}
                        </button>
                    </td>
                    <!--  <td>
                        <p>{{ project.deadline }}</p>
                    </td> -->
                    <td>
                        <div class="btn-group">
                            <button
                                type="button"
                                :class="`btn btn-${
                                    statusColor[project.status].color
                                } dropdown-toggle hide-arrow`"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ statusColor[project.status].title }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a
                                        class="dropdown-item"
                                        @click="updateStatus(project, 0)"
                                        href="javascript:void(0);"
                                        >Pendiente</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        @click="updateStatus(project, 1)"
                                        href="javascript:void(0);"
                                        >Progreso</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        @click="updateStatus(project, 2)"
                                        href="javascript:void(0);"
                                        >Completo</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        @click="updateStatus(project, 3)"
                                        href="javascript:void(0);"
                                        >Stand by</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button
                                type="button"
                                class="btn p-0 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown"
                            >
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0);"
                                    @click="
                                        showProjectFile(
                                            project.projectable.quotation_id
                                        )
                                    "
                                    ><i class="bx bx-file me-1"></i> Ficha</a
                                >
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0);"
                                    ><i class="bx bx-edit-alt me-1"></i>
                                    Editar</a
                                >
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0);"
                                    ><i class="bx bx-trash me-1"></i>
                                    Eliminar</a
                                >
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import ProjectName from "./ProjectName.vue";
import { userStore } from "../../../stores/UserStore";
import UpdateUser from "./UpdateUser.vue";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            showField: false,
            statusColor: {
                0: {
                    color: "warning",
                    title: "Pendiente",
                },
                1: {
                    color: "info",
                    title: "En Progreso",
                },
                2: {
                    color: "success",
                    title: "Completado",
                },
                3: {
                    color: "danger",
                    title: "Stand by",
                },
            },
            teamSelected: 0,
            showSelectTeam: true,
            acadUsers: [],
            newAcadUserSelected: 0,
        };
    },
    components: { ProjectName, UpdateUser },
    props: {
        projects: Array,
        teams: Array,
    },
    methods: {
        updateUser(project) {
            if (this.store.authUser.subarea_id == 4) {
                axios
                    .get(
                        "/api/update-user-project/" +
                            this.store.authUser.id +
                            "/" +
                            project.id
                    )
                    .then((result) => {
                        project.user = this.store.authUser;
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } else {
                this.$swal("No tienes permisos para realizar esta acción");
            }
        },
        showTeamModal(project) {
            this.$emit("showTeamModal", project);
        },
        updateStatus(project, newStatus) {
            project.status = newStatus;
            axios
                .get(
                    "/api/update-project-status/" + project.id + "/" + newStatus
                )
                .then((result) => {
                    $(".dropdown-menu").removeClass("show");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        updateTeam(project, team) {
            var newTeam = {
                name: team.name,
            };
            project.team = newTeam;
            const fd = new FormData();
            fd.append("contract_id", project.id);
            fd.append("team_selected", team.id);
            axios
                .post("/api/assignTeam", fd)
                .then((res) => {
                    $(".dropdown-menu").removeClass("show");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        showProjectFile(projectId) {
            window.open("../home/documentation/" + projectId, "_blank");
        },
        toProject(projectId) {
            this.$router.push({
                name: "project",
                params: { idProject: projectId },
            });
        },
        getAcadUsers() {
            axios
                .get("/api/acad-users")
                .then((response) => {
                    this.acadUsers = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getAcadUsers();
    },
};
</script>
