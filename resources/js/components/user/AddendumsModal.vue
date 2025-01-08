<template>
    <div
        class="modal fade"
        id="adendumsUserModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel1">
                        Adendas
                    </h5>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-white">Fecha</td>
                                <td class="text-white">Estado</td>
                                <td class="text-white">Opciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="addendum in addendums">
                                <td class="text-white">{{ addendum.date }}</td>
                                <td class="text-white">
                                    {{ addendum.status }}
                                </td>
                                <td>
                                    <button class="btn btn-info btn-icon">
                                        <i class="bx bx-file"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        addendums: Array,
    },
};
</script>
<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}
</style>
