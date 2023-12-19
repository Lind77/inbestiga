<template>
    <p>
        <span class="cursor-pointer" @dblclick="editStartTime" v-show="!showStartTimeInput">{{
            formatHours(hour.start)
        }}
        </span>
        <input v-show="showStartTimeInput" ref="timeStart" type="time" class="form-control" v-model="startTime"
            @blur="hideStartTime">
        - <span class="cursor-pointer" @dblclick="editEndTime" v-show="!showEndTimeInput">{{ formatHours(hour.end) }}</span>
        <input v-show="showEndTimeInput" ref="timeEnd" type="time" class="form-control" v-model="endTime"
            @blur="hideEndTime">
    </p>
</template>
<script>
import axios from 'axios'
import moment from 'moment'
export default {
    data() {
        return {
            showStartTimeInput: false,
            showEndTimeInput: false,
            newTime: '',
            startTime: this.hour.start,
            endTime: this.hour.end
        }
    },
    props: {
        hour: Object
    },
    methods: {
        formatHours(time) {
            return moment(time, 'HH:mm:ss').format('h:mm a')
        },
        editStartTime() {
            this.showStartTimeInput = true
            this.$nextTick(() => {
                const editButtonRef = this.$refs.timeStart;
                editButtonRef.focus();
            });
        },
        editEndTime() {
            this.showEndTimeInput = true
            this.$nextTick(() => {
                const editButtonRef = this.$refs.timeEnd;
                editButtonRef.focus();
            });
        },
        hideStartTime() {
            this.showStartTimeInput = false
            this.$emit('updateList', this.startTime, this.hour.id)
        },
        hideEndTime() {
            this.showEndTimeInput = false
            this.$emit('updateEndTime', this.endTime, this.hour.id)
        }
    }
}
</script>