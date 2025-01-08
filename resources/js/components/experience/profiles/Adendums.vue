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
                    <tr v-for="addendum in addendums">
                        <td>{{ addendum.date }}</td>
                        <td>{{ addendum.user_id }}</td>
                        <td>{{ addendum.status }}</td>
                        <td>
                            <button class="btn btn-info btn-icon">
                                <i class="bx bx-file"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        addendums: Array,
    },
    methods: {
        openAdendumsModal() {
            this.$emit("openAdendumsModal");
        },
    },
};
</script>
<style lang=""></style>
