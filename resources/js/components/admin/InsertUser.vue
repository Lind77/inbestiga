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
                password: ''
            }
        },
        methods:{
            createUser(){
                const fd = new FormData()
                fd.append('name', this.name)
                fd.append('email', this.email)
                fd.append('password', this.password)

                axios.post('/api/createUser', fd)
                .then(res =>{
                    this.$emit('getAllUsers')
                })
                .catch(err =>{
                    console.log(err)
                })
            }
        }
    }
</script>