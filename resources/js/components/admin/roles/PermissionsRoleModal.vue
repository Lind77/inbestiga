<template>
    <div class="modal fade" id="permissionRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>{{ role.name }}</h4>
                    <div class="row">
                        <div class="col-md-3" v-for="permission in permissions">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" :id="permission.id" :value="permission.name"
                                    v-model="selectedPermissions">
                                <label class="form-check-label" :for="permission.id">
                                    {{ permission.name }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
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
export default {
    data() {
        return {
            selectedPermissions: []
        }
    },
    props: {
        role: Object,
        permissions: Array
    },
    methods: {
        syncPermissions() {
            const fd = new FormData()
            fd.append('role', this.role.name)
            fd.append('permissions', JSON.stringify(this.selectedPermissions))
            axios.post('/api/permission-sync-role', fd)
                .then((result) => {
                    console.log(result);
                    $('#permissionRoleModal').modal('hide')
                    this.$swal('Permisos actualizados correctamente')
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
    mounted() {
    },
    watch: {
        role() {
            if (this.role.permissions.length > 0) {
                this.selectedPermissions = []
                this.role.permissions.forEach(permission => {
                    this.selectedPermissions.push(permission.name)
                });
            } else {
                this.selectedPermissions = []
            }
        }
    }
}
</script>