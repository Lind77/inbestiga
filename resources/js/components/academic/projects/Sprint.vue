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
                    <div>
                        <p class="mb-1">{{ delivery.date ? formatDate(delivery.date) :
                'Fecha Indefinida' }}</p>
                    </div>
                </div>
                <div class="table-responsive text-nowrap" v-if="delivery.assigned_activities.length != 0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarea</th>
                                <th>Dueño</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr v-for="assignedActivity in delivery.assigned_activities">
                                <td>
                                    <div class="bg-info ps-2 py-2 border-start border-primary text-white rounded">
                                        {{ assignedActivity.name }}
                                    </div>
                                </td>
                                <td>{{ assignedActivity.user ? assignedActivity.user.name : 'Sin signar' }}</td>
                                <td>
                                    <span class="badge bg-label-warning me-1">{{
                assignedActivity.priority ? assignedActivity.priority : 'Sin asignar' }}</span>
                                </td>
                                <td><span class="badge bg-label-danger me-1">
                                        {{ assignedActivity.status }}
                                    </span></td>
                                <td>
                                    <button class="btn btn-icon btn-danger text-white">
                                        <i class="bx bx-trash"></i>
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
</template>
<script>
import moment from "moment"
export default {
    props: {
        deliveries: Array,
        productsFiltered: Array
    },
    data() {
        return {
            search: '',
            searchedProducts: [],
            academicProducts: []
        }
    },
    methods: {
        openTaskModal(deliveryId) {
            this.$emit('openModalTask', deliveryId)
        },
        formatDate(date) {
            return moment(date).format('DD/MM')
        },
        dragOverDelivery(delivery) {
            this.deliverySelected = delivery
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