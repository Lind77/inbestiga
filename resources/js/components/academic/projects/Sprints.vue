<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Gestionar Sprint <button class="btn btn-success" @click="enableProject">Habilitar proyecto</button></h1>
        <div class="row">
            <div class="col-4">
                <div v-for="product in products" :id="product.id" class="btn btn-info w-100 mb-2 cursor-pointer"
                    :draggable="true" @dragstart="handleDragStart(product)">
                    {{ product.name }}
                </div>
            </div>
            <div class="col-8">
                <div class="d-flex flex-row" v-for="delivery in deliveries">
                    <div class="card shadow-none bg-transparent border border-info mt-2 w-75">
                        <div class="card-body" @dragover="dragOverDelivery(delivery)" @drop="dropProduct" @dragenter.prevent
                            @dragover.prevent>
                            <p>{{ delivery.advance }}</p>
                            <div v-for="product in delivery.assigned_activities" :id="product.id"
                                class="btn btn-info w-100 mb-2 cursor-pointer">
                                {{ product.name }}
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2 ">{{ formatDate(delivery.date) }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            deliveries: [],
            products: [],
            productSelected: {},
            deliverySelected: {},
            totalActivitiesAssigned: []
        }
    },
    methods: {
        handleDragStart(product) {
            this.productSelected = product
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

            axios.post('/api/assigned-activity', fd)
                .then((result) => {
                    this.getProject()
                }).catch((err) => {
                    console.error(err);
                });
        },
        getProject() {
            axios.get('/api/projects/' + this.$route.params.idProject)
                .then((result) => {
                    this.deliveries = result.data.deliveries

                    this.deliveries.forEach((delivery) => {
                        delivery.assigned_activities.forEach((assignment) => {
                            this.totalActivitiesAssigned.push({ ...assignment })
                        })

                    })

                }).catch((err) => {
                    console.error(err);
                });
        },
        getProducts() {
            axios.get('/api/academic-products')
                .then((result) => {
                    this.products = result.data
                }).catch((err) => {
                    console.error(err);
                });
        },
        formatDate(date) {
            return moment(date).format('DD/MM')
        },
        enableProject() {
            axios.get('/api/enable-project/' + this.$route.params.idProject)
                .then((result) => {
                    this.$swal('Proyecto habilitado correctamente')
                }).catch((err) => {
                    this.$swal('Hubo un error')
                });
        }
    },
    mounted() {
        this.getProject()
        this.getProducts()
    }
}
</script>
<style scoped>
.verticaltext {
    transform: rotate(90deg);
    transform-origin: left top 0;
}
</style>