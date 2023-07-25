<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEvent" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header" v-if="info.event">
            <h3 id="offcanvasEndLabel" class="offcanvas-title">Evento {{ info.event.title }}<i
                    v-if="info.event.extendedProps.type == 1" @click="deleteEvent(info.event.id)"
                    class='bx bx-trash text-danger cursor-pointer'></i>
            </h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0" v-if="info.event">
            <h5 @dblclick="pickDeadline">Comentario: {{ info.event.extendedProps.comment }}</h5>
            <p class="text-danger cursor-pointer">Fecha: {{ formatDate(info.event.start) }}</p>
            <a target="_blank" v-if="info.event.extendedProps.link" class="btn btn-primary"
                :href="info.event.extendedProps.link">Reunión
                Meet</a>
        </div>
    </div>
</template>
<script>
import moment from "moment"

export default {
    props: {
        info: Object
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        deleteEvent(meetingId) {

            axios.delete('/api/meetings/' + meetingId)
                .then((result) => {
                    this.$emit('getEvents')
                    this.$emit('getDeliveries')
                    $('#offcanvasEvent').offcanvas('hide')
                }).catch((err) => {
                    console.error(err);
                });
        }
    }
}
</script>
<style lang="">
    
</style>