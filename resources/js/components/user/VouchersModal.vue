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
                            <tr v-for="voucher in project.vouchers">
                                <td>{{ voucher.date }}</td>
                                <td>S./ {{ voucher.amount }}</td>
                                <td>{{ statusByNumber[voucher.status] }}</td>
                                <td>
                                    <button
                                        class="btn btn-icon btn-success"
                                        @click="showVoucherImage(voucher)"
                                    >
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
    data() {
        return {
            statusByNumber: {
                1: "Pendiente",
                2: "Aprobado",
                3: "Rechazado",
            },
        };
    },
    props: {
        project: Object,
    },
    methods: {
        showVoucherImage(voucher) {
            var imageUrl = voucher.images[0].url;

            window.open(
                "https://inbestiga.com/inbestiga/public/files/" + imageUrl
            );
        },
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
