<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Gestionar Sprint {{ $route.params.idProject }}</h1>
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
                        <div class="card-body" @drop="dropProduct" @dragenter.prevent @dragover.prevent>
                            <p>{{ delivery.advance }}</p>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2 ">{{ formatDate(delivery.date) }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';

export default {
    data() {
        return {
            deliveries: [],
            products: [],
            productSelected: 0
        }
    },
    methods: {
        handleDragStart(product) {
            this.productSelected = product.id
        },
        dropProduct(e) {
            e.preventDefault()
            e.target.appendChild(document.getElementById(this.productSelected))
            //alert(this.productSelected)
        },
        getProject() {
            axios.get('/api/projects/' + this.$route.params.idProject)
                .then((result) => {
                    this.deliveries = result.data.deliveries
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