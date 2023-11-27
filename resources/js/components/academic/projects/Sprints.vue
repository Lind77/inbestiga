<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Setup Sprints {{ $route.params.idProject }}</h1>
        <div class="row">
            <div class="col-4">
                <div class="card bg-info mb-2 cursor-pointer" v-for="product in products" :draggable="true">
                    <div class="card-body text-white">
                        {{ product.name }}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="d-flex flex-row" v-for="delivery in deliveries">
                    <div class="card shadow-none bg-transparent border border-info mt-2 w-75">
                        <div class="card-body">
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
            products: []
        }
    },
    methods: {
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