<template>
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Agregar Horario</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">La cantidad de horas se destribuirá en intervalos de una
                        hora</div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Horario de Ingreso</label>
                            <input type="time" v-model="schedule.admission_time" class="form-control">
                        </div>
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Horario de Salida</label>
                            <input type="time" v-model="schedule.departure_time" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <small class="text-light fw-semibold d-block">Días</small>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" v-model="weekDays"
                                    value="1">
                                <label class="form-check-label" for="inlineCheckbox1">L</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" v-model="weekDays"
                                    value="2">
                                <label class="form-check-label" for="inlineCheckbox2">M</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" v-model="weekDays"
                                    value="3">
                                <label class="form-check-label" for="inlineCheckbox3">M</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" v-model="weekDays"
                                    value="4">
                                <label class="form-check-label" for="inlineCheckbox4">J</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" v-model="weekDays"
                                    value="5">
                                <label class="form-check-label" for="inlineCheckbox5">V</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" v-model="weekDays"
                                    value="6">
                                <label class="form-check-label" for="inlineCheckbox6">S</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="addSchedule" type="button" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { userStore } from '../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    data() {
        return {
            weekDays: [],
            schedule: {
                admission_time: '',
                departure_time: ''
            }
        }
    },
    methods: {
        addSchedule() {
            const fd = new FormData()

            fd.append('admission_time', this.schedule.admission_time)
            fd.append('departure_time', this.schedule.departure_time)
            fd.append('type', 1)
            fd.append('weekdays', JSON.stringify(this.weekDays))
            fd.append('user_id', this.store.authUser.id)

            axios.post('/api/schedules', fd)
                .then((result) => {
                    console.log(result.data);
                }).catch((err) => {
                    console.error(err)
                });
        }
    }
}
</script>