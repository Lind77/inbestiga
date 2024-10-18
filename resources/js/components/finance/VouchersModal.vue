<template>
    <div class="modal fade" id="vouchersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4
                        class="text-center fw-normal"
                        v-if="contract && contract.projects"
                    >
                        Vouchers de {{ contract.projects[0].title }}
                    </h4>
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Status</th>
                                <th>Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="voucher in contract.external_vouchers">
                                <td>{{ voucher.date }}</td>
                                <td>S./ {{ voucher.amount }}</td>
                                <td>
                                    <p @click="changeStatusVoucher(voucher)">
                                        {{ statusByNumber[voucher.status] }}
                                    </p>
                                </td>
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
        contract: Object,
    },
    methods: {
        showVoucherImage(voucher) {
            var imageUrl = voucher.images[0].url;

            if (imageUrl) {
                window.open(
                    "https://inbestiga.com/inbestiga/public/files/" + imageUrl
                );
            } else {
                this.$swal("Este voucher no contiene imagen");
            }
        },
        changeStatusVoucher(voucher) {
            var newStatus = voucher.status + 1;

            if (Object.keys(this.statusByNumber).length >= newStatus) {
                voucher.status = newStatus;
                this.changeStatusInBd(newStatus, voucher.id);
            } else {
                voucher.status = 1;
                this.changeStatusInBd(1, voucher.id);
            }
        },
        changeStatusInBd(voucherStatus, voucherId) {
            axios
                .get(`/api/status-voucher/${voucherStatus}/${voucherId}`)
                .then((result) => {
                    console.log("gg");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
<style scoped>
/* .glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
} */
</style>
