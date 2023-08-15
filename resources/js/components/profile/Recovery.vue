<template>
    <div class="card p-2 mt-2">
        <div class="row">
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
            {{ differenceTimesMiss }}
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
        recovery: Object
    },
    methods: {
        checkRecoveryTimePermission() {
            if (this.differenceTimesMiss < 30) {
                this.$swal('El permiso debe abarcar minimamente media hora')
                this.recovery_time_departure = ''
            } else {
                this.recovery.minutes = this.differenceTimesMiss
            }
        }
    },
    computed: {
        differenceTimesMiss() {
            var diffTimes = moment.duration(moment(this.recovery.recovery_time_departure, 'HH:mm:ss').diff(moment(this.recovery.recovery_time_admission, 'HH:mm:ss')))

            return diffTimes.asMinutes()
        }
    }
}
</script>
<style lang="">
    
</style>