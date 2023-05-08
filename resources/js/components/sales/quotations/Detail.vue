<template>
    <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
        <div class="d-flex border rounded position-relative pe-0">
        <div class="row w-100 m-0 p-3">
            <div class="col-md-2 col-12 mb-md-0 mb-3 ps-md-0">
            <p class="mb-2 repeater-title">Modo</p>
            <div class="col-md">
                <div class="form-check mt-3">
                    <input class="form-check-input" type="radio" v-model="newProduct.mode" @click="selectMode" value="1" id="type">
                    <label class="form-check-label" for="type"> Fragmentado </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" v-model="newProduct.mode" @click="selectMode" value="2" id="type">
                    <label class="form-check-label" for="type"> Paquete </label>
                </div>
            </div>
            </div>
            <div class="col-md-2 col-12 mb-md-0 mb-3 ps-md-0">
            <p class="mb-2 repeater-title">Nivel</p>
            <select v-model="newProduct.level" @change="selectLevel" class="form-select item-details mb-2">
                <option selected="" disabled="">Selecciona el Nivel</option>
                <template v-if="newProduct.mode == 2">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                </template>
                <template v-else>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                </template>
            </select>
            </div>
            <div class="col-md-4 col-12 mb-md-0 mb-3">
            <p class="mb-2 repeater-title">Detalle</p>
            <input type="text" class="form-control" @keyup="searchNewProduct" v-model="newProduct.new_product.name">
            <ul class="list-group">
                <li @click="addPrice(newProductByName)" class="list-group-item d-flex justify-content-between align-items-center cursor-pointer" v-for="newProductByName in newProductsByName">
                {{ newProductByName.name }}
                <span class="badge bg-primary">S./ {{ newProductByName.newPriceSelected.price }}</span>
                </li>
            </ul>
            </div>
            <div class="col-md-2 col-12 pe-0">
            <p class="mb-2 repeater-title">Precio</p>
            <p class="mb-0">S./{{ newProduct.price }}</p>
            </div>
            <div class="col-md-2 col-12 mb-md-0 mb-3">
            <p class="mb-2 repeater-title">Tipo</p>
            <div class="col-md">
                <div class="form-check mt-3">
                    <input class="form-check-input" type="radio" v-model="newProduct.type" value="1" id="type">
                    <label class="form-check-label" for="type"> Normal </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" v-model="newProduct.type" value="2" id="type">
                    <label class="form-check-label" for="type"> Sugerido </label>
                </div>
            </div>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
            <i class="bx bx-x fs-4 text-muted cursor-pointer" data-repeater-delete="" @click="removeSuggestedCart(index)"></i>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            carNewProduct: {
                mode:'',
                level: '',
                new_product: {
                    name: ''
                },
                price:''
            },
            newProductsByType:[],
            newProductsByName: []
        }
    },
    props:{
        newProduct: Object,
        newProducts: Array
    },
    methods:{
        removeSuggestedCart(){
            alert()
        },
        selectMode(e){
            this.newProductsByType = this.newProducts.filter(product => product.type == e.target.value)
            console.log(this.newProductsByType)
        },
        searchNewProduct(e){  
        if(e.target.value != ''){
            this.newProductsByName = this.newProductsByType.filter(product => product.name.toLowerCase().includes(e.target.value))
            this.newProductsByName.forEach((product)=>{
                product.newPriceSelected = product.newprices.find(price => price.level == this.newProduct.level)
            })
        }else{
            this.newProductsByName = []
        }
        },
        addPrice(newProductByName){
            console.log(newProductByName)
            this.newProduct.price = newProductByName.newPriceSelected.price
            this.newProduct.new_product.name = newProductByName.name
            this.newProduct.new_product_id = newProductByName.id
            this.newProductsByName = []
        }
    }
}
</script>
<style>
    
</style>