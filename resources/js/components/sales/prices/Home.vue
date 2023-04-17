<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1">Precios </h4>
        <div class="col-xl-12">
            <input type="text" @keyup="filterProducts" placeholder="Buscar producto..." class="form-control w-50">
            <div class="row mt-2">
                <div class="col-4 mb-2" v-for="product in products_filtered">
                    <div class="card">
                        <div class="card-header">
                            {{ product.title }}  <i @click="showModalPrices(product.prices)" class='text-primary bx bx-edit' ></i>
                            <br>
                            <button class="btn btn-sm btn-success m-1" v-for="price in product.prices">
                                S./ {{ price.price }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ModalPrices :prices="prices_selected"/>
</template>
<script>
    import ModalPrices from './ModalPrices.vue'
    export default{
        components:{ModalPrices},
        data(){
            return{
                prices_selected:[],
                products:[],
                products_filtered:[]
            }
        },
        methods:{
            getAllProductsWithPrices(){
                axios.get('/api/getAllProductsWithPrices')
                .then((res) =>{
                    this.products = res.data
                    this.products_filtered = res.data
                })
                .catch((err) =>{

                })
            },
            filterProducts(e){
                this.products_filtered = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
                console.log(this.products_filtered)
            },
            showModalPrices(prices){
                this.prices_selected = prices
                $('#pricesModal').modal('show')
            }
        },
        mounted(){
            this.getAllProductsWithPrices()
        }
    }
</script>