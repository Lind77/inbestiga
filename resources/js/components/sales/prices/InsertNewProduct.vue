<template>
    <div class="modal fade" id="newProductModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Agregar nuevo producto</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <fieldset>
                <legend>Información del producto</legend>
                <label for="nombre-producto">Nombre del producto:</label>
                <input type="text" id="nombre-producto" v-model="productName" class="form-control" required>
                
                <label for="tipo-producto">Tipo de producto:</label>
                <select id="modo-producto" name="modo-producto" class="form-select" required v-model="productType">
                    <option value="">Selecciona el tipo</option>
                    <option value="1">Servicio Fragmentado</option>
                    <option value="2">Paquete</option>  
                </select>
                
                <label for="modo-producto">Modo de producto:</label>
                <select id="modo-producto" name="modo-producto" class="form-select" required v-model="productMode">
                    <option value="">Selecciona el modo</option>
                    <option value="1">Por unidad</option>
                    <option value="2">Precio estandar</option>
                </select>
            </fieldset>
            <fieldset>
                <legend>Precios</legend>
            </fieldset>
            <div class="row" v-for="(price, index) in prices" :key="index">
                  <div class="col-3">
                    Nivel {{index}}
                  </div>
                  <div class="col-7">
                    <input type="number" :placeholder="`Nivel ${index}`" v-model="prices[index]" class="form-control mt-1"/>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="insertNewProduct">Insertar</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                productName: '',
                productType: 0,
                productMode: 0,
                prices: [
                  0,
                  0,
                  0,
                  0,
                  0,
                  0
                ] 
            }
        },
        methods:{
            insertNewProduct(){
                const fd = new FormData()
                fd.append('name',this.productName)
                fd.append('type',this.productType)
                fd.append('mode',this.productMode)
                fd.append('prices',JSON.stringify(this.prices))

                axios.post('/api/insertNewProduct', fd)
                .then(res =>{
                    console.log(res)
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
            }
        }
    }
</script>