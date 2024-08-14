<template>
    <table>
        <thead>
            <tr>
                <th>Cuentas</th>
                <th>Fecha</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="payment in project.payments">
                <td>S./ {{ payment.amount }}</td>
                <td>{{ payment.date }}</td>
                <td>{{ payment.status }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bordered">
                <td>S./ {{ totalAmount }}</td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end">
        <button class="btn btn-gradient" @click="showModalVouchers">
            Ver vouchers
        </button>
        <button class="btn btn-gradient ms-2">Subir voucher</button>
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
    },
    data() {
        return {
            projectSelected: {},
        };
    },
    methods: {
        showModalVouchers() {
            console.log(this.project);
            this.$emit("showModalVouchers", this.project);
        },
    },
    computed: {
        totalAmount() {
            return this.project.payments.reduce(
                (acc, payment) => acc + payment.amount,
                0
            );
        },
    },
};
</script>
<style scoped>
table {
    border-collapse: collapse; /* Colapsa los bordes */
    width: 100%; /* Ancho de la tabla */
}
th,
td {
    /* Bordes para celdas */
    padding: 10px; /* Espaciado interno */
    text-align: left; /* Alineación del texto */
}
tfoot {
    border-top: 2px solid #fff; /* Borde superior en el tfoot */
}
tr {
    padding: 20px 0px;
}

th {
    color: #fff;
    text-align: center;
}
td {
    color: #fff;
    text-align: center;
}
.btn-gradient {
    background: linear-gradient(
        22deg,
        rgba(251, 21, 215, 1) 0%,
        rgba(127, 33, 251, 1) 73%
    );
    border: none;
    color: #fff;
}

tr.bordered {
    border-top: 1px solid #fff;
}
</style>
