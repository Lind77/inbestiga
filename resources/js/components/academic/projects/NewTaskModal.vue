<template>
    <div class="modal fade" id="newTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Nueva Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-progress-modal"></button>
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
                        <label for="firstMeetingDetails" class="form-label">Nombre de la nueva tarea</label>
                        <input type="text" class="form-control" v-model="name">
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="" class="form-label">Criterios de aceptación</label>
                        <button class="btn btn-icon btn-primary" @click="newIndicator">+</button>
                    </div>

                    <class class="mb-2">
                        <template v-for="(indicator, index) in indicators" :key="index">
                            <label for="firstMeetingDetails" class="form-label">Criterio {{ index + 1 }}</label> <i
                                class="bx bx-trash text-danger" @click="deleteIndicator(index)"></i>
                            <input type="text" class="form-control" v-model="indicator.value">
                        </template>
                    </class>

                    <!-- <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Archivos importantes</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple="">
                </div>  -->
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Asignar" @click="saveNewTask" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: '',
            indicators: []
        }
    },
    props: {
        deliveryId: Number
    },
    methods: {
        saveNewTask() {
            const fd = new FormData();

            fd.append('name', this.name)
            fd.append('indicators', JSON.stringify(this.indicators))
            fd.append('deliveryId', this.deliveryId)
            axios.post('/api/academic-product', fd)
                .then((res) => {
                    this.$emit('getProject')
                    $('#newTaskModal').modal('hide')
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        deleteIndicator(index) {
            this.indicators.splice(index, 1)
        },
        newIndicator() {
            var indicator = {
                value: ''
            }
            this.indicators.push({ ...indicator })
        },
        insertDetailsFirstMeeting() {
            const fd = new FormData()
            fd.append('activityId', this.activity.id)
            fd.append('detail', this.detail)

            axios.post('/api/insertDetailsFirstMeeting', fd)
                .then((res) => {
                    this.detail = ''
                    $('#firstMeetModal').modal('hide')
                    this.$emit('colorActivity', this.activity)
                })
                .catch((err) => {
                    console.error(err)
                })
        }
    }
}
</script>