<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendario</h4>
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <FullCalendar
                            :options="calendarOptions"
                            @datesSet="handleDatesSet"
                            ref="fullCalendar"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AddEvent
        :info="info"
        @addEvent="addEvent"
        @getDeliveries="getDeliveries"
        @getEvents="getEvents"
    />
    <OffCanvasEvent
        :info="infoEvent"
        @getEvents="getEvents"
        @getDeliveries="getDeliveries"
        @changeEventColor="changeEventColor"
        :acadUsers="acadUsers"
    />
</template>
<script>
import moment from "moment";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import esLocale from "@fullcalendar/core/locales/es";
import AddEvent from "./AddEvent.vue";
import OffCanvasEvent from "./OffCanvas.vue";
import { userStore } from "../../../stores/UserStore";

export default {
    components: { FullCalendar, AddEvent, OffCanvasEvent },
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            user: {},
            collection: [],
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                customButtons: {
                    customprev: {
                        text: "<<",
                        click: this.handlePrevMonth,
                    },
                    customnext: {
                        text: ">>",
                        click: this.handleNextMonth,
                    },
                },
                headerToolbar: {
                    left: "customprev",
                    center: "title",
                    right: "customnext",
                },
                editable: true,
                initialView: "dayGridMonth",
                locale: esLocale,
                hiddenDays: [0],
                events: [],
                eventClick: this.eventClick,
                eventDrop: this.eventDrop,
                dateClick: this.handleDateClick,
                displayEventTime: true,
                eventTimeFormat: {
                    hour: "numeric",
                    minute: "2-digit",
                    omitZeroMinute: true,
                    meridiem: "short",
                },
                eventContent: (arg) => {
                    if (arg.event.extendedProps.type == 2) {
                        return {
                            html: `<del>${arg.event.title}<del>`,
                        };
                    } else {
                        return {
                            html: `${arg.event.title}`,
                        };
                    }
                },
                dayMaxEvents: 3,
            },
            info: {},
            infoEvent: {},
            deliveries: [],
            ableMeetings: true,
            ableDeliveries: true,
            colorMeetings: "primary",
            typeMeeting: 1,
            acadUsers: [],
            dateString: "",
        };
    },
    methods: {
        handlePrevMonth() {
            const date = moment(this.dateString)
                .subtract(1, "months")
                .format("YYYY-MM");
            this.dateString = date;
            this.getEventsFromBd(date);
            this.$refs.fullCalendar.getApi().prev();
        },
        handleNextMonth() {
            const date = moment(this.dateString)
                .add(1, "months")
                .format("YYYY-MM");
            this.dateString = date;
            this.getEventsFromBd(date);
            this.$refs.fullCalendar.getApi().next();
        },
        getAcadUsers() {
            axios
                .get("/api/color-academic-users")
                .then((result) => {
                    this.acadUsers = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        permitNotifications() {
            Notification.requestPermission()
                .then((result) => {
                    if (result === "granted") {
                        new Notification("Notificación de prueba", {
                            body: "Esta es una notificacion de prueba",
                        });
                    }
                })
                .catch((err) => {});
        },
        changeEventColor(deliveryId, user) {
            this.$swal.fire({
                title: "Cargando...",
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            var deliverySelected = this.calendarOptions.events.find(
                (event) => event.deliveryId == deliveryId
            );

            deliverySelected.backgroundColor = user.color;
            deliverySelected.borderColor = user.color;
            $("#offcanvasEvent").offcanvas("hide");

            this.$swal.close();
        },
        changeColor(type) {
            if (this.typeMeeting == 4) {
                this.typeMeeting = 0;
            }
            this.typeMeeting = this.typeMeeting + 1;
            var colors = {
                1: "primary",
                2: "success",
                3: "danger",
                4: "info",
            };

            var colorEvent = {
                1: "#696cff",
                2: "#71dd37",
                3: "#ff3e1d",
                4: "#03c3ec",
            };

            this.calendarOptions.eventBackgroundColor =
                colorEvent[this.typeMeeting];

            this.colorMeetings = colors[this.typeMeeting];
        },
        filterEvents(type) {
            if (type == 1) {
                if (this.ableMeetings) {
                    this.getEvents();
                } else {
                    this.calendarOptions.events =
                        this.calendarOptions.events.filter(
                            (event) => event.type != type
                        );
                }
            } else if (type == 2) {
                if (this.ableDeliveries) {
                    this.getDeliveries();
                } else {
                    this.calendarOptions.events =
                        this.calendarOptions.events.filter(
                            (event) => event.type != type
                        );
                }
            }
            console.log(type, this.ableDeliveries);
        },
        getEvents() {
            //this.calendarOptions.events = []
            axios
                .get("/api/meetings")
                .then((result) => {
                    result.data.forEach((evt) => {
                        evt.type = 1;
                        if (evt.status == 3) {
                            (evt.backgroundColor = "#00cc99"),
                                (evt.borderColor = "#00cc99"),
                                (evt.textColor = "#00cc99");
                        } else {
                            (evt.backgroundColor = "#ccccff"),
                                (evt.borderColor = "#ccccff"),
                                (evt.textColor = "#6633ff");
                        }

                        this.calendarOptions.events.push(evt);
                    });
                    console.log(this.calendarOptions.events);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        getDeliveries() {
            const date = new Date();

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const formattedDate = `${year}-${month}`;
            this.dateString = formattedDate;

            this.getEventsFromBd();
        },
        getEventsFromBd() {
            this.calendarOptions.events = [];
            axios
                .get("/api/deliveries-month/" + this.dateString)
                .then((result) => {
                    this.deliveries = result.data.deliveries;
                    this.deliveries.forEach((delivery) => {
                        if (delivery.project && delivery.project.projectable) {
                            var backgroundColor = delivery.user
                                ? delivery.user.color
                                : "#2c3e50";
                            var borderColor = delivery.user
                                ? delivery.user.color
                                : "#2c3e50";
                            var textColor = "#fff";
                            var nameCustomers = "";

                            delivery.project.projectable.quotation.customers.forEach(
                                (customer, index) => {
                                    if (index != 0) {
                                        nameCustomers += " , " + customer.name;
                                    } else {
                                        nameCustomers += customer.name;
                                    }
                                }
                            );

                            var newEvt = {
                                title: nameCustomers,
                                date: delivery.date,
                                comment: delivery.advance,
                                link: "",
                                status: delivery.status,
                                backgroundColor: backgroundColor,
                                borderColor: borderColor,
                                textColor: textColor,
                                color: textColor,
                                type: delivery.type,
                                deliveryId: delivery.id,
                                user: delivery.user,
                                description: delivery.description,
                            };
                            this.calendarOptions.events.push({ ...newEvt });
                        }
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        addEvent(evt) {
            console.log(evt);
            const fd = new FormData();
            fd.append("title", evt.title);
            fd.append("date", evt.date);
            fd.append("time", evt.time);
            fd.append("link", evt.link);
            fd.append("comment", evt.comment);

            axios
                .post("/api/meetings", fd)
                .then((result) => {
                    this.calendarOptions.events.push(evt);
                    $("#eventModal").modal("hide");
                })
                .catch((err) => {
                    this.$swal("Error");
                });
        },
        handleDateClick(arg) {
            this.info = arg;
            $("#eventModal").modal("show");
        },
        eventClick(info) {
            this.infoEvent = info;
            $("#offcanvasEvent").offcanvas("show");
        },
        eventDrop(info) {
            console.log(info.event);
            if (info.event.extendedProps.type == "1") {
                const fd = new FormData();
                fd.append("_method", "put");
                fd.append("date", info.event.startStr);

                axios
                    .post("/api/meetings/" + info.event.id, fd)
                    .then((result) => {
                        this.$swal("Fecha editada correctamente");
                    })
                    .catch((err) => {
                        this.$swal("Error");
                    });
            }
        },
        formatDate(time) {
            return moment(time).format("DD/MM/YYYY");
        },
        formatTime(time) {
            return moment(time).format("hh:mm a");
        },
    },
    mounted() {
        this.permitNotifications();
        this.getEvents();
        this.getDeliveries();
        this.getAcadUsers();
    },
};
</script>
<style>
.form-check-danger {
    background-color: #ff3e1d;
}

.fc-daygrid-event-harness {
    padding: 2px 0px;
}

.fc-toolbar-title {
    text-transform: capitalize;
}

.fc-col-header-cell-cushion {
    text-transform: capitalize;
}

.fc-event-main {
    padding-left: 10px;
}

.fc-event {
    padding-top: 3px;
    padding-bottom: 3px;
}

.fc-event-title {
    font-weight: bolder;
}

.fc-daygrid-dot-event {
    background-color: #ccccff;
}

.fc-daygrid-dot-event .fc-event-title {
    color: #6633ff;
}

.fc-daygrid-dot-event .fc-event-time {
    color: #6633ff;
    font-weight: bolder;
}

.fc-daygrid-day-top {
    flex-direction: row !important;
}

.bg-pink {
    background-color: #ff00cc !important;
}

.border-pink {
    border-color: #ff00cc !important;
}

table {
    margin-top: 0px;
}
</style>
