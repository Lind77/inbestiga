<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header d-flex align-items-center justify-content-between">Usuarios
                <button @click="addUser" class="btn btn-secondary add-new btn-primary w-25" type="button"><span><i
                            class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Nuevo
                            Usuario</span></span></button>
            </h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Área</th>
                            <th>Rol</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr v-for="user in users">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.subarea.area.name }}</td>
                            <td>{{ user.roles[0].name }}</td>
                            <td>
                                <span v-if="user.id != 1" @click="deleteUser(user.id)"
                                    class="badge bg-label-danger me-1 cursor-pointer"><i class='bx bx-trash'></i>
                                </span>
                                <span v-if="user.id != 1" class="badge bg-label-primary me-1 cursor-pointer"
                                    @click="showPermissionModal(user)"><i class='bx bx-dialpad-alt'></i>
                                </span>
                                <span class="badge bg-label-primary me-1 cursor-pointer" @click="showRoleUpdate(user)"><i
                                        class='bx bx-edit'></i>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <InsertUser @getAllUsers="getAllUsers" />
        <PermissionsModal :user="userSelected" />
        <RoleModal :user="userSelected" />
    </div>
</template>
<script>
import InsertUser from './InsertUser.vue'
import PermissionsModal from './PermissionsModal.vue'
import RoleModal from './RoleModal.vue'
export default {
    components: { InsertUser, PermissionsModal, RoleModal },
    data() {
        return {
            users: [],
            area: {
                'admin': 'Administración',
                'sales': 'Ventas',
                'acad': 'Académico',
                'experience': 'Experiencia del Inbestigador'
            },
            userSelected: {}
        }
    },
    methods: {
        showRoleUpdate(user) {
            this.userSelected = user
            $('#roleModal').modal('show');
        },
        showPermissionModal(user) {
            $('#modalPermission').modal('show');
            this.userSelected = user
        },
        getAllUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
        addUser() {
            $('#userModal').modal('show')
        },
        deleteUser(id) {
            this.$swal({
                title: '¿Deseas eliminar a este usuario?',
                icon: 'question',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'No'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/api/users/${id}`)
                            .then(res => {
                                this.getAllUsers()
                            })
                            .catch(err => {
                                console.log(err)
                            })
                    } else {
                        this.$swal.close()
                    }
                })

        }
    },
    mounted() {
        this.getAllUsers()
    }
}
</script>