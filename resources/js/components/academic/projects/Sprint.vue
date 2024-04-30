<template>
    <div class="row">
        <!-- <div class="col-4">
            <p class="h4">Productos</p>
            <input type="text" class="form-control mb-1" v-model="search" @keyup="filterAcademicProducts">
            <div id="container-products">
                <div v-for="product in productsFiltered" :id="product.id" class="btn btn-info w-100 mb-2 cursor-pointer"
                    :draggable="true" @dragstart="handleDragStart(product)">
                    {{ product.name }}
                </div>
            </div>
        </div> -->
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <p class="h4">Entregables</p>
            </div>

            <div class="" v-for="delivery in deliveries">
                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h5 class="text-primary mb-1">{{ delivery.advance }} <i class='bx bx-task'
                            title="Agregar nueva tarea" @click="openTaskModal(delivery.id)"></i></h5>
                    <div class="d-flex align-items-center">
                        <select class="form-control me-2" v-model="processSelected" @change="setProcess(delivery.id)">
                            <template v-for="process in processes">
                                <option :value="process.id">{{
                process.name }}</option>
                            </template>
                        </select>
                        <p class="mb-1">{{ delivery.date ? formatDate(delivery.date) :
                'Fecha Indefinida' }}</p>
                    </div>
                </div>
                <div class="text-nowrap" v-if="delivery.assigned_activities.length != 0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarea</th>
                                <th>Dueño</th>
                                <th>Prioridad</th>
                                <th>Puntos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr v-for="assignedActivity in delivery.assigned_activities">
                                <td>
                                    <TaskName :id="assignedActivity.id" :name="assignedActivity.name" />
                                </td>
                                <td>
                                    <UserTask :assignedActivity="assignedActivity" :team="team" />
                                </td>
                                <td>
                                    <!-- <span class="badge bg-label-warning me-1">{{
                assignedActivity.priority ? assignedActivity.priority : 'Sin asignar' }}</span> -->

                                    <div class="btn-group">
                                        <button type="button"
                                            :class="`btn btn-${priorityColor[assignedActivity.priority]} dropdown-toggle hide-arrow`"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ assignedActivity.priority ? priorityName[assignedActivity.priority] :
                'Sin asignar' }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" @click="setPriority(assignedActivity, 3)"
                                                    href="javascript:void(0);">Alta</a></li>
                                            <li><a class="dropdown-item" @click="setPriority(assignedActivity, 2)"
                                                    href="javascript:void(0);">Media</a>
                                            </li>
                                            <li><a class="dropdown-item" @click="setPriority(assignedActivity, 1)"
                                                    href="javascript:void(0);">Baja</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <Pointer :assignedActivity="assignedActivity" />
                                </td>
                                <td><span class="badge bg-label-success me-1">
                                        {{ statusByName[assignedActivity.status] }}
                                    </span>
                                </td>

                                <td>
                                    <button @click="deleteActivity(assignedActivity)"
                                        class="btn btn-icon btn-danger text-white">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-primary btn-icon text-white dropdown-toggle hide-arrow mx-1"
                                            @click="openIndicatorsModal(assignedActivity)">
                                            <i class='bx bx-info-square'></i>
                                        </button>
                                        <!-- <ul class="dropdown-menu">
                                            <li v-for="indicator in assignedActivity.quality_indicators"><a
                                                    class="dropdown-item" href="javascript:void(0);">{{ indicator.name
                                                    }}</a>
                                            </li>
                                        </ul> -->
                                    </div>
                                    <button @click="sendToKanban(assignedActivity)"
                                        v-if="assignedActivity.points && assignedActivity.priority && assignedActivity.status == null"
                                        class="btn btn-icon btn-success text-white">
                                        <i class="bx bx-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="row" >
                    <div class="col-6 px-1">
                        <div class="bg-info ps-2 py-2 border-start border-primary text-white rounded">
                            {{ assignedActivity.name }}
                        </div>
                    </div>
                    <div class="col-2 px-1">
                        <div class="bg-warning ps-2 py-2 text-white rounded">
                            Pendiente
                        </div>
                    </div>
                    <div class="col-2 px-1">
                        <div class="bg-danger ps-2 py-2 text-white rounded">
                            Alta
                        </div>
                    </div>
                    <div class="col-2 px-1">
                        <button class="btn btn-icon btn-danger text-white">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <IndicatorsModal :indicators="indicators" :assignedActivityId="updateDeliveryId" />
</template>
<script>
import moment from "moment"
import Pointer from "./Pointer.vue";
import TaskName from "./TaskName.vue";
import IndicatorsModal from "./IndicatorsModal.vue";
import UserTask from "./UserTask.vue";

export default {
    components: { Pointer, TaskName, IndicatorsModal, UserTask },
    props: {
        deliveries: Array,
        productsFiltered: Array,
        team: Object,
        processes: Array
    },
    data() {
        return {
            search: '',
            searchedProducts: [],
            academicProducts: [],
            statusByName: {
                0: 'Por Asignar',
                1: 'ToDo',
                2: 'Doing',
                3: 'Done',
                4: 'En revisión',
                5: 'Listo'
            },
            priorityColor: {
                null: 'primary',
                1: 'warning',
                2: 'info',
                3: 'success'
            },
            priorityName: {
                1: 'Baja',
                2: 'Media',
                3: 'Alta'
            },
            showPointer: false,
            points: 0,
            showCheck: true,
            indicators: {},
            showName: true,
            processSelected: 0,
            updateDeliveryId: 0
        }
    },
    methods: {
        setProcess(deliveryId) {
            this.$swal.fire({
                icon: 'question',
                title: 'Asignar proceso',
                html: '<br>¿Tienes la seguridad de continuar?,recuerda que esta acción actualizará una gran cantidad de información.',
                showDenyButton: true,
                confirmButtonText: 'Continuar',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    this.assignProcessesToSprint(deliveryId)
                } else if (result.isDenied) {
                    this.$swal.close()
                }
            })
        },
        assignProcessesToSprint(deliveryId) {
            axios.get(`/api/process-sprint/${this.processSelected}/${deliveryId}`)
                .then((result) => {
                    this.$swal('Proceso agregado con éxito')
                    this.$emit('getProject')
                }).catch((err) => {
                    console.log(err)
                });
        },
        openIndicatorsModal(assignedActivity) {
            this.updateDeliveryId = assignedActivity.id
            this.indicators = assignedActivity.quality_indicators
            $('#indicatorsModal').modal('show')
        },
        sendToKanban(assignedActivity) {
            axios.get('/api/assigned-activity-kanban/' + assignedActivity.id)
                .then((result) => {
                    this.showCheck = false;
                    this.$emit('getProject')
                }).catch((err) => {
                    console.error(err);
                });
        },
        deleteActivity(assignedActivity) {
            if (confirm('Tienes la seguridad de eliminar esta tarea?')) {
                axios.delete('/api/assigned-activity/' + assignedActivity.id)
                    .then((result) => {
                        this.$emit('getProject')
                    }).catch((err) => {
                        console.error(err);
                    });
            }
        },
        closePointer(assignedActivity) {
            assignedActivity.points = this.points
            axios.get('/api/assigned-activity-points/' + assignedActivity.id + '/' + this.points)
                .then((result) => {
                    this.showPointer = false;
                }).catch((err) => {
                    console.error(err);
                });
        },
        editPoints() {
            this.showPointer = true;
        },
        setPriority(assignedActivity, priority) {
            assignedActivity.priority = priority
            axios.get('/api/assigned-activity-priority/' + assignedActivity.id + '/' + priority)
                .then((result) => {
                    $('.dropdown-menu').removeClass('show')
                }).catch((err) => {
                    console.error(err);
                });
        },
        openTaskModal(deliveryId) {
            this.$emit('openModalTask', deliveryId)
        },
        formatDate(date) {
            return moment(date).format('DD/MM')
        },
        dragOverDelivery(delivery) {
            this.deliverySelected = delivery

            axios.post('/api/assigned-activity', fd)
                .then((result) => {
                    this.$emit('getProject')
                }).catch((err) => {
                    console.error(err);
                });
        },
        dropProduct(e) {
            e.preventDefault()
            e.target.appendChild(document.getElementById(this.productSelected.id))

            const fd = new FormData()

            fd.append('name', this.productSelected.name)
            fd.append('date', this.deliverySelected.date)
            fd.append('academic_date', this.deliverySelected.date)
            fd.append('assigned_activitiable_id', this.deliverySelected.id)
            fd.append('assigned_activitiable_type', 'App\\Models\\Delivery')
            fd.append('status', 0)

            axios.post('/api/assigned-activity', fd)
                .then((result) => {
                    this.$emit('getProject')
                }).catch((err) => {
                    console.error(err);
                });
        },
        handleDragStart(product) {
            this.productSelected = product
        },
        filterAcademicProducts() {
            this.$emit('filterAcademicProducts', this.search)
        }
    }
}
</script>
<style scoped>
#container-products {
    overflow-y: scroll;
    height: 75vh;
}

.border-start {
    border-left: 5px solid #d9dee3 !important
}
</style>