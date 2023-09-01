<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-2">
                <h3>{{ totalHours }}</h3>
                <p>HORAS</p>
                <select @change="selectUserSchedule" v-model="userScheduleSelected" class="form-control">
                    <option :value="user.id" v-for="user in users">{{ user.name }}
                    </option>
                </select>
                <a href="javascript:void(0)" @click="openModalSchedule" class="btn btn-primary text-nowrap mt-2">
                    + Horario
                </a>
                <a href="javascript:void(0)" @click="deleteSchedules" class="btn btn-danger text-nowrap mt-2">
                    Limpiar
                </a>
                <div class="mt-3">
                    <p><span class="badge badge-center rounded-pill bg-success">{{
                        abledHours }}</span>
                        On
                    </p>
                    <p><span class="badge badge-center rounded-pill bg-secondary">{{
                        disabledHours }}</span>
                        Off
                    </p>
                    <!-- <p><span
                                                                class="badge badge-center rounded-pill bg-warning">20</span>
                                                            Reuniones
                                                        </p> -->
                </div>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col" v-for="day in days">
                        <p>{{ day.day }}</p>
                        <template v-for="schedule in day.schedules">
                            <Hour :schedule="schedule" @minusHour="minusHour" @addHour="addHour"
                                @showModalHour="showModalHour" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Hour from "./Hour.vue"
import { userStore } from "../../../stores/UserStore"
import moment from "moment"

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    components: { Hour },
    data() {
        return {
            showPassword: false,
            email: '',
            password: '',
            hidden: true,
            user: {},
            users: [],
            days: [
                {
                    day: 'Lunes',
                    numberDay: 1,
                    schedules: []
                },
                {
                    day: 'Martes',
                    numberDay: 2,
                    schedules: []
                },
                {
                    day: 'Miércoles',
                    numberDay: 3,
                    schedules: []
                },
                {
                    day: 'Jueves',
                    numberDay: 4,
                    schedules: []
                },
                {
                    day: 'Viernes',
                    numberDay: 5,
                    schedules: []
                },
                {
                    day: 'Sábado',
                    numberDay: 6,
                    schedules: []
                }
            ],
            totalHours: 0,
            hours: [],
            scheduleSelected: {},
            abledHours: 0,
            disabledHours: 0,
            datePermission: '',
            dateRecovery: '',
            schedulesFounded: [],
            miss_time_admission: '',
            miss_time_departure: '',
            recovery_time_admission: '',
            recovery_time_departure: '',
            reason: '',
            missTime: '',
            recoveryTime: '',
            permissionsNumber: 0,
            userScheduleSelected: 0
        };
    },
    methods: {
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        selectUserSchedule() {
            this.getUser(this.userScheduleSelected)
        },
        updateAccess() {

            const fd = new FormData()

            fd.append('email', this.email)
            fd.append('password', this.password)
            fd.append('_method', 'put')

            axios.post('/api/access/' + this.store.authUser.id, fd)
                .then((result) => {
                    this.$swal('Contraseña actualizada')
                }).catch((err) => {

                });
        },
        getNumberOfPermissions() {
            axios.get('/api/attendance-permits/' + this.store.authUser.id)
                .then((result) => {
                    this.permissionsNumber = result.data
                }).catch((err) => {
                    console.log(err)
                });
        },

        checkDateRecovery() {



            /* const datePicked = new Date(this.dateRecovery)
            var actualDate = moment(new Date()).format('YYYY-MM-DD');
            if (moment(datePicked).diff(actualDate) > 0) {
                if (datePicked.getDay() == 6) {
                    this.$swal('Domingo no chambeamos')
                    this.dateRecovery = ''
                }
            } else {
                this.$swal('Demasiado tarde')
                this.dateRecovery = ''
            } */
        },
        checkDatePermission() {
            const datePicked = new Date(this.datePermission)
            var actualDate = moment(new Date()).format('YYYY-MM-DD');
            if (moment(datePicked).diff(actualDate) > 0) {
                if (datePicked.getDay() == 6) {
                    this.$swal('Domingo no chambeamos')
                    this.datePermission = ''
                    this.schedulesFounded = []
                }
            } else {
                this.$swal('Demasiado tarde')
                this.datePermission = ''
                this.schedulesFounded = []
            }

        },
        addMeeting(newSchedule) {
            var scheduleDay = this.days.find(day => day.numberDay == newSchedule.day)
            var scheduleSelected = scheduleDay.schedules.find(schedule => schedule.id == newSchedule.id)
            scheduleSelected.type = 3
        },
        showModalHour(schedule) {
            this.scheduleSelected = schedule
            $('#hourModal').modal('show')
        },
        openModalSchedule() {
            $("#scheduleModal").modal("show");
        },
        deleteSchedules() {
            if (this.store.authUser.id == 9) {
                axios.delete("/api/schedules-all/" + this.userScheduleSelected)
                    .then((result) => {
                        this.getUser()
                    })
            } else {
                axios.delete("/api/schedules-all/" + this.store.authUser.id)
                    .then((result) => {
                        this.getUser()
                    })
            }
        },
        getProfile() {
            axios.get("/api/users/" + this.store.authUser.id)
                .then((result) => {
                    this.user = result.data;
                    this.getUser(this.user.id)
                })
        },
        getUser(userId) {

            this.totalHours = 0
            this.abledHours = 0
            this.disabledHours = 0
            this.days.forEach(day => {
                day.schedules = []
            });
            axios
                .get("/api/users/" + userId)
                .then((result) => {
                    this.hours = result.data.schedules
                    this.hours.forEach(schedule => {
                        var newDepartureTime = moment(schedule.admission_time, 'HH:mm:ss').add(1, 'hours').format('HH:mm:ss')

                        if (schedule.type == 1) {
                            this.abledHours++;
                        } else if (schedule.type == 2) {
                            this.disabledHours++;
                        }

                        if (schedule.departure_time == newDepartureTime && schedule.type == 1) {
                            this.totalHours++;
                        } else {
                            var timeTotal = moment(schedule.departure_time, 'HH:mm:ss').diff(moment(schedule.admission_time, 'HH:mm:ss'))

                            if (schedule.type == 1) {
                                var timeConverted = moment.duration(timeTotal)
                                console.log(timeConverted.minutes())
                                this.totalHours = this.totalHours + (timeConverted.minutes() / 60)
                            }

                        }

                        var daySelected = this.days.find(day => day.numberDay == schedule.day)
                        daySelected.schedules.push({ ...schedule })
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getUsers() {
            axios.get('/api/users')
                .then((result) => {
                    this.users = result.data
                }).catch((err) => {
                    console.error(err)
                });
        },
        addHour() {
            this.totalHours++;
        },
        minusHour() {
            this.totalHours--;
        },
        hideSidebar() {
            this.hidden = !this.hidden
        }
    },
    computed: {
        differenceTimesRecovery() {
            var diffTimes = moment.duration(moment(this.recovery_time_departure, 'HH:mm:ss').diff(moment(this.recovery_time_admission, 'HH:mm:ss')))

            return diffTimes.hours()
        }
    },
    mounted() {
        this.email = this.store.authUser.email;
        this.getProfile();
        this.getNumberOfPermissions()
        this.getUsers()
    },
    /*    setup() {
           const store = userStore()
           return { store }
       },
       data() {
           return {
               mySchedules: [],
               todayScheudle: []
           }
       },
       methods: {
           getAllMyLeads() {
               axios.get('/api/getAllMyLeads/' + this.store.authUser.id)
                   .then((res) => {
                       this.myLeads = res.data.customers
                       this.todayLeads = res.data.customersToday
                   })
                   .catch((err) => {
   
                   })
           }
       },
       mounted() {
           this.getAllMySchedules()
       } */
}
</script>
<style lang="">
    
</style>