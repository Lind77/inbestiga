<template>
    <div class="alert alert-warning" role="alert">Ten cuidado antes de solicitar
        un permiso, ya que solo se pueden hacer tres solicitudes al mes. Ya hiciste {{ permissionsNumber }} este mes</div>
    <div class="row">
        <div class="col-md-12">
            <label for="">Razón del permiso</label>
            <textarea class="form-control" v-model="reason"></textarea>
        </div>
        <div class="col-md-6 mt-3">
            <p class="h5">Fecha y hora de permiso</p>
            <input type="date" v-model="datePermission" @change="checkDatePermission" class="form-control">
            <label for="">Hora de inicio</label>
            <input type="time" v-model="miss_time_admission" class="form-control">
            <label for="">Hora de fin</label>
            <input type="time" v-model="miss_time_departure" @change="checkMissTimePermission" class="form-control">
            <p>{{ differenceTimesMiss }} minutos de permiso</p>
        </div>
        <div class="col-md-6 mt-3 mb-3">
            <div class="w-100 d-flex align-items-center justify-content-between mb-2">
                <p class="h5">Recuperación</p>
                <button type="button" @click="addRecovery" class="btn btn-icon btn-primary">
                    <span class="tf-icons bx bx-plus"></span>
                </button>
            </div>
            <div v-for="(recovery, index) in recoveries" :key="index">
                <Recovery :recovery="recovery" :index="index" @deleteRecovery="deleteRecovery" />

            </div>
            {{ totalRecoveryMinutes }} minutos de recuperación
        </div>
    </div>
    <div class="row mt-3">
        <button class="btn btn-success" @click="postPermission" v-bind:disabled="permissionsNumber >= 3">Solicitar
        </button>
    </div>
</template>
<script>
import moment from "moment"
import Recovery from './Recovery.vue'
import { userStore } from "../../stores/UserStore"

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    data() {
        return {
            recoveries: [],
            reason: '',
            miss_time_admission: '',
            miss_time_departure: '',
            datePermission: '',
            permissionsNumber: 0
        }
    },
    props: {
        permissionsNumber: Number
    },
    components: { Recovery },
    methods: {
        deleteRecovery(recoveryIndex) {
            /* var recoverySelected = this.recoveries.findIndex(recoveryIndex); */
            this.recoveries.splice(recoveryIndex, 1)
        },
        addRecovery() {
            var recovery = {
                date: '',
                recovery_time_admission: '',
                recovery_time_departure: '',
                totalMinutes: this.differenceTimesMiss
            }

            this.recoveries.push({ ...recovery })
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
        checkMissTimePermission() {
            if (this.differenceTimesMiss < 30) {
                this.$swal('El permiso debe abarcar minimamente media hora')
                this.miss_time_departure = ''
            }
        },
        postPermission() {
            console.log(this.differenceTimesMiss == this.totalRecoveryMinutes, this.differenceTimesMiss, this.totalRecoveryMinutes)
            if (this.differenceTimesMiss == this.totalRecoveryMinutes) {
                const fd = new FormData()

                fd.append('miss_date', this.datePermission)
                fd.append('reason', this.reason)
                fd.append('recovery_date', null)
                fd.append('status', 0)
                fd.append('miss_time_admission', this.miss_time_admission)
                fd.append('miss_time_departure', this.miss_time_departure)
                fd.append('recovery_time_admission', null)
                fd.append('recovery_time_departure', null)
                fd.append('recoveries', JSON.stringify(this.recoveries))
                fd.append('user_id', this.store.authUser.id)

                axios.post('/api/attendance-permits', fd)
                    .then((result) => {
                        this.$swal('Permiso solicitado')
                        this.miss_time_admission = ''
                        this.miss_time_departure = ''
                        this.recovery_time_admission = ''
                        this.recovery_time_departure = ''
                        this.reason = ''
                        this.datePermission = ''
                        this.dateRecovery = '',
                            this.recoveries = []
                        this.getNumberOfPermissions()
                    }).catch((err) => {
                        console.error(err)
                    });
            } else {
                this.$swal('Los tiempos de permiso no coinciden o ha superado el número de permisos de este mes')
            }
        }
    },
    computed: {
        totalRecoveryMinutes() {

            var totalMinutesRecovery = 0;

            var totalMinutesRecovery = this.recoveries.reduce((total, item) => total + item.minutes, 0)

            return totalMinutesRecovery
        },
        differenceTimesMiss() {

            if (!this.miss_time_departure || !this.miss_time_admission) {
                return 0; // Si falta algún valor, devuelve directamente 0
            }

            var departureTime = moment(this.miss_time_departure, 'HH:mm', true);
            var admissionTime = moment(this.miss_time_admission, 'HH:mm', true);

            if (!departureTime.isValid() || !admissionTime.isValid()) {
                return 0; // Si los valores no son válidos, devuelve 0
            }

            var diffTimes = departureTime.diff(admissionTime);
            return moment.duration(diffTimes).asMinutes();
        }
    }
}
</script>
<style lang="">
    
</style>