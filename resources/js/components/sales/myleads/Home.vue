<template>
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-2">Mis Leads ({{ myLeads.length }})</h4>

        <div class="card p-2">
            <div class="row">
                <div class="col-2">
                    <button class="btn btn-primary w-100">Agregar</button>

                    <ul class="email-filter-folders list-unstyled pb-1 pt-2">
                        <li class="d-flex py-1 justify-content-between active" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="bx bx-envelope"></i>
                                <span class="align-middle ms-2">Nuevos</span>
                            </a>
                            <div class="badge bg-label-primary rounded-pill">21</div>
                        </li>
                        <li class="d-flex py-1" data-target="sent">
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
                        </li>
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
                            <span class="d-sm-block d-none mx-3 text-muted">1-10 of 653</span>
                            <i class="email-prev bx bx-chevron-left scaleX-n1-rtl cursor-pointer text-muted me-4 fs-4"></i>
                            <i class="email-next bx bx-chevron-right scaleX-n1-rtl cursor-pointer fs-4"></i>
                        </div>
                    </div>
                    <div class="email-list pt-0 ps ps--active-y">
                        <ul class="list-unstyled m-0">
                            <li class="email-list-item email-marked-read d-block py-3" data-starred="true"
                                data-bs-toggle="sidebar" data-target="#app-email-view" v-for="lead in myLeads">
                                <div class="d-flex align-items-center">

                                    <i
                                        class="email-list-item-bookmark bx bx-star d-sm-inline-block d-none cursor-pointer mx-4 bx-sm"></i>
                                    <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                        <span class="email-list-item-username me-2 h6">{{ lead.name }}</span>
                                        <span class="email-list-item-subject d-xl-inline-block d-block"> - {{ lead.cell
                                        }}</span>
                                    </div>
                                    <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                        <span
                                            class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
                                            data-label="private"></span>
                                        <small class="email-list-item-time text-muted">{{ lead.created_at }}</small>
                                        <ul class="list-inline email-list-item-actions">
                                            <li class="list-inline-item email-delete"> <i class="bx bx-trash-alt fs-4"></i>
                                            </li>
                                            <li class="list-inline-item email-read"> <i class="bx bx-envelope fs-4"></i>
                                            </li>
                                            <li class="list-inline-item"> <i class="bx bx-error-circle fs-4"></i> </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-unstyled m-0">
                            <li class="email-list-empty text-center d-none">No items found.</li>
                        </ul>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 414px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 264px;"></div>
                        </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 414px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 264px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-3">
            <h6>Recientes</h6>
            <div class="col-md-4" v-for="lead in todayLeads">
                <div class="card bg-danger my-3">
                    <div class="card-header text-white">{{ lead.name || lead.cell }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" v-for="lead in myLeads">
                <div class="card bg-success my-3">
                    <div class="card-header text-white">{{ lead.name || lead.cell }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return { store }
    },
    data() {
        return {
            myLeads: [],
            todayLeads: []
        }
    },
    methods: {
        getAllMyLeads() {
            axios.get('/api/getAllMyLeads/' + this.store.authUser.id)
                .then((res) => {
                    this.myLeads = res.data.customers
                    this.todayLeads = res.data.customersToday
                })
                .catch((err) => {

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