<template>
    <div class="modal fade" id="permissionRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>{{ role }}</h4>
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
        role: String,
        permissions: Array
    },
    methods: {
        syncPermissions() {
            const fd = new FormData()
            fd.append('role', this.role)
            fd.append('permissions', JSON.stringify(this.selectedPermissions))
            axios.post('/api/permission-sync-role', fd)
                .then((result) => {
                    console.log(result);
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>