<template>
    <div class="modal fade" id="qualityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Indicadores de calidad</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-none bg-transparent border border-secondary mb-3">
                            <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">Formato Inicial</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="disabledCheck1">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-none bg-transparent border border-secondary mb-3">
                            <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">Evaluación de la calidad</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="disabledCheck1">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-none bg-transparent border border-secondary mb-3">
                            <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">Formato Final</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="disabledCheck1">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-none bg-transparent border border-secondary mb-3">
                            <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">Listo para entrega</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="disabledCheck1">
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-xl">Finalizar proyecto</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
export default {
    
}
</script>
