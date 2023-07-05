<template>
    <div class="modal fade" id="modalPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Gestionar Permisos - {{ user.name }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-flush-spacing">
                            <tbody>
                                <tr v-for="permission in permissions">
                                    <td class="text-nowrap fw-semibold">{{ permission.name }}
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="permission.id"
                                                :value="permission.name" v-model="selectedPermissions">
                                            <label class="form-check-label" :for="permission.id">
                                                Seleccionar
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button @click="syncPermissions" class="btn btn-primary me-sm-3 me-1">Sincronizar</button>
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
        user: Object
    },
    data() {
        return {
            name: '',
            permissions: [],
            selectedPermissions: []
        }
    },
    methods: {
        syncPermissions() {
            const fd = new FormData()
            fd.append('user_id', this.user.id)
            fd.append('permissions', JSON.stringify(this.selectedPermissions))
            axios.post('/api/permission-sync-user', fd)
                .then((result) => {
                    this.permissions = result.permissions
                }).catch((err) => {
                    console.error(err)
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
        getPermissions() {
            axios.get('/api/permissions')
                .then((result) => {
                    this.permissions = result.data
                }).catch((err) => {
                    console.error(err);
                });
        }
    },
    watch: {
        user() {
            console.log(this.user.permissions);
            if (this.user.permissions.length == 0) {
                this.selectedPermissions = []
            } else {
                this.user.permissions.forEach(permission => {
                    this.selectedPermissions.push(permission.name);
                });
            }
        }
    },
    mounted() {
        this.getPermissions()
    }
}
</script>
<style lang="">
    
</style>