<template>
    <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3>Actualizar Rol</h3>
                    </div>
                    <div class="">
                        <select v-model="roleSelected" class="form-control">
                            <option :value="role.id" v-for="role in roles">{{
                                role.name }}</option>
                        </select>
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button @click="updateRole" class="btn btn-primary me-sm-3 me-1">Actualizar</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            subareas: [],
            roles: [],
            roleSelected: 0
        }
    },
    props: {
        user: Object
    },
    methods: {
        updateRole() {
            const fd = new FormData()
            fd.append('newRole', this.roleSelected)
            fd.append('_method', 'put')

            axios.post(`/api/roles/${this.user.id}`, fd)
                .then((result) => {
                    $('#roleModal').modal('hide')
                    this.$swal('Rol actualizado correctamente')
                }).catch((err) => {
                    console.error(err)
                });
        },
        getSubAreas() {
            axios.get('/api/subareas')
                .then((result) => {
                    this.subareas = result.data
                    this.subareas.forEach((subarea) => {
                        console.log(subarea.roles)
                        if (subarea.roles) {
                            subarea.roles.forEach((role) => {
                                this.roles.push({ ...role })
                            })
                        }
                    })
                }).catch((err) => {
                    console.error(err);
                });
        }
    },
    mounted() {
        this.getSubAreas()
    }
}
</script>
<style lang="">
    
</style>