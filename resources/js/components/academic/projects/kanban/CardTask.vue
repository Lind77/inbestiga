<template>
    <div class="card card-action mb-4 cursor-pointer" draggable="true" @dragstart="drag" :id="task.id">
        <div class="card-header">
            <div class="card-action-title">
                <p class="mb-1 h6 fw-bold">{{ task.advance }}</p>

                <p class="text-danger">{{ task.date }}</p>

                <!-- <template v-if="task.status >= 1">
                    <span class="h6">{{ task.progress.owner }}</span> <i class='bx bx-user'></i>
                </template> -->
            </div>
            <div class="demo-inline-spacing"
                v-if="task.status == 1 && this.task.progress.owner == this.store.authUser.name">
                <!-- <button type="button" @click="startCron" class="btn rounded-pill btn-icon btn-primary">
                    <span class="tf-icons bx bx-play"></span>
                </button>
                <button type="button" @click="stopCron" class="btn rounded-pill btn-icon btn-secondary">
                    <span class="tf-icons bx bx-pause"></span>
                </button> -->
                {{ time }}
                <!-- {{ cronometer }} -->
            </div>

            <div class="card-action-element">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a class="card-collapsible" data-bs-toggle="collapse" :href="`#collapseExample${task.id}`"
                            role="button" aria-expanded="false" aria-controls="collapseExample"><i
                                class="tf-icons bx bx-chevron-up"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="collapse" :id="`collapseExample${task.id}`">
            <div class="card-body pt-0">
                <p class="card-text">
                    <button class="btn btn-info" v-for="activity in task.assigned_activities">{{ activity.name }}</button>
                    <!-- <div class="item-badges" v-if="task.fixed_task.fixed_activity">
                    <p class="h5">Actividad: {{ task.fixed_task.fixed_activity.title }}</p>
                    <p class="h6">Tarea: {{ task.fixed_task.title }}</p>
                </div> -->
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
import { userStore } from '../../../../stores/UserStore'

export default {
    props: {
        task: Object
    },
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    data() {
        return {
            visible: false,
            cronometer: new Date().setHours(0, 0, 0, 0),
            showCronometer: true,
            subtract: 0,
            seconds: 0,
            timer: 0,
            interval: null,
            time: "00:00"
        }
    },
    methods: {
        startCron() {
            var a = moment(new Date(this.task.start_time))
            console.log(a)

            this.interval = setInterval(() => {
                var b = moment(new Date())
                this.timer++
                this.time = moment(b.diff(a)).format('mm:ss')
            }, 1000)
        },
        formatTime(time) {
            // Formatear el tiempo en un formato legible por humanos
            const minutes = Math.floor(time / 60)
            const seconds = time % 60
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
        },
        stopCron() {
            clearInterval(this.interval)
        },
        startCronometer() {
            console.log('iniciando cronometro')

            this.interval = setInterval(() => {

                //document.getElementById('cronometer'+id).innerHTML = d.toLocaleTimeString()
            }, 1000)
        },
        stopCronometer() {
            console.log('stopeando cronometer')
            clearInterval(this.interval)
        },
        drag(e) {
            e.dataTransfer.setData('text', e.target.id)
            console.log('este es mi status', this.task.status)
            if (this.task.status == 1) {

                e.dataTransfer.setData('owner', this.task.progress.owner)
            }
        }
    },
    computed: {
        formattedDate() {
            return moment(this.taskSelected.progress.start_time).format('h:mm a')
        },
        bgCard() {
            if (this.task.status == 0) {
                return 'bg-danger'
            } else if (this.task.status == 1) {
                return 'bg-warning'
            } else if (this.task.status == 2) {
                return 'bg-success'
            }
        },
        calcStopwatch() {
            if (this.taskSelected.status == 2) {
                var cantStartTime = Date.parse(this.taskSelected.progress.start_time)
                var cantEndTime = Date.parse(this.taskSelected.progress.end_time)

                var totalTime = cantEndTime - cantStartTime

                var totalSeconds = totalTime / 1000
                if (totalSeconds >= 3600) {
                    var totalMinutes = Math.floor(totalSeconds / 60)
                    var restSeconds = totalSeconds % 60
                    var totalHours = Math.floor(totalMinutes / 60)
                    var restMinutes = totalMinutes % 60

                    return totalHours + 'h ' + restMinutes + 'm ' + restSeconds + 's'
                }
                else if (totalSeconds >= 60) {
                    var totalMinutes = Math.floor(totalSeconds / 60)
                    var restSeconds = totalSeconds % 60

                    return totalMinutes + 'm ' + restSeconds + 's'
                } else {
                    return totalSeconds + 's'
                }


            }
        }
    },
    mounted() {
        if (this.task.status == 1 && this.task.progress.owner == this.store.authUser.name) {
            this.startCron()
        } else if (this.task.status == 2) {
            this.stopCron()
        }
    }
}
</script>