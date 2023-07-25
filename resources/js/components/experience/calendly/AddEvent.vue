<template>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-1">
                            <label for="nameSmall" class="form-label">Fecha:</label>
                            <input type="date" :value="info.dateStr" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Título</label>
                            <input type="text" v-model="title" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Comentario</label>
                            <textarea v-model="comment" cols="3" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Link de Meet (Opcional)</label>
                            <input type="text" v-model="link" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Salir
                    </button>
                    <button type="button" class="btn btn-primary" @click="addEvent">Asignar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title: '',
            comment: '',
            link: ''
        }
    },
    props: {
        info: Object
    },
    methods: {
        addEvent() {

            var newEvt = {
                title: this.title,
                date: this.info.dateStr,
                comment: this.comment,
                link: this.link,
                backgroundColor: '#e7e7ff',
                borderColor: '#e7e7ff',
                textColor: '#ff3e1d'
            }

            this.$emit('addEvent', newEvt)
        }
    }
}
</script>
<style lang="">
    
</style>