<template>
    <div class="modal fade" id="vouchersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-body">
                    <h4 class="text-white text-center fw-normal">
                        Vouchers de {{ project.title }}
                    </h4>
                    <table class="text-white w-100">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Status</th>
                                <th>Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payment in project.payment_proofs">
                                <td>{{ payment.date }}</td>
                                <td>S./ {{ payment.total_price }}</td>
                                <td>{{ payment.type }}</td>
                                <td>
                                    <button class="btn btn-icon btn-success">
                                        <i class="bx bx-file"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
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
