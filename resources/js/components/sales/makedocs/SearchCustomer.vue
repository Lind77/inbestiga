<template>
    <div class="position-relative">
        <input
            type="text"
            v-model="search"
            placeholder="Buscar usuario..."
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
    max-height: 250px;
    overflow-y: auto;
    background-color: #ffffff !important;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
}

.list-found-customers .list-group-item {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-bottom: 1px solid #f1f5f9;
    padding: 0.75rem 1rem;
    transition: background-color 0.15s ease;
}

.list-found-customers .list-group-item:hover {
    background-color: #f1f5f9 !important;
    color: #4f46e5 !important;
}

/* Dark Mode Overrides */
body.dark-mode .list-found-customers,
[data-bs-theme="dark"] .list-found-customers {
    background-color: #1b1b29 !important;
    border-color: #3a3b54;
}

body.dark-mode .list-found-customers .list-group-item,
[data-bs-theme="dark"] .list-found-customers .list-group-item {
    background-color: #1b1b29 !important;
    color: #ffffff !important;
    border-bottom-color: #2b2c40;
}
</style>
