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
            <p class="h4">Entregables</p>

            <div class="" v-for="delivery in deliveries">
                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h5 class="text-primary mb-1">{{ delivery.advance }}</h5>
                    <p class="mb-1">{{ delivery.date ? formatDate(delivery.date) :
                'Fecha Indefinida' }}</p>
                </div>
                <hr class="my-1">
                <div v-for="assignedActivity in delivery.assigned_activities"
                    class="card card-border-shadow-primary p-2 w-100 mb-2 cursor-pointer">
                    <div class="ps-2 border-start border-primary ">
                        {{ assignedActivity.name }}
                    </div>
                </div>
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