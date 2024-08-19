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
        <input
            type="file"
            id="uploadVoucherInput"
            accept="image/x-png,image/gif,image/jpeg"
            hidden
            @change="postVoucher"
        />
        <button class="btn btn-gradient ms-2" @click="uploadVoucher">
            Subir voucher
        </button>
    </div>
</template>
<script>
import { userStore } from "../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    props: {
        project: Object,
        userId: Number,
    },
    data() {
        return {
            projectSelected: {},
            filePostUploaded: {},
        };
    },
    methods: {
        uploadVoucher() {
            $("#uploadVoucherInput").click();
        },
        showModalVouchers() {
            console.log(this.project);
            this.$emit("showModalVouchers", this.project);
        },
        postVoucher(event) {
            var file = event.target.files[0];
            this.filePostUploaded = file;

            var reader = new FileReader();
            reader.onload = async (event) => {
                this.storeVoucher();
            };
            reader.readAsText(file);
        },
        storeVoucher() {
            const fd = new FormData();

            fd.append("customerId", this.userId);
            fd.append("contractId", this.project.contract.id);
            fd.append("file", this.filePostUploaded);

            axios
                .post("/api/external-voucher", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((result) => {
                    this.$swal("Voucher subido correctamente");
                    this.$emit("getProjectInfo");
                })
                .catch((err) => {
                    console.log(err);
                });
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
