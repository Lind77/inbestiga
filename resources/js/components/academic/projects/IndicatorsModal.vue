<template>
    <div class="modal fade" id="indicatorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Indicadores de calidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-for="indicator in indicators">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 pe-3"> {{ indicator.name }}</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Observaciones</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </template>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Salir
                    </button>
                    <button type="button" class="btn btn-primary" @click="assignTeam">Asignar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        indicators: Object
    }
}
</script>
<style lang="">

</style>