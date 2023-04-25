<template>
    <div class="modal fade" id="funnelModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">Información de Lead</h5>
            <!-- {{ customer }} -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-8">
                <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <h5 class="card-title">{{ customer.name }}</h5>
                        <p class="card-text">Celular: {{ customer.cell }}</p>
                        <p class="card-text">Email: {{ customer.email }}</p>
                        <p class="card-text">Universidad: {{ customer.university }}</p>
                        <p class="card-text">Carrera: {{ customer.career }}</p>
                    </div>
                </div>
                <div class="card shadow-none bg-transparent border border-warning mb-3" v-if="customer.comunication">
                    <div class="card-body">
                      <h5 class="card-title">Comunicación</h5>
                        <p class="card-text">Primera gestión: {{ customer.comunication.first_management  }}</p>
                        <p class="card-text">Última gestión: {{ customer.comunication.last_management  }}</p>
                        <p class="card-text">Siguiente gestión: {{ customer.comunication.next_management  }}</p>
                        <p class="card-text">Tipo: {{ customer.comunication.type }}</p>
                        <p class="card-text">Producto Tentativo: {{ customer.comunication.product_tentative  }}</p>
                        <p class="card-text">Comentario: {{ customer.comunication.comment  }}</p>
                    </div>
                </div>       
                </div>
                <div class="col-4">
                    <div class="card shadow-none bg-transparent border border-success mb-3" v-if="customer.quotations">
                    <div class="card-body">
                      <h5 class="card-title">Documentos</h5>
                      <template v-for="quotation in customer.quotations">
                            <router-link target="_blank" :to="{name:'quotation-file', params:{ id: quotation.id }}"  class="btn btn-success w-100 mt-1">{{ quotation.date }}</router-link>
                            <template v-for="order in quotation.orders">
                                    <router-link target="_blank" :to="{name:'order-file', params:{ id: order.id }}"  class="btn btn-info mt-1">{{ order.created_at }}</router-link>
                            </template>
                        </template>
                    </div>
                </div> 
                </div>
            </div>
            
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Stand By</button>
            <button type="button" class="btn btn-primary" @click="updateStatusSpace">Ascender</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        customer: Object
    },
    methods:{
        updateStatusSpace(){    
            var newStatus = parseInt(this.customer.status) + 1
            this.$emit('updateStatusSpace', this.customer.id, newStatus)
        }
    }
}
</script>
