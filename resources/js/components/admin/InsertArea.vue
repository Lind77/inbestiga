<template>
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Crear Area</h5>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Salir
                </button>
                <button type="button" class="btn btn-primary" @click="createArea">Crear</button>
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
            }
        },
        methods:{
            createArea(){
                const fd = new FormData()
                fd.append('name', this.name)
                axios.post('/api/areas', fd)
                .then(res =>{
                    this.$emit('getAllAreas')
                    $('#userModal').modal('hide')
                })
                .catch(err =>{
                    console.log(err)
                })
            }
        },
        mounted(){
            this.getAreas()
        }
    }
</script>