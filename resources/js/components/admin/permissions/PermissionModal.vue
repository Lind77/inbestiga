<template>
    <div class="modal fade" id="modalPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Agregar Permiso</h3>
                    </div>
                    <form v-if="action == 1" id="addPermissionForm" @submit="createPermission"
                        class="row fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false"
                        novalidate="novalidate">
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre del Permiso</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre del permiso" v-model="permission.name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre en el Sidebar</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre del link" v-model="permission.siderbar_name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre de Ruta</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre de route" v-model="permission.route_name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Icono</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Icono" v-model="permission.icon_class">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Crear Permiso</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                        <input type="hidden">
                    </form>
                    <form v-else id="addPermissionForm" @submit="updatePermission"
                        class="row fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false"
                        novalidate="novalidate">
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre del Permiso</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre del permiso" v-model="permissionSelected.name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre en el Sidebar</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre del link" v-model="permissionSelected.siderbar_name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre de Ruta</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre de route" v-model="permissionSelected.route_name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Icono</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Icono" v-model="permissionSelected.icon_class">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Actualizar Permiso</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        permissionSelected: Object,
        action: Number
    },
    data() {
        return {
            permission: {
                name: '',
                siderbar_name: '',
                route_name: '',
                icon_class: ''
            }

        }
    },
    methods: {
        createPermission() {
            const fd = new FormData()
            fd.append('name', this.permission.name)
            fd.append('siderbar_name', this.permission.siderbar_name)
            fd.append('route_name', this.permission.route_name)
            fd.append('icon_class', this.permission.icon_class)
            axios.post('/api/permissions', fd)
                .then((result) => {
                    console.log(result);
                    $('#modalPermission').modal('hide')
                    this.$emit('getPermissions')
                }).catch((err) => {
                    console.log(err);
                });
        },
        updatePermission() {
            const fd = new FormData()
            fd.append('name', this.permissionSelected.name)
            fd.append('siderbar_name', this.permissionSelected.siderbar_name)
            fd.append('route_name', this.permissionSelected.route_name)
            fd.append('icon_class', this.permissionSelected.icon_class)
            fd.append('_method', 'put')
            axios.post('/api/permissions/' + this.permissionSelected.id, fd)
                .then((result) => {
                    console.log(result);
                    $('#modalPermission').modal('hide')
                    this.$emit('getPermissions')
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>
<style lang="">
    
</style>