<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendario</h4>
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <FullCalendar :options="calendarOptions" />
            </div>
        </div>
    </div>
    <AddEvent :info="info" @addEvent="addEvent" />
    <OffCanvasEvent :info="infoEvent" />
</template>
<script>
import moment from "moment"
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from '@fullcalendar/core/locales/es'
import AddEvent from './AddEvent.vue'
import OffCanvasEvent from './OffCanvas.vue'

export default {
    components: { FullCalendar, AddEvent, OffCanvasEvent },
    data() {
        return {
            user: {},
            collection: [],
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                editable: true,
                initialView: 'dayGridMonth',
                locale: esLocale,
                hiddenDays: [0],
                events: [],
                eventClick: this.eventClick,
                dateClick: this.handleDateClick,
                eventColor: '#696cff'
            },
            info: {},
            infoEvent: {}
        }
    },
    methods: {
        addEvent(evt) {
            this.calendarOptions.events.push(evt);
            $('#eventModal').modal('hide')
        },
        handleDateClick(arg) {
            this.info = arg
            $('#eventModal').modal('show')
        },
        eventClick(info) {
            this.infoEvent = info
            $('#offcanvasEvent').offcanvas('show')
        },
        formatDate(time) {
            return moment(time).format('DD/MM/YYYY')
        },
        formatTime(time) {
            return moment(time).format('hh:mm a')
        }
    },
    mounted() {

    }
}
</script>
<style></style>