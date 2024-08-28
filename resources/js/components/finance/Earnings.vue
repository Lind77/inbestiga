<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <h4 class="fw-bold py-3 mb-4">Ingresos</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Vouchers</th>
                        <th>Monto total</th>
                        <th>Monto cancelado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="voucher in externalVouchers">
                        <td v-if="voucher">
                            <p v-for="customer in voucher.customers">
                                {{ customer.name }}
                            </p>
                        </td>
                        <td>
                            <button
                                class="btn btn-icon btn-success"
                                @click="openVouchersModal(voucher.contract)"
                            >
                                <i class="bx bx-file"></i>
                            </button>
                        </td>
                        <td v-if="voucher.contract">
                            S./ {{ voucher.contract.amount }}
                        </td>
                        <td v-if="voucher.contract">
                            S./ {{ voucher.contract.amount }}
                        </td>
                    </tr>
                </tbody>
            </table>
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
        openVouchersModal(contract) {
            this.contractSelected = contract;
            $("#vouchersModal").modal("show");
        },
        getExternalVouchers() {
            axios
                .get("/api/quotation-vouchers")
                .then((result) => {
                    this.externalVouchers = result.data.data;
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
