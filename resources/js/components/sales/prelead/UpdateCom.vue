<template>
    <div class="modal fade" id="updateComModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1" v-if="comunication != null">Actualizar Comunicación</h5>
                    <h5 class="modal-title" id="exampleModalLabel1" v-else>Insertar Comunicación</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">Última Gestión</label>
                            <input type="date" v-if="action==2" v-model="comunication.last_management" class="form-control" />
                            <input type="date" v-else v-model="last_management" class="form-control" />
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Próxima Gestión</label>
                        <input type="datetime-local" v-if="action==2" v-model="comunication.next_management" class="form-control" />
                        <input type="datetime-local" v-else v-model="next_management" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Comentario</label>
                        <input type="text" v-if="action==2" v-model="comunication.comment" class="form-control" />
                        <input type="text" v-else v-model="comment" class="form-control"/>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Producto Tentativo</label>
                        <input type="text" v-if="action==2" v-model="comunication.product_tentative" class="form-control" />
                        <input type="text" v-model="product_tentative" class="form-control"/>
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Tipo</label>
                        <select v-if="action==2" v-model="comunication.type" class="form-select">
                            <option value="1">Llamar</option>
                            <option value="2">Escribir</option>
                            <option value="3">Meet</option>
                        </select>
                        <select v-else v-model="type" class="form-select">
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
                <button v-if="action==2" type="button" @click="updateComunication" class="btn btn-primary">Actualizar</button>
                <button v-else type="button" @click="insertComunication" class="btn btn-primary">Registrar</button>
                </div>
                <!-- {{ comunication }} -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                last_management: '',
                next_management: '',
                comment: '',
                product_tentative: '',
                type: 0
            }
        },
        props:{
            action: Number,
            comunication: Object,
            customerId: Number
        },
        methods:{
            insertComunication(){
                const fd = new FormData()
                fd.append('customer_id', this.customerId)
                fd.append('last_management', this.last_management)
                fd.append('next_management', this.next_management)
                fd.append('comment', this.comment)
                fd.append('product_tentative', this.product_tentative)
                fd.append('type', this.type)

                axios.post('/api/insertComunication', fd)
                .then((res) =>{
                    console.log(res)
                    $('#updateComModal').modal('hide')
                })
                .catch((err) =>{
                    console.log(err)
                })
            },
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
