<template>
    <div class="w-100 mt-2">
        <div class="card">
            <div class="card-header">
                <span class="h5 mt-2 demo text-body fw-bold">Clientes </span>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center overflow-auto">
                    <span
                        v-for="customer in quotation.customers"
                        @click="selectCustomer(customer)"
                        class="badge bg-primary me-1 cursor-pointer"
                        :title="customer.name"
                        >{{ customer.name.substring(0, 15) + "..." }}</span
                    >
                </div>
                <div
                    class="card bg-primary p-2 mb-2 mt-2"
                    v-if="customerSelected"
                >
                    <div
                        class="card-header d-flex align-items-center justify-content-between"
                    >
                        <h5
                            class="card-title m-0 me-2 text-white"
                            :title="customerSelected.name"
                        >
                            {{
                                customerSelected.name
                                    ? customerSelected.name.substring(0, 25) +
                                      "..."
                                    : ""
                            }}
                        </h5>
                        <i
                            class="bx bx-edit text-white cursor-pointer"
                            @click="updateCustomer(customerSelected)"
                        ></i>
                        <!-- <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="employeeList"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            ></button>
                            <div
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="employeeList"
                                style=""
                            >
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0);"
                                    
                                    >Editar</a
                                >
                            </div>
                        </div> -->
                    </div>

                    <div class="card-body">
                        <ul
                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2 text-white"
                        >
                            <li class="list-inline-item fw-medium">
                                <i class="bx bx-id-card"></i>
                                {{ customerSelected.dni }}
                            </li>
                            <li class="list-inline-item fw-medium">
                                <i class="bx bx-pen"></i>
                                {{ customerSelected.career }}
                            </li>
                            <li class="list-inline-item fw-medium">
                                <i class="bx bxs-graduation"></i>
                                {{ customerSelected.university }}
                            </li>
                            <li class="list-inline-item fw-medium">
                                <i class="bx bx-phone"></i>
                                {{ customerSelected.cell }}
                            </li>
                            <!--  <li class="list-inline-item fw-medium">
                                <i class="bx bx-street-view"></i>
                                Actitud:
                                {{
                                    customerSelected.attitude
                                        ? customerSelected.attitude
                                        : "-"
                                }}
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            customerSelected: null,
        };
    },
    props: {
        quotation: Object,
    },
    methods: {
        updateCustomer(customer) {
            this.$emit("updateCustomer", customer);
        },
        selectCustomer(customer) {
            this.customerSelected = customer;
        },
    },
    watch: {
        quotation(val) {
            console.log(this.quotation);
            this.customerSelected = this.quotation.customers[0];
        },
    },
};
</script>
<style scoped>
/* width */
::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: rgba(67, 89, 113, 0.075);
    border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: rgba(67, 89, 113, 0.7);
}
</style>
