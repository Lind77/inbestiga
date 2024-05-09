<template>
    <div
        draggable="true"
        @dragstart="drag"
        :id="activity.id"
        class="card shadow-none bg-transparent border border-primary mb-3 cursor-pointer"
    >
        <div class="card-body">
            <h5 class="card-title">{{ activity.name }}</h5>
            <p class="card-text">{{ activity.date }}</p>
            <button
                class="btn btn-sm btn-success"
                @click="sendToReview(activity)"
                v-if="activity.status == 3"
            >
                Enviar a revisión
            </button>
            <p class="text-warning" v-if="activity.status == 4">En revisión</p>
            <button
                class="btn btn-sm btn-warning"
                v-if="
                    store.authUser.roles[0].name == 'CoordAcad' &&
                    activity.status == 3
                "
                @click="openModelIndicators(activity)"
            >
                Evaluar
            </button>
            <!--  <button class="btn btn-sm btn-success"
                v-if="store.authUser.roles[0].name == 'CoordAcad' && activity.status > 2"
                @click="acceptActivity(activity)">Aprobar</button>
            <button class="btn btn-sm btn-danger ms-2"
                v-if="store.authUser.roles[0].name == 'CoordAcad' && activity.status > 2"
                @click="rejectActivity(activity)">Rechazar</button> -->

            <p class="card-text" v-if="activity.user_id">
                {{ activity.user.name }}
            </p>
        </div>
    </div>

    <!-- <div class="item-badges" v-if="task.fixed_task.fixed_activity">
                    <p class="h5">Actividad: {{ task.fixed_task.fixed_activity.title }}</p>
                    <p class="h6">Tarea: {{ task.fixed_task.title }}</p>
                </div> -->
</template>
<script>
import moment from "moment";
import { userStore } from "../../../../stores/UserStore";

export default {
    props: {
        activity: Object,
    },
    setup() {
        const store = userStore();
        return {
            store,
        };
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
            time: "00:00",
        };
    },
    methods: {
        rejectActivity(activity) {
            this.activity.status = 2;
            this.updateTaskInBd(this.activity.id, this.activity.status);
        },
        acceptActivity(activity) {
            this.activity.status = 4;
            this.updateTaskInBd(this.activity.id, this.activity.status);
        },
        sendToReview() {
            if (this.store.authUser.id == this.activity.user.id) {
                this.activity.status = 4;
                /* this.$emit('removeTask', this.activity.id) */
                this.updateTaskInBd(this.activity.id, this.activity.status);
            } else {
                this.$swal(
                    "Esta tarea no te pertenece para enviarla a revisión"
                );
            }
        },
        startCron() {
            var a = moment(new Date(this.task.start_time));
            console.log(a);

            this.interval = setInterval(() => {
                var b = moment(new Date());
                this.timer++;
                this.time = moment(b.diff(a)).format("mm:ss");
            }, 1000);
        },
        formatTime(time) {
            // Formatear el tiempo en un formato legible por humanos
            const minutes = Math.floor(time / 60);
            const seconds = time % 60;
            return `${minutes.toString().padStart(2, "0")}:${seconds
                .toString()
                .padStart(2, "0")}`;
        },
        stopCron() {
            clearInterval(this.interval);
        },
        startCronometer() {
            console.log("iniciando cronometro");

            this.interval = setInterval(() => {
                //document.getElementById('cronometer'+id).innerHTML = d.toLocaleTimeString()
            }, 1000);
        },
        stopCronometer() {
            console.log("stopeando cronometer");
            clearInterval(this.interval);
        },
        drag(e) {
            console.log(this.activity);
            e.dataTransfer.setData("taskStatus", this.activity.status);
            e.dataTransfer.setData("taskId", this.activity.id);
            e.dataTransfer.setData("owner", this.activity.user_id);

            console.log("este es mi id", e.target.id);
            /* if (this.task.status == 1) {

                
            } */
        },
        updateTaskInBd(taskId, status) {
            const fd = new FormData();
            fd.append("taskId", taskId);
            fd.append("newStatus", status);
            fd.append("user_id", this.store.authUser.id);
            axios
                .post("/api/changeTaskStatus", fd)
                .then((res) => {
                    this.$swal("Tarea enviada para revisión correctamente");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    computed: {
        formattedDate() {
            return moment(this.taskSelected.progress.start_time).format(
                "h:mm a"
            );
        },
        bgCard() {
            if (this.task.status == 0) {
                return "bg-danger";
            } else if (this.task.status == 1) {
                return "bg-warning";
            } else if (this.task.status == 2) {
                return "bg-success";
            }
        },
        calcStopwatch() {
            if (this.taskSelected.status == 2) {
                var cantStartTime = Date.parse(
                    this.taskSelected.progress.start_time
                );
                var cantEndTime = Date.parse(
                    this.taskSelected.progress.end_time
                );

                var totalTime = cantEndTime - cantStartTime;

                var totalSeconds = totalTime / 1000;
                if (totalSeconds >= 3600) {
                    var totalMinutes = Math.floor(totalSeconds / 60);
                    var restSeconds = totalSeconds % 60;
                    var totalHours = Math.floor(totalMinutes / 60);
                    var restMinutes = totalMinutes % 60;

                    return (
                        totalHours +
                        "h " +
                        restMinutes +
                        "m " +
                        restSeconds +
                        "s"
                    );
                } else if (totalSeconds >= 60) {
                    var totalMinutes = Math.floor(totalSeconds / 60);
                    var restSeconds = totalSeconds % 60;

                    return totalMinutes + "m " + restSeconds + "s";
                } else {
                    return totalSeconds + "s";
                }
            }
        },
    },
    mounted() {
        /* if (this.task.status == 1 && this.task.progress.owner == this.store.authUser.name) {
            this.startCron()
        } else if (this.task.status == 2) {
            this.stopCron()
        } */
    },
};
</script>
