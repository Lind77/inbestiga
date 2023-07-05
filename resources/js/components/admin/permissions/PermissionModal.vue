<template>
    <div class="modal fade" id="modalPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Agregar Permiso</h3>
                    </div>
                    <form id="addPermissionForm" @submit="createPermission"
                        class="row fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false"
                        novalidate="novalidate">
                        <div class="col-12 mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="modalPermissionName">Nombre del Permiso</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control"
                                placeholder="Nombre del permiso" v-model="name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Crear Permiso</button>
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
    data() {
        return {
            name: ''
        }
    },
    methods: {
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
        }
    }
}
</script>
<style lang="">
    
</style>