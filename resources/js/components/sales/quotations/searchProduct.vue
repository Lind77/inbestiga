<template>
    <div class="col-6">
        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Producto</label>
            <input type="text" id="inputSearch" autocomplete="off" class="form-control" @keyup="search"/>
            <table class="table table-bordered mb-3">
            <tr v-for="product in filtered_products">
                <td class="cursor-pointer">{{product.title}} - S./ {{ product.amountLevel }}</td>
            </tr>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            filtered_products: []
        }
    },
    props:{
        level: String,
        products: Array
    },
    methods:{
        search(e){
           if(this.level == 0){
            this.$swal('Porfavor seleccione el nivel')
           }else{
           this.filtered_products = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
            
           }
        }
      }
    }
</script>
