<template>
    <div class="modal fade" id="newTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Tarea</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="close-progress-modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="row mb-3">
                    <div class="col">
                        <label for="firstMeetingDate" class="form-label">Fecha</label>
                        <input type="date" name="" id="firstMeetingDate" class="form-control">
                    </div>
                    <div class="col">
                        <label for="firstMeetingTime" class="form-label">Hora</label>
                        <input type="time" name="" id="firstMeetingTime" class="form-control">
                    </div>
                </div> -->
                    <div class="mb-3">
                        <label for="firstMeetingDetails" class="form-label"
                            >Nombre de la nueva tarea</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            v-model="name"
                            @keyup.enter="searchTask"
                        />
                        <select
                            v-show="showTaskPicker"
                            v-model="taskPicked"
                            @change="selectTaskFounded"
                            class="form-control"
                        >
                            <option
                                :value="task.id"
                                v-for="task in tasksFounded"
                            >
                                {{ task.name }}
                            </option>
                        </select>
                        <div class="mb-3" v-show="showProcessPicker">
                            <label for="" class="form-label"
                                >Proceso académico</label
                            >
                            <select
                                v-if="processes.length > 1"
                                v-model="processSelected"
                                class="form-control"
                            >
                                <option
                                    :value="process.id"
                                    v-for="process in processes"
                                >
                                    {{ process.name }}
                                </option>
                            </select>
                            <p v-if="processes.length == 1">
                                {{ processes[0].name }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="firstMeetingDetails" class="form-label"
                            >Fecha</label
                        >
                        <input
                            type="date"
                            class="form-control"
                            v-model="date"
                        />
                    </div>
                    <hr />
                    <div
                        class="d-flex align-items-center justify-content-between"
                    >
                        <label for="" class="form-label"
                            >Criterios de aceptación</label
                        >
                        <button
                            class="btn btn-icon btn-primary"
                            @click="newIndicator"
                        >
                            +
                        </button>
                    </div>

                    <class class="mb-2">
                        <template
                            v-for="(indicator, index) in indicators"
                            :key="index"
                        >
                            <label for="firstMeetingDetails" class="form-label"
                                >Criterio {{ index + 1 }}</label
                            >
                            <i
                                class="bx bx-trash text-danger"
                                @click="deleteIndicator(index)"
                            ></i>
                            <input
                                type="text"
                                class="form-control"
                                v-model="indicator.value"
                            />
                        </template>
                    </class>

                    <!-- <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Archivos importantes</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple="">
                </div>  -->
                </div>

                <div class="modal-footer">
                    <input
                        type="submit"
                        class="btn btn-primary"
                        value="Asignar"
                        @click="saveNewTask"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: "",
            date: "",
            indicators: [],
            tasksFounded: [],
            taskPicked: 0,
            showTaskPicker: false,
            showProcessPicker: false,
            processes: [],
            processSelected: 0,
        };
    },
    props: {
        deliveryId: Number,
    },
    methods: {
        searchTask() {
            axios
                .get("/api/search-task/" + this.name)
                .then((result) => {
                    this.tasksFounded = result.data;
                    this.showTaskPicker = true;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        selectTaskFounded() {
            var taskSelected = this.tasksFounded.find(
                (task) => task.id == this.taskPicked
            );
            this.processes = taskSelected.academic_processes;
            if (this.processes.length == 1) {
                this.processSelected = this.processes[0].id;
            }
            this.name = taskSelected.name;
            this.showTaskPicker = false;
            this.showProcessPicker = true;
            taskSelected.acceptance_indicators.forEach((indicator) => {
                var newIndicator = {
                    value: indicator.name,
                };

                this.indicators.push({ ...newIndicator });
            });
        },
        saveNewTask() {
            const fd = new FormData();

            fd.append("name", this.name);
            fd.append("date", this.date);
            fd.append("indicators", JSON.stringify(this.indicators));
            fd.append("deliveryId", this.deliveryId);
            fd.append("academic_process_id", this.processSelected);
            axios
                .post("/api/assigned-activity", fd)
                .then((res) => {
                    this.$emit("getProject");
                    this.name = "";
                    this.date = "";
                    this.indicators = [];
                    this.tasksFounded = [];
                    $("#newTaskModal").modal("hide");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        deleteIndicator(index) {
            this.indicators.splice(index, 1);
        },
        newIndicator() {
            var indicator = {
                value: "",
            };
            this.indicators.push({ ...indicator });
        },
        insertDetailsFirstMeeting() {
            const fd = new FormData();
            fd.append("activityId", this.activity.id);
            fd.append("detail", this.detail);

            axios
                .post("/api/insertDetailsFirstMeeting", fd)
                .then((res) => {
                    this.detail = "";
                    $("#firstMeetModal").modal("hide");
                    this.$emit("colorActivity", this.activity);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
