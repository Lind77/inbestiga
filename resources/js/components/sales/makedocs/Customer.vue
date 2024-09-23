<template>
    <div class="card shadow-none bg-label-info mb-3" v-if="customer.id">
        <div class="card-body">
            <h5 class="card-title text-info">
                Cliente: {{ customer.name }}
                <i @click="deleteCustomer(customer.id)" class="bx bx-x"></i>
                <i @click="showEditCustomer(customer)" class="bx bx-edit"></i>
            </h5>
            <p class="card-text mb-0">Teléfono: {{ customer.cell }}</p>
            <p class="card-text mb-0">Carrera: {{ customer.career }}</p>
            <p class="card-text mb-0">Universidad: {{ customer.university }}</p>
            <p class="card-text mb-0">DNI: {{ customer.dni }}</p>
            <p class="card-text mb-0">Dirección: {{ customer.address }}</p>
        </div>
    </div>
</template>
<script>
import customerModal from "../customers/customerModal.vue";

export default {
    components: { customerModal },
    data() {
        return {
            dni: "",
            address: "",
            customer_selected: {},
        };
    },
    props: {
        customer: Object,
    },
    methods: {
        showEditCustomer(customer) {
            this.$emit("openModalCustomerEdit", customer);
        },
        deleteCustomer(customerId) {
            this.$emit("deleteCustomer", customerId);
        },
        saveDni() {
            const fd = new FormData();
            fd.append("id_customer", this.customer.id);
            fd.append("dni", this.dni);
            fd.append("address", this.address);
            axios
                .post("/api/updateDniCustomer", fd)
                .then((res) => {
                    this.$emit("getCustomer");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
