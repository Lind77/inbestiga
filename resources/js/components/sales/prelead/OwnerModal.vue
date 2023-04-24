<template>
    <div class="modal fade" id="ownerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Asignar dueño del Lead {{ customerId }}</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col mb-1">
                    <label for="nameSmall" class="form-label">¿Qué necesita el cliente?</label>
                    <input type="text" name="" id="" v-model="search" @keyup="searchProduct" class="form-control">
                </div>
                </div>
                
                <ul class="list-group">
                    <li v-for="product in filteredProducts" @click="pickProduct(product)" class="list-group-item d-flex justify-content-between align-items-center">{{ product.name }}</li>
                </ul>
                <div class="row">
                    <div class="col mb-3">
                        <label for="">Productos Seleccionados</label>
                        <ul>
                            <li v-for="product in selectedProducts">{{ product.name }}<span class="text-danger" @click="removeProduct(product)"> X</span></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                <div class="col mb-3">
                    <label for="nameSmall" class="form-label">Dueño del Lead</label>
                    <select v-model="seller_selected" class="form-select">
                        <option :value="seller.user.id" v-for="seller in sellers">
                            {{ seller.user.name }}
                        </option>
                    </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Salir
                </button>
                <button type="button" class="btn btn-primary" @click="assignSeller">Asignar</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import axios from 'axios'

export default {
    props:{
        customerId: Number
    },
    data(){
        return{
            seller_selected: '',
            sellers:[],
            search: '',
            products:[],
            filteredProducts:[],
            selectedProducts:[]
        }
    },
    methods:{
        pickProduct(product){
            this.selectedProducts.push(product)
            this.filteredProducts = []
            this.search = ''
        },
        removeProduct(product){
            let index = this.selectedProducts.indexOf(product.id == product.id)
            this.selectedProducts.splice(index, 1)
        },
        searchProduct(){
            if(this.search != ''){
                this.filteredProducts = this.products.filter(product => product.name.toLowerCase().includes(this.search))
            }else{
                this.filteredProducts = []
            }
            
        },
        assignSeller(){
            const fd =  new FormData()
            fd.append('customer_id', this.customerId)
            fd.append('seller_selected', this.seller_selected)
            fd.append('products', JSON.stringify(this.selectedProducts))
            axios.post('/api/assignOwner', fd)
            .then(res =>{
                $('#ownerModal').modal('hide')
                this.$emit('cleanLead', this.customerId, this.seller_selected)
            })
            .catch(err =>{
                console.error(err)
            })

        },
        getAllSellers(){
            axios.get('/api/getAllSellers')
            .then(res =>{
                this.sellers = res.data
            })
            .catch(err =>{
                console.error(err)
            })
        },
        getAllProducts(){
            axios.get('/api/getAllNewProducts')
            .then(res =>{
                this.products = res.data
            })
            .catch(err =>{
                console.error(err)
            })
        }
    },
    mounted(){
        this.getAllSellers()
        this.getAllProducts()
    }

}
</script>