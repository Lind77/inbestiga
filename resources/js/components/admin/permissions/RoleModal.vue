<template>
    <div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Sincronizar Roles</h3>
                        <h6>Permiso: {{ permission.name }}</h6>
                    </div>
                    <h4>Roles</h4>
                    <div class="table-responsive">
                        <table class="table table-flush-spacing">
                            <tbody>
                                <tr v-for="rol in roles">
                                    <td class="text-nowrap fw-semibold">{{ rol.name }}
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="rol.id" :value="rol.name"
                                                v-model="selectedRoles">
                                            <label class="form-check-label" :for="rol.id">
                                                Seleccionar
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-center">
                        <button @click="syncRoles" class="btn btn-primary me-sm-3 me-1">Sincronizar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        permission: Object
    },
    data() {
        return {
            name: '',
            roles: [],
            selectedRoles: [],
            checkedNames: []
        }
    },
    methods: {
        syncRoles() {
            const fd = new FormData()
            fd.append('permission_id', this.permission.id)
            fd.append('roles', JSON.stringify(this.selectedRoles))
            axios.post('/api/permission-sync', fd)
                .then((result) => {
                    console.log(result);
                }).catch((err) => {
                    console.log(err);
                });
        },
        createPermission() {
            const fd = new FormData()
            fd.append('name', this.name)
            axios.post('/api/permissions', fd)
                .then((result) => {
                    console.log(result);
                    $('#modalPermission').modal('hide')
                }).catch((err) => {
                    console.log(err);
                });
        },
        getRoles() {
            axios.get('/api/roles-all')
                .then((result) => {
                    this.roles = result.data
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
    watch: {
        permission() {
            this.permission.roles.forEach(role => {
                this.selectedRoles.push(role.name);
            });
        }
    },
    mounted() {
        this.getRoles()
    }
}
</script>
<style lang="">
    
</style>