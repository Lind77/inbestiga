<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1">Editar Cotización</h4>
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar cotización.</h5>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col">
                <div class="card shadow-none bg-transparent border border-info mb-3"  v-if="customerSelected.id">
                    <div class="card-body">
                    <h5 class="card-title">Cliente: {{ customerSelected.name }}</h5>
                    <p class="card-text">
                    Teléfono: {{ customerSelected.cell }}
                    </p>
                    <p class="card-text">
                    Carrera: {{ customerSelected.career }}
                    </p>
                    <p class="card-text">
                    Universidad: {{ customerSelected.university }}
                    </p>
                    <!-- <p class="card-text">
                    Estado: {{ status[customerSelected.status] }}
                    </p> -->
                </div>
                </div>
                </div>
                <div class="col">
                <div class="card shadow-none bg-transparent border border-info mb-3">
                    <div class="card-body p-3">
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-company">Fecha <span class="text-danger">*</span></label>
                        <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-company">Validez</label>
                        <p>{{  finalDayMonth }}</p>
                    </div>
                </div>
                </div>
                </div>
                </div>
                <h5 class="mb-4">Productos</h5>
                <div class="row mb-3">
                <div class="col-6">
                <label class="form-label" for="basic-default-company">Nivel</label>
                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" v-model="level">
                    <option selected="">Seleccione un nivel</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                </div>
                <searchProduct :level="level" :products="fixed_products"/>
                </div>
                <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-primary">
                    <tr>
                        <th>Producto/Servicio</th>
                        <th>Total</th>
                        <th>Borrar</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(product, index) in products" :key="index">
                        <td>{{ product.product.title }}</td>
                        <td>S./ {{ product.price }}</td>
                        <td><a @click="removeCart(index)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <!-- 
                
                
                <div class="row">
                <div class="col-sm-12 col-lg-6">
                <div class="mb-3">
                    <p>TOTAL:  S./ {{ totalProducts }}</p>
                </div>
                </div>
                </div> -->
                <!-- <h5 class="mb-4">Producto Sugerido</h5>
                <div class="row">
                <div class="col-6">
                <label class="form-label" for="basic-default-company">Nivel</label>
                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" v-model="levelSugested">
                    <option selected="">Seleccione un nivel</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                </div>
                <div class="col-6">
                <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Producto</label>
                    <input type="text" id="inputSearch" autocomplete="off" class="form-control" v-model="searchSugestedProduct" @keyup="searchSugested"/>
                    <table class="table table-bordered mb-3">
                    <tr v-for="product in filtered_products_sugested">
                        <td class="cursor-pointer" @click="addCartSuggested(product)">{{product.title}} - S./ {{ product.amountLevel }}</td>
                    </tr>
                    </table>
                </div>
                </div>
                </div>
                <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-primary">
                    <tr>
                        <th>Producto/Servicio</th>
                        <th>Total</th>
                        <th>Borrar</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <tr v-for="(product, index) in carSugestedProducts" :key="index">
                        <td>{{ JSON.parse(product).title }}</td>
                        <td>S./ {{ JSON.parse(product).total }}</td>
                        <td><a @click="removeSuggestedCart(index)" class="btn btn-danger text-white"><i class='bx bx-trash'></i></a></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="row">
                <div class="col-sm-12 col-lg-6">
                <div class="mb-3">
                    <p>TOTAL: S./ {{ totalSuggestedProducts }}</p>
                </div>
                </div>
                </div> -->
                <!-- <div class="row">
                <div class="col-6">
                <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Descuento</label>
                    <input type="text" class="form-control" v-model="discount">
                </div>
                </div>
                <div class="col-6">
                <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Tiempo de Ejecucion <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="term">
                </div>
                </div>
                </div> -->
                <!-- <div class="row">
                <div class="col-sm-12 col-lg-6">
                <div class="mb-3">
                    <p>TOTAL FINAL: S./ {{ totalProducts - discount }}</p>
                </div>
                </div>
                </div>
                <button @click="insertQuotation" class="btn btn-primary mt-2 text-white">Guardar</button>
                <router-link v-if="this.idQuotation != 0" :to="{name:'quotation-file', params:{ id: this.idQuotation }}" target="_blank" class="btn btn-primary mt-2 mx-2 text-white" disabled>Imprimir</router-link> -->
                <!-- <button class="btn btn-primary" @click="generatePDF">PDF</button> -->
            </div>
            </div>
        </div>
    </div>


      <!-- Basic Layout -->
     <!--  <div class="row">
        <div class="col-xl">
          
        </div>
      </div>
      <calcModal @addCartModal="addCartModal"/>
      <InsertDetail @addCartModal="addCartModal" @addSugestCartModal="addSugestCartModal" :product="selected_product" :products="fixed_products"/> -->
</div>
</template>
<script>
import moment from 'moment'

import searchProduct from './searchProduct.vue'

export default {
    components: {searchProduct},
    data(){
        return{
            quotation: [],
            customerSelected: {},
            date: null,
            products: [],
            level: '',
            searchProduct: '',
            fixed_products: []
        }
    },
    methods:{
        getQuotation(){
            axios.get('/api/quotation/'+ this.$route.params.idQuot)
            .then(res =>{
                this.quotation = res.data[0]
                this.customerSelected = this.quotation.customer
                this.date = this.quotation.date
                this.products = this.quotation.details
            })
            .catch(err =>{
                console.log(err.data)
            })
        },
        getAllProducts(){
        axios.get('/api/getAllProducts')
        .then(res =>{
          this.fixed_products = res.data
        })
        .catch(err =>{
          console.log(err.response.data)
        })
        }
    },
    mounted(){
        this.getQuotation()
        this.getAllProducts()
    },
    computed:{
        finalDayMonth(){
        return moment().endOf('month').format('DD/MM/YYYY')
        }
    }
}
</script>
<style lang="">
    
</style>