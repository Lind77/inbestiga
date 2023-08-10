<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Solicitudes de permiso</h4>
        <ul class="list-group">
            <template v-for="permission in permissions">
                <li class="list-group-item d-flex align-items-center justify-content-between bg-white">
                    <div class="d-flex align-items-center">
                        <div class="name">
                            <h5>{{ permission.user.name }}</h5>
                        </div>
                        <div class="ms-3">
                            <p> Fecha: {{ permission.miss_date }} de
                                {{ permission.miss_time_admission }} a {{ permission.miss_time_departure }}
                            </p>
                            <p>Recuperación: {{ permission.recovery_date }} de {{ permission.recovery_time_admission }} a
                                {{ permission.recovery_time_departure }}.</p>

                        </div>
                        <div>
                            <span
                                :class="`badge bg-${statusColor[permission.status]} ms-4`">{{ statusTitle[permission.status] }}</span>
                        </div>
                    </div>
                    <Buttons :permission="permission" @updateStatus="updateStatus" />
                </li>
            </template>

        </ul>
    </div>
</template>
<script>
import axios from 'axios';
import Buttons from './Buttons.vue'

export default {
    data() {
        return {
            permissions: [],
            statusColor: {
                0: 'secondary',
                1: 'success',
                2: 'danger',
                3: 'warning',
                4: 'info',
                5: 'dark'
            },
            statusTitle: {
                0: 'Petición',
                1: 'Aprobado',
                2: 'Rechazado',
                3: 'Cumplido',
                4: 'No Cumplido',
                5: 'Cancelado'
            }
        }
    },
    components: { Buttons },
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
        },
        updateStatus(permissionId, newStatus) {
            var permissionUpdated = this.permissions.find(permission => permission.id == permissionId)
            permissionUpdated.status = newStatus
        }
    },
    mounted() {
        this.getPermissionsRequest()
    }
}
</script>
<style lang="">
    
</style>