<template>
    <div class="row">
        <div class="col-4">
            <p class="h4">Productos</p>
            <input type="text" class="form-control mb-1" v-model="search" @keyup="filterAcademicProducts">
            <div id="container-products">
                <div v-for="product in searchedProducts" :id="product.id" class="btn btn-info w-100 mb-2 cursor-pointer"
                    :draggable="true" @dragstart="handleDragStart(product)">
                    {{ product.name }}
                </div>
            </div>
        </div>
        <div class="col-8">
            <p class="h4">Entregables</p>
            <div class="d-flex flex-row" v-for="delivery in deliveries">
                <button class="btn btn-primary mt-2 ">{{ delivery.date ? formatDate(delivery.date) :
                    'Indefinido'
                }}</button>
                <div class="card shadow-none bg-transparent border border-info mt-2 w-75">
                    <div class="card-body" @dragover="dragOverDelivery(delivery)" @drop="dropProduct" @dragenter.prevent
                        @dragover.prevent>
                        <p>{{ delivery.advance }}</p>
                        <div v-for="assignedActivity in delivery.assigned_activities"
                            class="btn btn-info w-100 mb-2 cursor-pointer">
                            {{ assignedActivity.name }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment"
export default {
    data() {
        return {
            search: '',
            searchedProducts: this.productsFiltered
        }
    },
    props: {
        deliveries: Array,
        productsFiltered: Array
    },
    methods: {
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
            this.searchedProducts = this.productsFiltered.filter(product => product.name.toLowerCase().includes(this.search))
        }
    }
}
</script>
<style scoped>
#container-products {
    overflow-y: scroll;
    height: 75vh;
}
</style>