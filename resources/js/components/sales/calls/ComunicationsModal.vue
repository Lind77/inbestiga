<template>
    <div class="modal fade" id="ComunicationsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Comunicaciones</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-12 mb-3 mb-md-0">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" :href="`#list-home${comunication.id}`" v-for="comunication in comunications">{{ comunication.last_management }}</a>
                    </div>
                    </div>
                        <div class="col-md-8 col-12">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade" :id="`list-home${comunication.id}`" v-for="comunication in comunications">
                                <p>Fecha de primera gestión: {{ comunication.first_management }}</p>
                                <p>Fecha de última gestión: {{ comunication.last_management }}</p>
                                <p>Fecha de siguiente gestión: {{ comunication.next_management }}</p>
                                <p>Comentario: {{ comunication.comment }}</p>
                                <p>Producto Tentativo: {{ comunication.product_tentative }}</p>
                                <p>Tipo: {{ comunicationOptions[comunication.type] }}</p>
                            </div>
                        </div>
                        </div>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Registrar</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            comunications: Array
        },
        data(){
            return{
                comunicationOptions:{
                    1: 'Llamar',
                    2: 'Escribir',
                    3: 'Meet'
                }
            }
        }
    }
</script>