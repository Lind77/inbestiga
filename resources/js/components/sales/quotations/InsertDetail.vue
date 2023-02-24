<template>
    <div class="modal fade" id="insertDetailModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Insertar detalle de cotización</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <p>Producto: {{ product.title }} </p>
                <p>Nivel: {{ product.level }} </p>
                <p>Costo: S./ {{ product.amountLevel }}</p>
            </div>
            <div class="row">
                <div class="col mb-0">
                    <label class="form-label" for="emailSmall">Descripción</label>
                    <textarea class="form-control" v-model="description" rows="3"></textarea>
                </div>
                
            </div>
            <!-- <div class="row">
                <div class="col mb-0">
               
                <p v-if="minTimeEstimated">Tiempo mínimo estimado: {{ secondsToString(minTimeEstimated[0].min_time) }}</p>
                <p v-if="minTimeEstimated">Tiempo máximo estimado: {{ secondsToString(minTimeEstimated[0].max_time) }}</p>
                
                </div>
                
            </div> -->
            <!-- <div class="row">
                <label class="form-label" for="emailSmall">Plazo</label>
                <div class="col-6">
                    <input type="number" @change="calcTime" class="form-control" v-model="cantTime">
                </div>
                <div class="col-6">
                    <select @change="calcTime" id="tagsTime" v-model="typeTime" class="form-select">
                        <option value="86400">Días</option>
                        <option value="604800">Semanas</option>
                        <option value="2419200">Meses</option>
                    </select>
                </div>
            </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" id="addDetail" class="btn btn-primary" @click="addCart">Añadir</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
export default {
    props:{
        product: Object,
        products: Array
    },
    data(){
        return{
            description:'',
            cantTime: 0,
            typeTime: 0
        }
    },
    methods:{
        addCart(){
            var e = document.getElementById("tagsTime")

            var productModal = {}

            productModal.id = this.product.id
            productModal.title = this.product.title
            productModal.description = this.description
            productModal.total = this.product.amountLevel

            if(this.product.typeOp == 1){
                this.$emit('addCartModal', productModal)
            }else{
                this.$emit('addSugestCartModal', productModal)
            }
            
            $('#insertDetailModal').modal('hide')

            this.description = ''
            this.cantTime =  0
            this.typeTime = 0
        },
        secondsToString(seconds) {

        var day = Math.floor(seconds/86400)    

        var hour = Math.floor(seconds / 3600);
        hour = (hour < 10)? '0' + hour : hour;
        var minute = Math.floor((seconds / 60) % 60);
        minute = (minute < 10)? '0' + minute : minute;
        var second = seconds % 60;
        second = (second < 10)? '0' + second : second;

        var hourReal = hour - (day*24)    

        return day+'d '+hourReal + ':' + minute + ':' + second;
        }
    },
    computed:{
        minTimeEstimated(){
            
        if(this.product.id == 34){


            var productsFiltered = []

            productsFiltered = this.products.filter(product => product.id < 34)

            var timesFiltered = []

            productsFiltered.forEach(product =>{
                product.times.forEach(time =>{
                    if(time.level == this.product.level){
                        timesFiltered.push(time)
                    }
                })
            })

            var sumMinTime = 0
            var sumMaxTime = 0
            timesFiltered.forEach((time)=>{
                sumMinTime = sumMinTime + parseFloat(time.min_time)
                sumMaxTime = sumMaxTime + parseFloat(time.max_time)
            })

            var minTime = [{min_time: sumMinTime, max_time: sumMaxTime}]
            return minTime
            
        }else{
            if(this.product.prices){
            var minTime = this.product.times.filter(time => time.level == this.product.level)
            }
        }    
        return minTime
        
        }
    }
}
</script>
