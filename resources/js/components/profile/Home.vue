<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Mi Perfil</h4>
        <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/pages/profile-banner.png"
                    alt="Banner image" class="rounded-top w-100">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n5 mx-sm-0 mx-auto">
                    <img :src="'../../public/files/' + user.images[0].url" alt="user image"
                        style="width: 180px; height: 180px !important; object-fit:cover;"
                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img mb-5 cursor-pointer"
                        @click="updatePhoto" v-if="user.images && user.images[0]">
                    <img src="https://img.freepik.com/premium-vector/user-profile-icon-flat-style-member-avatar-vector-illustration-isolated-background-human-permission-sign-business-concept_157943-15752.jpg?size=338&ext=jpg&ga=GA1.1.1546980028.1703548800&semt=ais"
                        alt="user image" style="width: 180px;"
                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img mb-5 cursor-pointer"
                        @click="updatePhoto" v-else>

                    <input type="file" style="display:none" ref="file" @change="updateProfilePhoto">
                </div>
                <div class="flex-grow-1 mt-1 mt-sm-4">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ user.name }}</h4>
                            <ul
                                class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item fw-medium" v-if="user.roles">
                                    <i class="bx bx-pen"></i>
                                    {{
                                        user.roles[0]
                                            .name
                                    }}
                                </li>
                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-map"></i>
                                    Huancayo
                                </li>
                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-calendar-alt"></i>
                                    Joined April 2022
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                            <i class="bx bx-user-check me-1"></i>Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                aria-selected="true">
                                <i class="tf-icons bx bx-home"></i> Mi Horario
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile"
                                aria-selected="false">
                                <i class="tf-icons bx bx-user"></i> Permisos
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-messages"
                                aria-controls="navs-pills-justified-messages" aria-selected="false">
                                <i class="tf-icons bx bx-key"></i> Seguridad
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-pills-justified-home" role="tabpanel">
                            <div class="row">
                                <div class="col-2">
                                    <h3>{{ abledHours }}</h3>
                                    <p>HORAS</p>
                                    <!-- <select @change="selectUserSchedule" v-model="userScheduleSelected"
                                                        class="form-control" v-if="store.authUser.id == 9">
                                                        <option :value="user.id" v-for="user in users">{{ user.name }}
                                                        </option>
                                                    </select> -->
                                    <a href="javascript:void(0)" @click="openModalSchedule"
                                        class="btn btn-primary text-nowrap mt-2">
                                        + Horario
                                    </a>
                                    <a href="javascript:void(0)" @click="deleteSchedules"
                                        class="btn btn-danger text-nowrap mt-2">
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
                                        <div class="col"></div>
                                        <div class="col text-center">Lunes</div>
                                        <div class="col text-center">Martes</div>
                                        <div class="col text-center">Miércoles</div>
                                        <div class="col text-center">Jueves</div>
                                        <div class="col text-center">Viernes</div>
                                        <div class="col text-center">Sábado</div>
                                    </div>
                                    <div v-for="hour in listHours" class="row border rounded">
                                        <div class="col pt-2">
                                            <TimeMark :hour="hour" @updateList="updateList"
                                                @updateEndTime="updateEndTime" />
                                        </div>
                                        <div class="col d-flex" v-for="index in 6" :key="index">
                                            <template v-for="schedule in hour.schedules">
                                                <template v-if="index == schedule.day">
                                                    <button @click="disableHour(schedule)"
                                                        :class="`btn btn-${colorByType[schedule.type]} w-100`"></button>
                                                </template>

                                            </template>

                                            <!--  <button v-if="schedule.type == 1" class="btn btn-success w-100">{{ schedule
                                                .day }}</button>
                                            <button class="btn btn-secondary w-100" v-else></button> -->


                                            <!--  <Hour :schedule="schedule" @minusHour="minusHour" @addHour="addHour"
                                                @showModalHour="showModalHour" /> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                            <Permissions :permissionsNumber="permissionsNumber" />
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                            <div class="alert alert-danger" role="alert">Ten cuidado al editar estos campos.
                            </div>

                            <label for="">Correo</label>
                            <input type="text" v-model="email" class="form-control w-25" readonly>
                            <label for="">Contraseñas</label>

                            <div class="input-group input-group-merge w-25">
                                <input v-if="showPassword" v-model="password" type="text" class="form-control"
                                    id="basic-default-password32" placeholder="············"
                                    aria-describedby="basic-default-password">
                                <input v-else v-model="password" type="password" class="form-control"
                                    id="basic-default-password32" placeholder="············"
                                    aria-describedby="basic-default-password">
                                <span @click="toggleShow" class="input-group-text cursor-pointer"
                                    id="basic-default-password"><i
                                        :class="{ 'bx bx-show': showPassword, 'bx bx-hide': !showPassword }"></i></span>
                            </div>
                            <button class="btn btn-primary mt-2" @click="updateAccess">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ScheduleModal @getUser="getUser" :userIdSelected="userScheduleSelected" />
    <HourModal :schedule="scheduleSelected" @getUser="getUser" @addMeeting="addMeeting" />
</template>
<script>

import Sidebar from "../layout/Sidebar.vue";
import Navbar from "../layout/Navbar.vue";
import moment from "moment/min/moment-with-locales";
import ScheduleModal from "./ScheduleModal.vue"
import Hour from "./Hour.vue"
import HourModal from './HourModal.vue'
import Permissions from './Permissions.vue'
import TimeMark from './TimeMark.vue'
import { userStore } from "../../stores/UserStore";
import axios from "axios";

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    components: { Sidebar, Navbar, ScheduleModal, Hour, HourModal, Permissions, TimeMark },
    data() {
        return {
            colorByType: {
                1: 'success',
                2: 'secondary',
                3: 'warning'
            },
            listHours: [],
            ableHours: {
                start: '07:00:00',
                end: '22:00:00'
            },
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
            userScheduleSelected: 0,
            showStartTimeInput: false
        };
    },
    methods: {
        updateProfilePhoto(e) {
            const fd = new FormData()

            fd.append('imageable_id', this.store.authUser.id)
            fd.append('file', e.target.files[0])

            axios.post('/api/profile-photo', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((result) => {
                    this.user.images[0] = result.data
                    this.store.authUser.images[0] = result.data
                }).catch((err) => {
                    console.error(err);
                });
        },
        updatePhoto() {
            this.$refs.file.click();
        },
        disableHour(schedule) {
            if (schedule.type == 1) {
                schedule.type = 2
            } else {
                schedule.type = 1
            }

            const fd = new FormData()
            fd.append('type', schedule.type)
            fd.append('_method', 'put');

            axios.post('/api/schedules-type/' + schedule.id, fd)
                .then((result) => {
                    console.log(result)
                }).catch((err) => {
                    console.log(err);
                });
        },
        updateEndTime(newTime, id) {
            var hourNextSelected = this.listHours.find(hour => hour.id == parseInt(id) + 1)
            if (hourNextSelected) {
                hourNextSelected.start = newTime
            }

            var hourSelected = this.listHours.find(hour => hour.id == id)
            hourSelected.end = newTime

            const fd = new FormData()
            fd.append('hours', JSON.stringify(hourSelected))
            fd.append('nextHours', JSON.stringify(hourNextSelected))

            axios.post('/api/update-times-next', fd)
                .then((result) => {
                    this.$swal('ACtualización correcta')
                }).catch((err) => {
                    this.$swal('Error')
                });
        },
        updateList(newTime, id) {
            var hourPastSelected = this.listHours.find(hour => hour.id == parseInt(id) - 1)
            if (hourPastSelected) {
                hourPastSelected.end = newTime
            }

            var hourSelected = this.listHours.find(hour => hour.id == id)
            hourSelected.start = newTime

            const fd = new FormData()
            fd.append('hours', JSON.stringify(hourSelected))
            fd.append('pastHours', JSON.stringify(hourPastSelected))

            axios.post('/api/update-times', fd)
                .then((result) => {
                    this.$swal('ACtualización correcta')
                }).catch((err) => {
                    this.$swal('Error')
                });
            /* console.log(newTime);
            this.hours.forEach((hour) => {
                if (hour.admission_time == newTime + ':00') {
                    hourSelected.schedules.push({ ...hour })
                }
            }) */

        },
        formatHours(time) {
            return moment(time, 'HH:mm:ss').format('HH a')
        },
        editStartTime() {
            alert('nani')
            showStartTimeInput = true
        },
        editEndTime() {
            alert('gg')
        },
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

        generateSchedules() {

            this.hours.forEach((hour) => {

                var hourFinded = this.listHours.find(listhour => listhour.start == hour.admission_time || listhour.end == hour.departure_time)

                if (!hourFinded) {
                    var hour = {
                        id: hour.id,
                        start: hour.admission_time,
                        end: hour.departure_time,
                        schedules: []
                    }

                    this.listHours.push({ ...hour })
                }

            })

            /* let initialHour = this.ableHours.start
            let finalHour = moment(this.ableHours.start, 'HH:mm:ss').add(1, 'hours').format('HH:mm:ss')

            for (let index = 1; index < 15; index++) {
                var hour = {
                    id: index,
                    start: initialHour,
                    end: moment(initialHour, 'HH:mm:ss').add(1, 'hours').format('HH:mm:ss'),
                    schedules: []
                }

                this.listHours.push({ ...hour })
                initialHour = hour.end
            }

            this.completeHours() */
        },
        completeHours() {
            /* this.days.forEach(day => {
                this.listHours.forEach(hour => {
                    console.log(hour.start, day)
                })
            }) */
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
                axios.delete("/api/schedules-all/" + userScheduleSelected)
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
        distributeHours() {
            this.hours.forEach((hour) => {
                var listHourFinded = this.listHours.find(listhour => listhour.start == hour.admission_time)

                if (listHourFinded) {
                    listHourFinded.schedules.push({ ...hour })
                }
            })


            /* this.hours.forEach(schedule => {
                var newDepartureTime = moment(schedule.admission_time, 'HH:mm:ss').add(1, 'hours').format('HH:mm:ss')

                if (schedule.type == 1) {
                    this.abledHours++;
                    var timeTotal = moment(schedule.departure_time, 'HH:mm:ss').diff(moment(schedule.admission_time, 'HH:mm:ss'))
                    var minutesTotal = timeTotal / 60000

                    var cantHours = minutesTotal / 60

                    this.totalHours = this.totalHours + cantHours

                    console.log(schedule.admission_time, schedule.departure_time, cantHours)

                } else if (schedule.type == 2) {
                    this.disabledHours++;
                }

                var daySelected = this.days.find(day => day.numberDay == schedule.day)
                daySelected.schedules.push({ ...schedule })
            }); */
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
                    this.hours.forEach((hour) => {
                        if (hour.type == 1) {
                            this.abledHours++
                        } else {
                            this.disabledHours++
                        }
                    })
                    this.generateSchedules()
                    this.distributeHours()
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
};
</script>
