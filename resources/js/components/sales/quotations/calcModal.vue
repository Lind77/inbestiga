<template>
    <div class="modal fade" id="calcModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Calcular Monto de Parafraseo</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-0">
                <label class="form-label" for="emailSmall">Total de Pags</label>
                <input type="number" class="form-control" v-model="pages"/>
              </div>
              <div class="col mb-0">
                <label for="dobSmall" class="form-label">Porcentaje Actual</label>
                <input type="number" class="form-control" v-model="actualPercent"/>
              </div>
              <div class="col mb-0">
                <label for="dobSmall" class="form-label">Porcentaje Deseado</label>
                <input type="number" class="form-control" v-model="desiredPercent"/>
              </div>
            </div>
            <div class="row g-2 mt-2">
              <button class="btn btn-primary btn-sm" @click="calcCost">Calcular</button>
              Costo de Parafraseo: S./ {{ cost }}
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="saveCost">Añadir</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            pages: 0,
            actualPercent: 0,
            desiredPercent:0,
            cost:0
        }
    },
    methods:{
        calcCost(){
            var totalPages = 0
            totalPages = (this.pages*this.actualPercent)/100 - (this.pages*this.desiredPercent)/100
            this.cost = (totalPages+2)*23
        },
        saveCost(){
            this.$emit('addCartParaphrase', this.cost)
            $('#calcModal').modal('hide')
        }
    }
}
</script>
