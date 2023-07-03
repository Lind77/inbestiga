<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEvent" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header" v-if="info.event">
            <h3 id="offcanvasEndLabel" class="offcanvas-title">Evento {{ info.event.title }}</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
            <p class="text-primary h5"> (Equipo)</p>
            <h5 @dblclick="pickDeadline" class="text-danger cursor-pointer">Fecha de Culminación:</h5>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        info: Object
    }
}
</script>
<style lang="">
    
</style>