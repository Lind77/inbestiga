<template>
    <!--  <button class="btn btn-primary" @click="importAttendance">Importar</button> -->
    <!-- <div v-for="marks in myJson">
        <p v-for="mark in marks">{{ mark.first_name }} {{ mark.last_name }} {{ mark.att_date }} {{ mark.first_punch }} {{
            mark.last_punch }}</p>
    </div> -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <input type="file" @change="handleFileUpload" class="form-control">
            </div>
            <div class="col-md-6">
                <select v-model="userSelected" class="form-select" @change="getAttendances">
                    <option :value="user.id" v-for="user in users">{{ user.name }}</option>
                </select>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header">
                <h4>{{ user.name }} <button class="btn btn-success btn-sm" @click="compareSchedules">Calcular</button></h4>
                <p v-for="attendance in user.attendances"><button class="btn btn-primary">{{ attendance.date }},
                        {{ attendance.first_punch }} - {{ attendance.last_punch }}</button>
                    <span v-if="attendance.status">{{ attendance.status }}</span>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'

export default {
    data() {
        return {
            file: '',
            user: {},
            schedules: [],
            scheduleFiletered: [],
            users: [],
            userSelected: 0
        }
    },
    methods: {
        compareSchedules() {
            this.user.attendances.forEach((attendance) => {
                var scheduleSelected = this.scheduleFiletered.find(schedule => schedule.weekDay == attendance.weekday)

                var firstPunchPlusTen = moment(scheduleSelected.first_punch, 'HH:mm:ss').add(10, 'minutes').format('HH:mm:ss')

                if (attendance.first_punch > firstPunchPlusTen) {
                    attendance.status = 'Tarde'
                } else {
                    attendance.status = 'Temprano'
                }

            })
        },
        getUsers() {
            axios.get('/api/users')
                .then((result) => {
                    this.users = result.data
                }).catch((err) => {

                });
        },
        getAttendances() {

            axios.get('/api/schedules/' + this.userSelected)
                .then((result) => {
                    this.user = result.data.user;
                    this.schedules = result.data.newSchedules
                    console.log(this.schedules);
                    this.schedules.forEach((schedule, index) => {

                        if (index % 2 != 0) {

                            this.scheduleFiletered[index - this.scheduleFiletered.length].last_punch = schedule.departure_time
                        } else {

                            var newSchedule = {
                                weekDay: schedule.day,
                                first_punch: schedule.admission_time,
                                last_punch: ''
                            }
                            this.scheduleFiletered.push(newSchedule)
                        }
                    })

                }).catch((err) => {
                    console.error(err)
                });
        },
        handleFileUpload(e) {
            const fd = new FormData()

            fd.append('file', e.target.files[0])

            axios.post('/api/json-file', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((result) => {
                    this.$swal('Asistencias almacenadas correctamente')
                }).catch((err) => {
                    console.error(err);
                });

        }
    },
    mounted() {
        this.getUsers()
    }
}
</script>