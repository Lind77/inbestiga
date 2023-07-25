<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEvent" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header" v-if="info.event">
            <h3 id="offcanvasEndLabel" class="offcanvas-title">Evento {{ info.event.title }}</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0" v-if="info.event">
            <h5 @dblclick="pickDeadline">Comentario: {{ info.event.extendedProps.comment }}</h5>
            <p class="text-danger cursor-pointer">Fecha: {{ formatDate(info.event.start) }}</p>
            <button v-if="info.event.extendedProps.link" class="btn btn-primary"
                :href="info.event.extendedProps.link">Reunión Meet</button>
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
        }
    }
}
</script>
<style lang="">
    
</style>