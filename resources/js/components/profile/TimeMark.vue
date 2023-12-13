<template>
    <p>
        <span class="cursor-pointer" @dblclick="editStartTime" v-show="!showStartTimeInput">{{
            formatHours(hour.start)
        }}
        </span>
        <input v-show="showStartTimeInput" ref="timeStart" type="time" class="form-control" v-model="startTime"
            @blur="hideStartTime">

        - <span @dblclick="editEndTime">{{ formatHours(hour.end)
        }}</span>
    </p>
</template>
<script>
import axios from 'axios'
import moment from 'moment'
export default {
    data() {
        return {
            showStartTimeInput: false,
            newTime: '',
            startTime: this.hour.start
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
        hideStartTime() {
            this.showStartTimeInput = false
            this.$emit('updateList', this.startTime, this.hour.id)
        }
    }
}
</script>