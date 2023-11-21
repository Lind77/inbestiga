<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Perfiles de Proyectos</h4>
        <div class="row mb-2">
            <input type="text" placeholder="Buscar por cliente..." class="form-control w-50 ms-2" v-model="searchProfile"
                @keyup.enter="filterProfiles">
        </div>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3" v-for="quotation in quotationsFiltered">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="max-width: 500px" :title="quotation.customers[0].university">{{
                                    quotation.customers[0].university.length > 15 ?
                                    quotation.customers[0].university.substring(0, 15) + '...' :
                                    quotation.customers[0].university }}</span>
                                <div class="d-flex align-items-end mt-2" v-for="customer in quotation.customers">
                                    <p class="mb-0 me-2 fw-bold" :title="customer.name">{{
                                        customer.name.length > 15 ? customer.name.substring(0, 15) + '...' : customer.name
                                    }}
                                    </p>
                                </div>
                                <small :title="quotation.customers[0].career">{{ quotation.customers[0].career.length > 20 ?
                                    quotation.customers[0].career.substring(0,
                                        20) + '...' :
                                    quotation.customers[0].career }}</small>
                            </div>
                            <div class="d-flex flex-column">
                                <button @click="showCustomerModal(quotation.id)" class="btn btn-info btn-sm ms-2">
                                    <i class="bx bx-user bx-sm"></i>
                                </button>
                                <button @click="showComunicationsModal(quotation.customers[0])"
                                    class="btn btn-warning btn-sm ms-2 mt-1">
                                    <i class="bx bx-chat bx-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <CustomerprofileModal :customer="customer_selected" @getAllCustomers="getAllCustomers" />
    <ComunicationsModal :comunications="comunicationsSelected" @showComunicationUpdate="showComunicationUpdate" />
    <UpdateComunicationModal :customer="customer_selected" @showComunicationUpdate="showComunicationUpdate"
        @getAllCustomers="getAllCustomers" />
</template>
<script>
import CustomerprofileModal from './CustomerprofileModal.vue'
import ComunicationsModal from './ComunicationsModal.vue'
import UpdateComunicationModal from './UpdateComunicationModal.vue'

export default {
    components: {
        CustomerprofileModal,
        ComunicationsModal,
        UpdateComunicationModal
    },
    data() {
        return {
            customerId: 0,
            action: 1,
            customers: [],
            customer_selected: {},
            comunicationsSelected: [],
            searchProfile: '',
            quotationsFiltered: []
        }
    },
    methods: {
        filterProfiles() {
            console.log(this.searchProfile);
            axios.get('/api/profiles-search/' + this.searchProfile)
                .then((result) => {
                    this.quotationsFiltered = result.data
                }).catch((err) => {
                    console.error(err);
                });
            /*  if (this.searchProfile == '') {
                 this.quotationsFiltered = this.customers
             } else {
                 this.quotationsFiltered = this.customers.filter(customer => customer.name.toLowerCase().includes(this.searchProfile))
             } */
        },
        showComunicationUpdate(customerId) {
            var customerSelected = this.customers.find(customer => customer.id == customerId)

            this.customer_selected = customerSelected

            $('#updateComModal').modal('show')
        },
        showComunicationsModal(customer) {
            this.comunicationsSelected = customer.comunications
            $('#ComunicationsModal').modal('show')
        },
        showCustomerModal(quotationId) {
            this.$router.push({ name: 'home-documentation', params: { quotationId: quotationId } })
        },
        getAllCustomers() {
            axios.get('/api/profiles')
                .then((result) => {
                    this.customers = result.data
                    this.quotationsFiltered = result.data
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