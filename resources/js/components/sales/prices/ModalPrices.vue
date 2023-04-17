<template>
    <div class="modal fade" id="pricesModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Precios</h5>
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
                <input type="number" class="form-control"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Añadir</button>
          </div>
        </div>
      </div>
    </div>
</template>