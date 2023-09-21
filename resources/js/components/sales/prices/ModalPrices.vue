<template>
  <div class="modal fade" id="pricesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Precios de {{ product.name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row" v-for="level in product.levels">
            <div class="col mb-0">
              <label class="form-label" for="emailSmall">Nivel {{ level.name }}</label>
              <input type="number" class="form-control" v-model="level.pivot.price" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="updatePrices">Actualizar</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    product: Object
  },
  methods: {
    updatePrices() {
      const fd = new FormData()
      fd.append('productId', this.product.id)
      fd.append('prices', JSON.stringify(this.product.prices))

      axios.post('/api/updatePrices', fd)
        .then((res) => {
          $('#pricesModal').modal('hide')
        })
        .catch((err) => {

        })
    }
  }
}
</script>