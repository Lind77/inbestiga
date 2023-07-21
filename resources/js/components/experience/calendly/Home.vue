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
import { userStore } from "../../../stores/UserStore"

export default {
    components: { FullCalendar, AddEvent, OffCanvasEvent },
    setup() {
        const store = userStore()
        return { store }
    },
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
        getEvents() {
            axios.get('/api/meetings')
                .then((result) => {
                    result.data.forEach(evt => {
                        this.calendarOptions.events.push(evt);
                    });
                }).catch((err) => {
                    console.error(err);
                });
        },
        addEvent(evt) {
            console.log(evt);
            const fd = new FormData()
            fd.append('title', evt.title)
            fd.append('date', evt.date)
            fd.append('link', evt.link)
            fd.append('comment', evt.comment)

            axios.post('/api/meetings', fd)
                .then((result) => {
                    this.calendarOptions.events.push(evt);
                    $('#eventModal').modal('hide')
                }).catch((err) => {
                    this.$swal('Error')
                });

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
        this.getEvents()
    }
}
</script>
<style></style>