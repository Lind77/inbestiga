<template>
    <div class="modal fade" id="funnelModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">
                Información de Lead
                <button v-show="customer.status > 3" @click="callToQuotation(customer)" type="button" class="btn btn-icon btn-success ms-2">
                        <span class="tf-icons bx bx-file"></span>
                </button>
                <button v-show="customer.status > 3" @click="callToOrder(customer)" type="button" class="btn btn-icon btn-info ms-2">
                        <span class="tf-icons bx bx-pen"></span>
                </button>
                <button @click="callModal(customer)" type="button" class="btn btn-icon btn-warning ms-2">
                    <span class="tf-icons bx bx-chat"></span>
                </button>
            </h5>
            <!-- {{ customer }} -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-6">
                <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <h5 class="card-title">{{ customer.name }}  
                    <button type="button" class="btn btn-icon btn-primary ms-2" @click="showModalUpdateData(customer)">
                        <span class="tf-icons bx bx-user"></span>
                    </button>
                    </h5> 
                        <p class="card-text">Celular: {{ customer.cell }}</p>
                        <p class="card-text">Email: {{ customer.email }}</p>
                        <p class="card-text">Universidad: {{ customer.university }}</p>
                        <p class="card-text">Carrera: {{ customer.career }}</p>
                    </div>
                </div>
                </div>
                <div class="col-6">
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
        },
        callModal(customer){
            this.$emit('callModal', customer)
        },
        showModalUpdateData(customer){
            this.$emit('showModalUpdateData', customer)
        },
        callToQuotation(customer){
            $('#funnelModal').modal('hide')
            this.$router.push({name:'home-quotation', params:{ idUser: customer.id }});
        },
        callToOrder(customer){
            $('#funnelModal').modal('hide')
            this.$router.push({name:'home-orders', params:{ idUser: customer.id }});
        }
    }
}
</script>
