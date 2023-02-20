<template>
   <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1" v-if="customer">Asignar Producto a {{ customer.name || customer.cell }}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col">
                        <label for="nameBasic" class="form-label">Producto</label>
                        <input type="text" v-model="product" class="form-control" @keyup="search"/>
                        <table class="table table-striped mb-3">
                            <tr v-for="product in products_filtered" @click="selectProduct(product)" class="cursor-pointer border border-light p-2">
                                {{ product.title }}
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-insert-project" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="assignProduct" class="btn btn-primary">Registrar</button>
                </div>   
                </div>
            </div>       
        </div>
</template>
<script>
import axios from 'axios';

export default {
    props:{
        customer: Object
    },
    data(){
        return{
            product: '',
            product_id:'',
            products: [],
            products_filtered:[]
        }
    },
    methods:{
        getAllProducts(){
            axios.get('./api/getAllProducts')
            .then(res =>{
                this.products = res.data
            })
            .catch(err =>{
                console.log(err.data)
            })
        },
        search(e){
            if(e.target.value != ''){
                this.products_filtered = this.products.filter((product) => {
                return  product.title.toLowerCase().includes(e.target.value)
                })
            }else{
                this.products_filtered = []
            }
        },
        selectProduct(product){
            this.product = product.title
            this.products_filtered = []
            this.product_id = product.id
        },
        assignProduct(){
            const fd = new FormData()

            fd.append('product_id', this.product_id)
            fd.append('customer_id', this.customer.id)

            axios.post('./api/assignProduct', fd)
            .then(res =>{
                this.$emit('getAllCustomers')
                $('#productModal').modal('hide')
            })
            .catch(err =>{
                console.log(err.data)
            })
        }
    },
    mounted(){
        this.getAllProducts()
    }
}
</script>
