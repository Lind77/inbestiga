<template>
    <div class="card invoice-preview-card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div
                        class="d-flex align-items-center justify-content-between"
                    >
                        <h5 class="card-title text-info fw-bold mb-0">
                            Generar Contrato
                        </h5>
                        <button
                            @click="addNewCustomer"
                            class="btn btn-info btn-icon"
                        >
                            <i class="bx bx-user-plus"></i>
                        </button>
                    </div>
                    <div class="w-100">
                        <SearchCustomer @addCustomer="addCustomer" />
                    </div>
                    <label class="form-label mb-0 mt-4">Clientes</label>
                    <div class="list-group" role="tablist">
                        <a
                            class="list-group-item list-group-item-action"
                            id="list-home-list"
                            data-bs-toggle="list"
                            href="#list-home"
                            aria-selected="false"
                            role="tab"
                            tabindex="-1"
                            @click="pickCustomer(customer)"
                            v-for="customer in customers"
                            >{{ customer.name }}</a
                        >
                    </div>
                </div>
                <div class="col-8">
                    <Customer
                        :customer="customer"
                        @deleteCustomer="deleteCustomer"
                        @getCustomer="getCustomer"
                        @openModalCustomerEdit="openModalCustomerEdit"
                    />
                </div>
            </div>
            <div class="row">
                <div
                    v-if="documentType == 1"
                    class="bg-success rounded text-white text-center my-1 p-1"
                    @click="pickQuotation(quotation)"
                    v-for="quotation in quotationsExistent"
                >
                    {{ formatTime(quotation.created_at) }}
                    <i
                        class="bx bx-trash"
                        @click="deleteQuotaion(quotation.id)"
                    ></i>
                </div>
                <button
                    v-if="documentType == 2"
                    class="btn btn-info m-1"
                    @click="pickOrder(order)"
                    v-for="order in ordersExistent"
                >
                    {{ formatTime(order.created_at) }}
                </button>
                <button
                    v-if="documentType == 3"
                    class="btn btn-info m-1"
                    @click="pickContract(contract)"
                    v-for="contract in contractExistent"
                >
                    {{ contract.date }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import SearchCustomer from "./SearchCustomer.vue";
import Customer from "./Customer.vue";
import moment from "moment";

export default {
    components: { Customer, SearchCustomer },
    props: {
        customers: Array,
        quotationId: Number,
    },
    data() {
        return {
            customer: {
                id: 0,
            },
            customersFound: [],
        };
    },
    methods: {
        resetSearch() {
            this.customersFound = [];
        },
        pickCustomer(customer) {
            this.customer = customer;
        },
        dateFormatted(date) {
            return moment(date).fromNow();
        },
        addCustomer(customer) {
            axios
                .get(
                    `/api/quotation-customer/${customer.id}/${this.quotationId}`
                )
                .then((result) => {
                    this.customers.push(customer);
                })
                .catch((err) => {
                    alert("Hubo un error");
                });
        },
        deleteCustomer(customerId) {
            axios
                .delete(
                    `/api/quotation-customer/${customerId}/${this.quotationId}`
                )
                .then((result) => {
                    this.$emit("deleteCustomer", customerId);
                    this.customer = {
                        id: 0,
                    };
                })
                .catch((err) => {
                    alert("Hubo un error");
                });
        },
        openModalCustomerEdit(customer) {
            this.$emit("openModalCustomerEdit", customer);
        },
    },
};
</script>
