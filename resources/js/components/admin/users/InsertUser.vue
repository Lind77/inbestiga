<template>
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Crear usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Nombre</label>
                            <input type="text" v-model="name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Correo</label>
                            <input type="email" v-model="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Password</label>
                            <input type="password" v-model="password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Área</label>
                            <select v-model="area" class="form-select">
                                <option :value="area.id" v-for="area in areas">{{ area.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" v-show="subareasFiltered.length > 0">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Sub-area</label>
                            <select v-model="subarea" class="form-select">
                                <option :value="subarea.id" v-for="subarea in subareasFiltered">{{ subarea.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row" v-show="roles.length > 0">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Rol</label>
                            <select v-model="rol" class="form-select">
                                <option :value="rol.id" v-for="rol in roles">{{ rol.name }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Salir
                    </button>
                    <button type="button" class="btn btn-primary" @click="createUser">Crear</button>
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
            name: '',
            email: '',
            password: '',
            rol: '',
            area: '',
            roles: [],
            areas: [],
            subareas: [],
            subareasFiltered: [],
            subarea: 0
        }
    },
    methods: {
        createUser() {
            const fd = new FormData()
            fd.append('name', this.name)
            fd.append('email', this.email)
            fd.append('password', this.password)
            fd.append('rol', this.rol)
            fd.append('subarea_id', this.subarea)

            axios.post('/api/users', fd)
                .then(res => {
                    this.$emit('getAllUsers')
                    $('#userModal').modal('hide')
                })
                .catch(err => {
                    console.log(err)
                })
        },
        getAllAreas() {
            axios.get('/api/areas')
                .then(res => {
                    this.areas = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
        getSubAreas() {
            axios.get('/api/subareas')
                .then((result) => {
                    this.subareas = result.data
                }).catch((err) => {
                    console.error(err);
                });
        }
    },
    watch: {
        area(newValue, oldValue) {
            this.subareasFiltered = this.subareas.filter(subarea => subarea.area.id == this.area)
        },
        subarea(newValue, oldValue) {
            console.log(this.subarea);
            var subareaSelected = this.subareas.find(subarea => subarea.id == this.subarea)
            this.roles = subareaSelected.roles
        }
    },
    mounted() {
        this.getAllAreas()
        this.getSubAreas()
    }
}
</script>