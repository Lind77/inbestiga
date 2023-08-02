<template>
    <button @dblclick="showModalHour(schedule)" @click="disableHour"
        :class="`btn btn-${colorByType[schedule.type]} p-2 mb-1 w-100`">{{
            formatTime(schedule.admission_time) }} - {{
        formatTime(schedule.departure_time)
    }}</button>
</template>
<script>

import moment from 'moment';
export default {
    data() {
        return {
            colorByType: {
                1: 'success',
                2: 'secondary',
                3: 'warning'
            },
            scheduleSelected: {}
        }
    },
    props: {
        schedule: Object
    },
    methods: {
        showModalHour(schedule) {
            this.$emit('showModalHour', schedule)
        },
        formatTime(time) {
            return moment(time, "HH:mm:ss").format("hh:mm")
        },
        disableHour() {
            if (this.schedule.type == 1) {
                this.schedule.type = 2
                this.$emit('minusHour')
            } else {
                this.schedule.type = 1
                this.$emit('addHour')
            }

            const fd = new FormData()
            fd.append('type', this.schedule.type)
            fd.append('_method', 'put');

            axios.post('/api/schedules-type/' + this.schedule.id, fd)
                .then((result) => {
                    console.log(result)
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>