<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold mb-0">Vouchers</h4>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Vouchers</th>
                            <th>Monto total</th>
                            <th>Monto cancelado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="voucher in externalVouchers">
                            <td>
                                <p>
                                    {{ voucher.customer.name }}
                                </p>
                            </td>
                            <td>
                                {{ voucher.date }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-icon btn-success"
                                    @click="openVouchersModal(voucher)"
                                >
                                    <i class="bx bx-file"></i>
                                </button>
                            </td>
                            <td v-if="voucher.contract">
                                S./ {{ voucher.contract.amount }}
                            </td>
                            <td v-if="voucher.contract">-</td>
                            <td>
                                <button
                                    class="btn btn-icon btn-success"
                                    title="Aprobar"
                                >
                                    <i class="bx bx-check"></i>
                                </button>
                                <button
                                    class="btn btn-icon btn-danger ms-1"
                                    title="Rechazar"
                                >
                                    <i class="bx bx-x"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <VouchersModal :contract="contractSelected" />
</template>
<script>
import VouchersModal from "./VouchersModal.vue";

export default {
    components: { VouchersModal },
    data() {
        return {
            externalVouchers: [],
            contractSelected: {},
        };
    },
    methods: {
        openVouchersModal(voucher) {
            if (voucher.images[0]) {
                var imageUrl = voucher.images[0].url;
                window.open(
                    "https://inbestiga.com/inbestiga/public/files/" + imageUrl
                );
            } else {
                this.$swal("Este voucher no contiene imagen");
            }
        },
        getExternalVouchers() {
            axios
                .get("/api/quotation-vouchers")
                .then((result) => {
                    this.externalVouchers = result.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getExternalVouchers();
    },
};
</script>
<style scoped></style>
