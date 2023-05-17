<template>
    <div class="modal fade" id="updateComModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Registrar Comunicación</h5>
                    
                </div>
                <div class="modal-body">
                    <div class="row g-2 mt-2" v-if="comunication && comunication.comunications && comunication.comunications.length == 0">
                        <div class="col mb-0">
                            <label for="emailBasic"  class="form-label">Primera Gestión</label>
                            <input type="date" v-model="first_management" class="form-control" />
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">Última Gestión</label>
                            <input type="date" v-model="last_management" class="form-control" disabled/>
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Próxima Gestión</label>
                        <input type="datetime-local" v-model="next_management" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Comentario {{ comment.length }}/140</label>
                        <textarea type="text" v-model="comment" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Producto Tentativo</label>
                        <input type="text" v-model="product_tentative" class="form-control"/>
                        </div>
                        <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Tipo</label>
                        <select v-model="type" class="form-select">
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
                <button type="button" @click="insertComunication" class="btn btn-primary">Registrar</button>
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
                first_management: '',
                last_management: new Date().toISOString().slice(0,10),
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
                if(this.comment.length <= 140){
                const fd = new FormData()
                fd.append('customer_id', this.customerId)
                fd.append('first_management', this.first_management)
                fd.append('last_management', this.last_management)
                fd.append('next_management', this.next_management)
                fd.append('comment', this.comment)
                fd.append('product_tentative', this.product_tentative)
                fd.append('type', this.type)

                axios.post('/api/insertComunication', fd)
                .then((res) =>{
                    this.comunication.comunications.unshift(res.data.comunication)
                    this.$emit('updateComunication', this.comunication)
                    $('#updateComModal').modal('hide')
                })
                .catch((err) =>{
                    console.log(err)
                })
                }else{
                    this.$swal('El comentario excede los 140 caracteres')
                }
            }
        }
    }
</script>
