<template>
    <div class="modal fade" id="adendumsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Generar Adenda
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="object">Objeto de Adenda</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="adendum.object"
                            id="object"
                        />
                    </div>
                    <div class="d-flex flex-column py-1">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="h5 mt-2 demo text-body fw-bold"
                                    >Pagos({{ newPayments.length }})</span
                                >
                                <button
                                    type="button"
                                    class="btn btn-primary btn-icon ms-2"
                                    @click="minusPayment"
                                >
                                    <i class="bx bx-minus"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary btn-icon ms-2"
                                    @click="addPayment"
                                >
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>

                            <button
                                type="button"
                                class="btn btn-primary btn-sm ms-2"
                                @click="calcPayments"
                            >
                                Calcular
                            </button>
                        </div>

                        <div class="row w-100">
                            <table class="table" v-if="newPayments.length">
                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Monto</td>
                                        <td>Porcentaje</td>
                                        <td>Opciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(payment, index) in newPayments"
                                    >
                                        <Payment
                                            :payment="payment"
                                            :index="index"
                                            @deletePayment="deletePayment"
                                            :finalPrice="finalPrice"
                                        />
                                    </template>
                                </tbody>
                            </table>
                            <p class="h5">Monto final: S./{{ finalPrice }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <span class="h5 mt-2 demo text-body fw-bold"
                                    >Entregas</span
                                >
                                <button
                                    type="button"
                                    class="btn btn-primary btn-icon ms-2"
                                    @click="addDelivery"
                                >
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row w-100">
                            <table class="table" v-if="deliveries.length">
                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Avance</td>
                                        <td>Opciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(delivery, index) in deliveries"
                                    >
                                        <Delivery
                                            :delivery="delivery"
                                            :index="index"
                                            @deleteDelivery="deleteDelivery"
                                        />
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="object">Clausula extra</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="adendum.clausule"
                            id="object"
                        />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-full" @click="saveAdendum">
                        Agregar Adendas
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Payment from "../../sales/makedocs/Payment.vue";
import Delivery from "../../sales/makedocs/Delivery.vue";
import { userStore } from "../../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    data() {
        return {
            adendum: {
                object: "",
                clausule: "",
            },
            cantPayments: 0,
            newPayments: [],
            finalPrice: 0.0,
            deliveries: [],
            amount: 0,
        };
    },
    props: {
        contract: Object,
        payments: Array,
        project_id: Number,
    },
    components: { Payment, Delivery },
    methods: {
        saveAdendum() {
            const fd = new FormData();

            fd.append("contract_id", this.contract.id);
            fd.append("project_id", this.project_id);
            fd.append("object", this.adendum.object);
            fd.append("clausule", this.adendum.clausule);
            fd.append("amount", this.finalPrice);
            fd.append("deliveries", JSON.stringify(this.deliveries));
            fd.append("payments", JSON.stringify(this.newPayments));
            fd.append("user_id", this.store.authUser.id);

            axios
                .post("/api/addendums", fd)
                .then((result) => {
                    this.$emit("getQuotation");
                    $("#adendumsModal").modal("hide");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        minusPayment() {
            if (this.finalPrice == 0.0) {
                this.$swal("Aun no hay un precio final, añadir detalles");
            } else {
                if (this.cantPayments > 0) {
                    this.cantPayments--;
                }
            }
        },
        addPayment() {
            this.cantPayments++;
        },
        deletePayment(index) {
            this.payments.splice(index, 1);
        },
        calcPayments() {
            if (this.finalPrice == 0.0) {
                this.$swal("Aun no hay un precio final, añadir detalles");
            } else {
                this.newPayments = [];
                for (var i = 0; i < this.cantPayments; i++) {
                    var payment = {
                        date: null,
                        amount: (this.finalPrice / this.cantPayments).toFixed(
                            1
                        ),
                        percentage: (100 / this.cantPayments).toFixed(1),
                    };

                    this.newPayments.push({ ...payment });
                }
            }
        },
        addDelivery() {
            var delivery = {
                date: null,
                advance: "",
            };
            this.deliveries.push({ ...delivery });
        },
        deleteDelivery(index) {
            this.deliveries.splice(index, 1);
        },
    },
    watch: {
        payments(value) {
            this.newPayments = value;
        },
        contract(value) {
            this.finalPrice = value.amount;
        },
    },
    computed: {
        finalPrice() {
            return this.newPayments.reduce(
                (acc, payment) => acc + parseFloat(payment.amount),
                0
            );
        },
    },
};
</script>
<style lang=""></style>
