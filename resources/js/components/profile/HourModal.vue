<template>
    <div class="modal fade" id="hourModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Editar Hora de {{ nameDays[schedule.day] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <small class="text-light fw-semibold d-block">Replicar los días</small>
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
                    <!-- <div class="row">
                        <button class="btn btn-warning" @click="addMeeting(schedule)"
                            v-if="schedule.type == 1">Reunión</button>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-insert-customer" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="insertDelivery" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from '../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    props: {
        schedule: Object
    },
    data() {
        return {
            weekDays: [],
            nameDays: {
                1: 'Lunes',
                2: 'Martes',
                3: 'Miércoles',
                4: 'Jueves',
                5: 'Viernes',
                6: 'Sábado'
            },
            admission_time: '',
            departure_time: ''
        }

    },
    methods: {
        addMeeting(schedule) {
            this.$emit('addMeeting', schedule)
        },
        insertDelivery() {

            const fd = new FormData();
            fd.append('admission_time', this.schedule.admission_time)
            fd.append('departure_time', this.schedule.departure_time)
            fd.append('weekDays', JSON.stringify(this.weekDays))
            fd.append('user_id', this.store.authUser.id)
            fd.append('_method', 'put');

            axios.post('/api/schedules/' + this.schedule.id, fd)
                .then((result) => {
                    this.$emit('getUser', this.store.authUser.id)
                    console.log(this.store.authUser.id);
                    $('#hourModal').modal('hide')
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>
<style></style>