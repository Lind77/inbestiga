<template>
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-2">{{ title }} ({{ numberLeads }})</h4>

        <div class="card p-2">
            <div class="row">
                <div class="col-2">
                    <ul class="email-filter-folders list-unstyled pb-1 pt-2">
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center"
                                @click="filterCustomers(1)">
                                <i class="bx bx-user"></i>
                                <span class="align-middle ms-2">Leads</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">{{ numbersFullLeads }}</div>
                        </li>
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center"
                                @click="filterCustomers(2)">
                                <i class="bx bx-user"></i>
                                <span class="align-middle ms-2">Mis Leads</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">{{ myLeads.length }}</div>
                        </li>
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center"
                                @click="filterCustomers(3)">
                                <i class="bx bx-user"></i>
                                <span class="align-middle ms-2">Contrato</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">{{ contracts.length }}</div>
                        </li>
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap  align-items-center"
                                @click="filterCustomers(4)">
                                <i class="bx bx-user"></i>
                                <span class="align-middle ms-2">Stand By</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">{{ standBy.length }}</div>
                        </li>
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center"
                                @click="filterCustomers(5)">
                                <i class="bx bx-user"></i>
                                <span class="align-middle ms-2">De Hoy</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">{{ todayLeads.length }}</div>
                        </li>
                        <!-- <li class="d-flex py-1" data-target="sent">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="bx bx-send"></i>
                                <span class="align-middle ms-2">Pre-leads</span>
                            </a>
                        </li>
                        <li class="d-flex py-1" data-target="sent">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="bx bx-send"></i>
                                <span class="align-middle ms-2">Leads</span>
                            </a>
                        </li>
                        <li class="d-flex py-1 justify-content-between" data-target="draft">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="bx bx-edit"></i>
                                <span class="align-middle ms-2">Stand By</span>
                            </a>
                            <div class="badge bg-label-warning rounded-pill">1</div>
                        </li> -->
                    </ul>
                </div>
                <div class="col-10">
                    <div class="card-header pb-1 pt-2">
                        <div class="mb-0 mb-lg-2 w-100">
                            <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text border-0 ps-0 py-0" id="email-search">
                                    <i class="bx bx-search fs-4 text-muted"></i>
                                </span>
                                <input type="text" class="form-control email-search-input border-0 py-0"
                                    placeholder="Buscar lead..." aria-label="Search..." aria-describedby="email-search">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                        </div>
                        <div
                            class="email-pagination d-sm-flex d-none align-items-center flex-wrap justify-content-between justify-sm-content-end">
                            <span class="d-sm-block d-none mx-3 text-muted">{{ startPage + 1 }}-{{
                                Math.floor(numberLeads / pageSize) }} de {{ numberLeads }}</span>
                            <i :class="`email-prev bx bx-chevron-left scaleX-n1-rtl cursor-pointer  me-4 fs-4 ${startPage == 0 ? 'text-muted' : ''}`"
                                @click="prevPag"></i>
                            <i class="email-next bx bx-chevron-right scaleX-n1-rtl cursor-pointer fs-4"
                                @click="nextPag"></i>
                        </div>
                    </div>
                    <div class="email-list pt-0 ps ps--active-y">
                        <ul class="list-unstyled m-0">
                            <li class="email-list-item email-marked-read d-block py-3" data-starred="true"
                                data-bs-toggle="sidebar" data-target="#app-email-view" v-for="lead in showLeads">
                                <div class="d-flex align-items-center">
                                    <div class="email-list-item-content ps-3 ms-2 ms-sm-0 me-2">
                                        <span class="email-list-item-username me-2 h6">{{ lead.name }}</span>
                                        <span class="email-list-item-subject d-xl-inline-block d-block"> - {{ lead.cell
                                        }}</span>
                                    </div>
                                    <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                        <span
                                            class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
                                            data-label="private"></span>
                                        <small class="email-list-item-time text-muted">{{ formatDate(lead.created_at)
                                        }}</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-unstyled m-0">
                            <li class="email-list-empty text-center d-none">No items found.</li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>

        <!-- <div class="row mb-3">
            <h6>Recientes</h6>
            <div class="col-md-4" v-for="lead in todayLeads">
                <div class="card bg-danger my-3">
                    <div class="card-header text-white">{{ lead.name || lead.cell }}</div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-md-4" v-for="lead in myLeads">
                <div class="card bg-success my-3">
                    <div class="card-header text-white">{{ lead.name || lead.cell }}</div>
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
import moment from 'moment'
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    data() {
        return {
            totalLeads: [],
            myLeads: [],
            todayLeads: [],
            clients: [],
            pageSize: 10,
            standBy: [],
            startPage: 0,
            title: '',
            numberLeads: 0,
            numbersFullLeads: 0,
            customers: [],
            leads: [],
            contracts: [],
            showLeads: []
        }
    },
    methods: {
        filterCustomers(i) {
            this.startPage = 0
            var arraysTitles = {
                1: 'Leads',
                2: 'Mis Leads',
                3: 'Contrato',
                4: 'Stand By',
                5: 'De Hoy'
            }

            this.title = arraysTitles[i]

            var arraysLeads = {
                1: this.leads,
                2: this.myLeads,
                3: this.contracts,
                4: this.standBy,
                5: this.todayLeads
            }
            this.totalLeads = arraysLeads[i]

            i != 1 ? this.numberLeads = arraysLeads[i].length : this.numberLeads = this.numbersFullLeads

            this.showLeads = arraysLeads[i].slice(0, 10)
        },
        nextPag() {
            this.startPage++
            this.showLeads = this.totalLeads.slice(this.startPage * this.pageSize, (this.startPage + 1) * this.pageSize)
        },
        prevPag() {
            if (this.startPage > 1 && this.startPage != 0) {
                console.log(this.startPage)
                this.showLeads = this.totalLeads.slice((this.startPage - 1) * this.pageSize, this.startPage * this.pageSize)
                this.startPage--

            } else if (this.startPage == 1) {
                this.startPage--
                this.showLeads = this.totalLeads.slice(0, 10)
            }
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        filterToday() {
            this.myLeads = this.todayLeads
            this.title = 'Leads de hoy'
        },
        filterStandBy() {
            this.totalLeads = this.standBy
            this.myLeads = this.standBy.slice(0, 10)
            this.title = 'Stand By'
        },
        getAllMyLeads() {
            this.title = 'Mis Leads'
            axios.get('/api/my-leads/' + this.store.authUser.id)
                .then((res) => {
                    this.leads = res.data.customers
                    this.numbersFullLeads = res.data.countLeads
                    this.myLeads = res.data.customers
                    this.contracts = res.data.clients
                    this.standBy = res.data.standBy
                    this.todayLeads = res.data.customersToday
                    this.filterCustomers(1)
                })
                .catch((err) => {
                    console.error(err)
                })
        }
    },
    mounted() {
        this.getAllMyLeads()
    }
}
</script>
<style lang="">
    
</style>