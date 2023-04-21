<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1">Precios <span class="badge bg-label-primary me-1 cursor-pointer" @click="openNewProductModal">+</span></h4>
        <div class="col-xl-12">
            <input type="text" @keyup="filterProducts" placeholder="Buscar producto..." class="form-control w-50">
            <div class="row mt-2">
                <div class="col-4 mb-2" v-for="product in products_filtered">
                    <div class="card">
                        <div class="card-header">
                            {{ product.name }}  <i @click="showModalPrices(product)" class='text-primary bx bx-edit' ></i>
                            <br>
                            <button class="btn btn-sm btn-success m-1" v-for="price in product.newprices">
                                S./ {{ price.price }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ModalPrices :product="productSelected"/>
    <InsertNewProduct />
</template>
<script>
    import InsertNewProduct from './InsertNewProduct.vue'
    import ModalPrices from './ModalPrices.vue'
    export default{
        components:{ModalPrices, InsertNewProduct},
        data(){
            return{
                productSelected:[],
                products:[],
                products_filtered:[]
            }
        },
        methods:{
            openNewProductModal(){
                $('#newProductModal').modal('show')
            },
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
                this.products_filtered = this.products.filter(product => product.name.toLowerCase().includes(e.target.value))
                console.log(this.products_filtered)
            },
            showModalPrices(product){
                this.productSelected = product
                $('#pricesModal').modal('show')
            }
        },
        mounted(){
            this.getAllProductsWithPrices()
        }
    }
</script>