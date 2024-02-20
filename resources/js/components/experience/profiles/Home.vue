<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Perfiles de Proyectos</h4>
        <div class="row mb-2">
            <div class="col-6">
                <input type="text" placeholder="Buscar por cliente..." class="form-control ms-2" v-model="searchProfile"
                    @keyup.enter="filterProfiles">
            </div>

            <div class="col-6">
                <button class="btn btn-success w-25" @click="getAllCustomers">Contratos</button>
                <button class="btn btn-primary w-25 ms-2" @click="getOrders">Órdenes</button>
            </div>

        </div>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3" v-for="quotation in quotationsFiltered">
                <div :class="`card cursor-pointer bg-${bgCards} text-white`" @click="showCustomerModal(quotation.id)">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <div class="d-flex justify-content-between">
                                    <span class="max-width: 500px" :title="quotation.customers[0].university">{{
                                        quotation.customers[0].university.length > 15 ?
                                        quotation.customers[0].university.substring(0, 16) + '...' :
                                        quotation.customers[0].university }}</span>
                                </div>

                                <div class="d-flex align-items-center avatar-group my-3">
                                    <div class="avatar avatar-sm me-2" v-for="customer in quotation.customers"
                                        :title="customer.name">
                                        <span class="avatar-initial rounded-circle bg-primary">{{ customer.name[0] }}</span>
                                    </div>
                                </div>

                                <!-- <div class="avatar">
                                        <span class="avatar-initial rounded-circle pull-up bg-secondary"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-original-title="3 more">+3</span>
                                    </div> -->
                                <!-- <div class="d-flex align-items-end mt-2" v-for="customer in quotation.customers">
                                    <p class="mb-0 me-2 fw-bold" :title="customer.name">{{
                                        customer.name.length > 15 ? customer.name.substring(0, 15) + '...' : customer.name
                                    }}
                                    </p>
                                </div> -->
                                <small :title="quotation.customers[0].career">{{ quotation.customers[0].career.length > 20 ?
                                    quotation.customers[0].career.substring(0,
                                        20) + '...' :
                                    quotation.customers[0].career }}</small>
                            </div>
                            <div class="d-flex flex-column">
                                <i class="bx bx-info-circle text-danger"
                                    v-if="quotation.contract && quotation.contract.properties == null"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-icon" @click="prevPage" v-if="prevPageUrl != null"><i
                    class='bx bx-chevron-left'></i></button>
            <button class="btn btn-primary btn-icon" v-if="nextPageUrl != null" @click="nextPage"><i
                    class='bx bx-chevron-right'></i></button>
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
import { showLoader } from '../../../utils/Loader'
import { closeLoader } from '../../../utils/CloseLoader'

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
            quotationsFiltered: [],
            bgCards: '',
            nextPageUrl: '',
            prevPageUrl: ''
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
            showLoader()
            axios.get('/api/profiles')
                .then((result) => {
                    //this.customers = result.data
                    this.quotationsFiltered = result.data.data
                    this.nextPageUrl = result.data.next_page_url
                    this.prevPageUrl = result.data.prev_page_url
                    this.bgCards = 'success'
                    closeLoader()
                }).catch((err) => {
                    console.log(err);
                });
        },
        nextPage() {
            axios.get(this.nextPageUrl)
                .then((result) => {
                    this.nextPageUrl = result.data.next_page_url
                    this.prevPageUrl = result.data.prev_page_url
                    this.quotationsFiltered = result.data.data
                }).catch((err) => {
                    console.log(err);
                });
        },
        prevPage() {
            axios.get(this.prevPageUrl)
                .then((result) => {
                    this.nextPageUrl = result.data.next_page_url
                    this.prevPageUrl = result.data.prev_page_url
                    this.quotationsFiltered = result.data.data
                }).catch((err) => {
                    console.log(err);
                });
        },
        getOrders() {
            showLoader()
            axios.get('/api/orders')
                .then((result) => {
                    console.log(result.data)
                    this.quotationsFiltered = result.data.data
                    this.nextPageUrl = result.data.next_page_url
                    this.prevPageUrl = result.data.prev_page_url
                    this.bgCards = 'primary'
                    //this.customers = result.data
                    /* this.quotationsFiltered = result.data.filter(quotation => quotation.order !== null) */
                    closeLoader()
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