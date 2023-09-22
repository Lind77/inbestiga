<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEvent" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header" v-if="info.event">
            <h3 id="offcanvasEndLabel" class="offcanvas-title">Evento {{ info.event.title }}
                <i v-if="info.event.extendedProps.type == 1" @click="deleteEvent(info.event.extendedProps.deliveryId)"
                    class='bx bx-trash text-danger cursor-pointer'></i>
                <i v-else @click="deleteDelivery(info.event.extendedProps.deliveryId)"
                    class='bx bx-trash text-danger cursor-pointer'></i>
            </h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0" v-if="info.event">
            <h5 @dblclick="pickDeadline">Comentario: {{ info.event.extendedProps.comment }}</h5>
            <p>Estado: {{ statusByNumber[info.event.extendedProps.status] }}</p>
            <p class="text-danger cursor-pointer">Fecha: {{ formatDate(info.event.start) }}</p>
            <a target="_blank" v-if="info.event.extendedProps.link" class="btn btn-primary"
                :href="info.event.extendedProps.link">Reunión
                Meet</a>
            <p>
                <!-- <span class="badge badge-center rounded-pill bg-secondary"><i class='bx bx-pause'></i></span> -->
                <span v-if="info.event.extendedProps.status == 0" class="badge badge-center rounded-pill bg-success ms-1"
                    @click="completeMeeting(info.event.id)"><i class="bx bx-check"></i></span>
                <!-- <span class="badge badge-center rounded-pill bg-danger ms-1">4</span> -->
            </p>
        </div>

    </div>
</template>
<script>
import moment from "moment"

export default {
    data() {
        return {
            statusByNumber: {
                0: 'No realizado',
                1: 'Realizado'
            }
        }
    },
    props: {
        info: Object
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        deleteEvent(meetingId) {
            console.log(meetingId)
            axios.delete('/api/deliveries/' + meetingId)
                .then((result) => {
                    this.$emit('getEvents')
                    this.$emit('getDeliveries')
                    $('#offcanvasEvent').offcanvas('hide')
                }).catch((err) => {
                    console.error(err);
                });
        },
        completeMeeting(meetingId) {
            console.log(meetingId)
            axios.get('/api/meetings-complete/' + meetingId)
                .then((result) => {
                    this.$emit('getEvents')
                    this.$emit('getDeliveries')
                    $('#offcanvasEvent').offcanvas('hide')
                }).catch((err) => {
                    console.error(err);
                });
            this.$emit('changeEventColor', this.info.event.id)
        },
        deleteDelivery(deliveryId) {
            if (confirm('Deseas eliminar esta entrega, con seguridad?')) {
                axios.delete('/api/deliveries/' + deliveryId)
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
}
</script>
<style lang="">
    
</style>