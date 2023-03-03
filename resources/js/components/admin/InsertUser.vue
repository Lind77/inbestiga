<template>
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Crear usuario</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
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
                        <label for="nameSmall" class="form-label">Rol</label>
                        <select v-model="rol" class="form-select">
                            <option :value="rol" v-for="rol in roles">{{ rol }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameSmall" class="form-label">Área</label>
                        <select v-model="area" class="form-select">
                            <option value="acad">Acádemica</option>
                            <option value="experience">Experiencia</option>
                            <option value="sales">Ventas</option>
                            <option value="admin">Administrativa</option>
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

    export default{
        data(){
            return {
                name:'',
                email: '',
                password: '',
                rol: '',
                area:'',
                roles:[]
            }
        },
        methods:{
            createUser(){
                const fd = new FormData()
                fd.append('name', this.name)
                fd.append('email', this.email)
                fd.append('password', this.password)
                fd.append('rol', this.rol)
                fd.append('area', this.area)

                axios.post('/api/createUser', fd)
                .then(res =>{
                    this.$emit('getAllUsers')
                    $('#userModal').modal('hide')
                })
                .catch(err =>{
                    console.log(err)
                })
            },
            getRoles(){
                axios.get('/api/getRoles')
                .then(res =>{
                    this.roles = res.data
                    console.log(res)
                })
                .catch(err =>{
                    console.log(err)
                })
            }
        },
        mounted(){
            this.getRoles()
        }
    }
</script>