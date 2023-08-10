<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Solicitudes de permiso</h4>
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center" v-for="permission in permissions">
                <p>{{ permission.user.name }} solicitó permiso para la fecha: {{ permission.miss_date }} de
                    {{ permission.miss_time_admission }} a {{ permission.miss_time_departure }}, hora que se recuperará el
                    día: {{ permission.recovery_date }} de {{ permission.recovery_time_admission }} a
                    {{ permission.recovery_time_departure }}.
                </p>
                <div class="buttons" v-if="permission.status == 0">
                    <button type="button" class="btn btn-icon btn-success ms-1" @click="acceptRequest(permission)">
                        <span class="tf-icons bx bx-check"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger ms-1" @click="rejectRequest(permission)">
                        <span class="tf-icons bx bx-x"></span>
                    </button>
                </div>

            </li>
        </ul>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            permissions: []
        }
    },
    methods: {
        acceptRequest(permission) {
            axios.get('/api/accept-permit/' + permission.id)
                .then((result) => {
                    var permissionUpdated = this.permissions.find(permission => permission.id == permission.id)
                    permissionUpdated.status = result.data
                }).catch((err) => {
                    console.log(err);
                });
        },
        rejectRequest(permission) {
            axios.get('/api/reject-permit/' + permission.id)
                .then((result) => {
                    var permissionUpdated = this.permissions.find(permission => permission.id == permission.id)
                    permissionUpdated.status = result.data
                }).catch((err) => {
                    console.log(err);
                });
        },
        getPermissionsRequest() {
            axios.get('/api/attendance-permits')
                .then((result) => {
                    this.permissions = result.data
                }).catch((err) => {
                    console.log(err)
                });
        }
    },
    mounted() {
        this.getPermissionsRequest()
    }
}
</script>
<style lang="">
    
</style>