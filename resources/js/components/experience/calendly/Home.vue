<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendario</h4>
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <small class="text-small text-muted text-uppercase align-middle">Filtros</small>
                        <div class="app-calendar-events-filter mt-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                    v-model="ableMeetings" @change="filterEvents(1)" data-value="business">
                                <label class="form-check-label" for="select-business">Reuniones</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input input-filter bg-warning border-warning" type="checkbox"
                                    v-model="ableDeliveries" @change="filterEvents(2)" id="select-personal"
                                    data-value="personal">
                                <label class="form-check-label" for="select-personal">Entregas</label>
                            </div>
                            <!-- <p v-for="delivery in deliveries">{{ delivery.date }}</p> -->

                        </div>
                    </div>
                    <div class="col-10">
                        <FullCalendar :options="calendarOptions" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <AddEvent :info="info" @addEvent="addEvent" />
    <OffCanvasEvent :info="infoEvent" @getEvents="getEvents" @getDeliveries="getDeliveries" />
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
import { Fragment } from "vue"

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
                eventDrop: this.eventDrop,
                dateClick: this.handleDateClick,
                eventBackgroundColor: '#e7e7ff',
                eventBorderColor: '#e7e7ff',
                eventTextColor: '#696cff'
            },
            info: {},
            infoEvent: {},
            deliveries: [],
            ableMeetings: true,
            ableDeliveries: true
        }
    },
    methods: {
        filterEvents(type) {
            if (type == 1) {
                if (this.ableMeetings) {
                    this.getEvents()
                } else {
                    this.calendarOptions.events = this.calendarOptions.events.filter(event => event.type != type)
                }
            } else if (type == 2) {
                if (this.ableDeliveries) {
                    this.getDeliveries()
                } else {
                    this.calendarOptions.events = this.calendarOptions.events.filter(event => event.type != type)
                }
            }
            console.log(type, this.ableDeliveries)

        },
        getEvents() {
            this.calendarOptions.events = []
            axios.get('/api/meetings')
                .then((result) => {
                    result.data.forEach(evt => {
                        evt.type = 1
                        this.calendarOptions.events.push(evt);
                    });
                }).catch((err) => {
                    console.error(err);
                });
        },
        getDeliveries() {
            axios.get('/api/deliveries-month')
                .then((result) => {
                    this.deliveries = result.data.deliveries
                    this.deliveries.forEach(delivery => {
                        var newEvt = {
                            title: 'Entrega ' + delivery.deliverable.quotation.customers[0].name,
                            date: delivery.date,
                            comment: delivery.advance,
                            link: '',
                            backgroundColor: '#fff2d6',
                            borderColor: '#fff2d6',
                            textColor: '#ffab00',
                            type: 2
                        }
                        this.calendarOptions.events.push({ ...newEvt })
                    });
                }).catch((err) => {

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
        eventDrop(info) {
            console.log(info.event)
            if (info.event.extendedProps.type == '1') {
                const fd = new FormData()
                fd.append('_method', 'put');
                fd.append('date', info.event.startStr)

                axios.post('/api/meetings/' + info.event.id, fd)
                    .then((result) => {
                        this.$swal('Fecha editada correctamente')
                    }).catch((err) => {
                        this.$swal('Error')
                    });
            }

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
        this.getDeliveries()
    }
}
</script>
<style>
.form-check-danger {
    background-color: #ff3e1d;
}

.fc-daygrid-event-harness {
    padding: 2px 0px;
}
</style>