<template>
    <div class="modal fade" id="updateComModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Actualizar Comunicación</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Última Gestión</label>
                        <input type="date" v-model="comunication.last_management" class="form-control">
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Próxima Gestión</label>
                        <input type="date" v-model="comunication.next_management" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Comentario</label>
                        <input type="text" v-model="comunication.comment" class="form-control"/>
                        </div>
                        
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Producto Tentativo</label>
                        <input type="text" v-model="comunication.product_tentative" class="form-control"/>
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Tipo</label>
                        <select v-model="comunication.type" class="form-select">
                            <option value="1">Llamar</option>
                            <option value="2">Escribir</option>
                            <option value="3">Meet</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="close-insert-customer" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" @click="updateComunication" class="btn btn-primary">Actualizar</button>
                </div>
                <!-- {{ comunication }} -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:{
            comunication: Object
        },
        methods:{
            updateComunication(){
                const fd = new FormData()
                fd.append('comunication_id', this.comunication.id)
                fd.append('last_management', this.comunication.last_management)
                fd.append('next_management', this.comunication.next_management)
                fd.append('comment', this.comunication.comment)
                fd.append('product_tentative', this.comunication.product_tentative)
                fd.append('type', this.comunication.type)

                axios.post('/api/updateComunication', fd)
                .then((res) =>{
                    console.log(res)
                    $('#updateComModal').modal('hide')
                })
                .catch((err) =>{
                    console.log(err)
                })
            }
        }
    }
</script>
