<template>
    <div class="card p-2 mt-2">
        <div class="row">
            <div class="head d-flex justify-content-end">
                <i class="bx bx-x" @click="deleteRecovery"></i>
            </div>

            <div class="col">
                <label for="">Fecha</label>
                <input type="date" v-model="recovery.dateRecovery" @change="checkDateRecovery" class="form-control">
            </div>
            <div class="col">
                <label for="">Hora de inicio</label>
                <input type="time" v-model="recovery.recovery_time_admission" class="form-control">
            </div>
            <div class="col">
                <label for="">Hora de fin</label>
                <input type="time" v-model="recovery.recovery_time_departure" @change="checkRecoveryTimePermission"
                    class="form-control">
            </div>

            <!--  {{ differenceTimesMiss }} -->
        </div>
    </div>
</template>
<script>
import moment from 'moment'

export default {
    data() {
        return {
            dateRecovery: '',
            recovery_time_admission: '',
            recovery_time_departure: ''
        }
    },
    props: {
        recovery: Object,
        index: Number
    },
    methods: {
        deleteRecovery() {
            this.$emit('deleteRecovery', this.index)
        },
        checkRecoveryTimePermission() {
            if (this.differenceTimesMiss < 30) {
                this.$swal('El permiso debe abarcar minimamente media hora')
                this.recovery_time_departure = ''
            } else {
                this.recovery.minutes = this.differenceTimesMiss
            }
        },
        checkDateRecovery() {
            const datePicked = new Date(this.recovery.dateRecovery)
            var actualDate = moment(new Date()).format('YYYY-MM-DD');
            if (moment(datePicked).diff(actualDate) > 0) {
                if (datePicked.getDay() == 6) {
                    this.$swal('Domingo no chambeamos')
                    this.recovery.dateRecovery = ''
                }
            } else {
                this.$swal('Demasiado tarde')
                this.recovery.dateRecovery = ''
            }
        }
    },
    computed: {
        differenceTimesMiss() {
            if (!this.recovery.recovery_time_departure || !this.recovery.recovery_time_admission) {
                return 0; // Si falta algún valor, devuelve directamente 0
            }

            var departureTime = moment(this.recovery.recovery_time_departure, 'HH:mm', true);
            var admissionTime = moment(this.recovery.recovery_time_admission, 'HH:mm', true);

            if (!departureTime.isValid() || !admissionTime.isValid()) {
                return 0; // Si los valores no son válidos, devuelve 0
            }

            var diffTimes = moment.duration(moment(this.recovery.recovery_time_departure, 'HH:mm:ss').diff(moment(this.recovery.recovery_time_admission, 'HH:mm:ss')))

            return diffTimes.asMinutes()
        }
    }
}
</script>
<style lang="">
</style>