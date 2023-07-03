<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Perfiles de Clientes</h4>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3" v-for="customer in customers">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="max-width: 500px" :title="customer.university">{{
                                    customer.university.length > 15 ? customer.university.substring(0, 15) + '...' :
                                    customer.university }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" :title="customer.name">{{
                                        customer.name.length > 15 ? customer.name.substring(0, 15) + '...' : customer.name }}
                                    </h4>
                                    <!-- <small class="text-success">(+29%)</small> -->
                                </div>
                                <small :title="customer.career">{{ customer.career.length > 20 ? customer.career.substring(0,
                                    20) + '...' :
                                    customer.career }}</small>
                            </div>
                            <button @click="showCustomerModal(customer)" class="btn btn-info btn-sm ms-2">
                                <i class="bx bx-user bx-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <CustomerprofileModal :customer="customer_selected"/>
    </div>
</template>
<script>
import CustomerprofileModal from './CustomerprofileModal.vue'
export default {
    components:{
        CustomerprofileModal
    },
    data() {
        return {
            customerId: 0,
            action: 1,
            customers: [],
            customer_selected: {},
        }
    },
    methods: {
        showCustomerModal(customer) {
        this.customer_selected = customer
        $('#CustomerprofileModal').modal('show')
        },
        getAllCustomers() {
            axios.get('/api/profiles')
                .then((result) => {
                    this.customers = result.data
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
    computed: {

    },
    mounted() {
        this.getAllCustomers()
    }
}
</script>