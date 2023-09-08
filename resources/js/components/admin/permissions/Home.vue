<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Lista de Permisos</h4>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row d-flex justify-content-end">
                        <button class="btn btn-primary w-25" @click="showModalPermission">Agregar</button>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Asignado a</th>
                                <th>Fecha de Creación</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr v-for="permission in permissions">
                                <td>{{ permission.name }}</td>
                                <td><span v-for="rol in permission.roles" class="badge bg-label-primary me-1">{{ rol.name
                                }}</span>
                                </td>
                                <td>
                                    {{ permission.created_at }}
                                </td>
                                <td>
                                    <span class="text-nowrap">
                                        <button class="btn btn-sm btn-icon me-2" @click="modalEditRoles(permission)">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon me-2" @click="modalRoles(permission)">
                                            <i class="bx bx-dialpad-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i>
                                        </button>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <PermissionModal @getPermissions="getPermissions" :permissionSelected="permissionSelected" :action="action" />
    <RoleModal :permission="permissionSelected" />
</template>
<script>
import PermissionModal from './PermissionModal.vue'
import RoleModal from './RoleModal.vue';

export default {
    components: { PermissionModal, RoleModal },
    data() {
        return {
            users: [],
            permissions: [],
            permissionSelected: {},
            action: 0
        }
    },
    methods: {
        modalEditRoles(permission) {
            this.action = 2
            this.permissionSelected = permission
            $('#modalPermission').modal('show')
        },
        modalRoles(permission) {
            this.permissionSelected = permission
            $('#modalRole').modal('show')
        },
        getPermissions() {
            axios.get('/api/permissions')
                .then((result) => {
                    this.permissions = result.data
                }).catch((err) => {
                    console.log(err);
                });
        },
        showModalPermission() {
            this.action = 1
            $('#modalPermission').modal('show')
        },
        getAllUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        }
    },
    mounted() {
        this.getAllUsers()
        this.getPermissions()
    }
}
</script>
