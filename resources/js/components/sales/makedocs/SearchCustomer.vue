<template>
    <div class="position-relative">
        <input
            type="text"
            v-model="search"
            placeholder="Buscar cliente..."
            class="form-control mt-2"
            @keyup.enter="searchCustomer"
        />
        <ul class="list-found-customers">
            <li
                class="list-group-item bg-white d-flex justify-content-between align-items-center cursor-pointer"
                v-for="customerFound in customersFound"
                @click="addCustomer(customerFound)"
            >
                {{ customerFound.name }} -
                {{ dateFormatted(customerFound.created_at) }}
            </li>
        </ul>
    </div>
</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            customersFound: [],
            search: "",
        };
    },
    methods: {
        searchCustomer() {
            if (this.search != "") {
                this.customersFound = [];
                axios
                    .get(`/api/customers/search/${this.search}`)
                    .then((res) => {
                        this.customersFound = res.data.customers;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.customersFound = [];
            }
        },
        dateFormatted(date) {
            return moment(date).fromNow();
        },
        resetSearch() {
            this.customersFound = [];
        },
        addCustomer(customer) {
            console.log("add customer");
            this.$emit("addCustomer", customer);
            this.customersFound = [];
            this.search = "";
        },
    },
};
</script>
<style scoped>
.list-found-customers {
    width: 100%;
    padding: 0px;
    position: absolute !important;
    z-index: 1000 !important;
    max-height: 250px; /* Establece una altura máxima */
    overflow-y: auto; /* Agrega scroll vertical */
}
</style>
