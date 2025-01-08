<template>
    <div class="card my-1">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span class="h5 my-2 demo text-body fw-bold">Adendas </span>
                <button
                    class="btn btn-sm btn-success text-white"
                    @click="openAdendumsModal"
                >
                    Agregar Adenda
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <td>Fecha</td>
                        <td>Generador Por</td>
                        <td>Estado</td>
                        <td>Opciones</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        openAdendumsModal() {
            this.$emit("openAdendumsModal");
        },
    },
};
</script>
<style lang=""></style>
