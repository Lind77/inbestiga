<template>
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Agregar producto</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <label class="form-label">Producto</label>
              <p>{{ newProduct.name }}</p>
            </div>
            <div class="row">
              <label class="form-label">Nivel</label>
              <p>{{ newProduct.newPriceSelected?newProduct.newPriceSelected.level:'' }}</p>
            </div>
            <div class="row">
              <template v-if="newProduct.mode == 1">
                <div>
                  Calcular precio por unidad (S./ {{ newProduct.newPriceSelected.price }})
                  <input type="number" v-model="cant" class="form-control" min="1">
                </div>
              </template>
              <template v-if="newProduct.mode == 2">
                <div>
                 Precio Fijo
                </div>
              </template>
            </div>
            <div class="row mt-2">
              <p>TOTAL: S./ {{  totalPrice }}</p>
            </div>
            <div class="row g-2">
              <div class="col-md">
                <div class="form-check form-check-inline mt-3">
                  <input class="form-check-input" type="radio" v-model="typeDetail" name="inlineRadioOptions" id="inlineRadio1" value="1">
                  <label class="form-check-label" for="inlineRadio1">Normal</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" v-model="typeDetail" name="inlineRadioOptions" id="inlineRadio2" value="2">
                  <label class="form-check-label" for="inlineRadio2">Sugerido</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="insertCarProducts">Añadir</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
  export default{
    data(){
      return{
        cant: 1,
        typeDetail: 1
      }
      
    },
    props:{
      newProduct: Object
    },
    methods:{
      insertCarProducts(){
        this.newProduct.priceFinal = this.totalPrice
        this.newProduct.typeDetail = this.typeDetail
        this.$emit('insertCarProducts', this.newProduct)
        $('#productModal').modal('hide')
      }
    },
    computed:{
      totalPrice(){
        if(this.newProduct.newPriceSelected){
          return (this.cant*this.newProduct.newPriceSelected.price).toFixed(2)
        }
        
      }
    }
  }
</script>