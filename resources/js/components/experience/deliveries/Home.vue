<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Entregas</h4>
        <div class="app-email card">
            <div class="border-0">
                <div class="row g-0">


                    <!-- Emails List -->
                    <div class="col app-emails-list">
                        <div class="card shadow-none border-0">
                            <div class="card-body emails-list-header p-3 py-lg-3 py-2">
                                <!-- Email List: Search -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center w-100">
                                        <i class="bx bx-menu bx-sm cursor-pointer d-block d-lg-none me-3"
                                            data-bs-toggle="sidebar" data-target="#app-email-sidebar" data-overlay=""></i>
                                        <div class="mb-0 mb-lg-2 w-100">
                                            <div class="input-group input-group-merge shadow-none">
                                                <span class="input-group-text border-0 ps-0 py-0" id="email-search">
                                                    <i class="bx bx-search fs-4 text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control email-search-input border-0 py-0"
                                                    placeholder="Buscar entrega" aria-label="Search..."
                                                    aria-describedby="email-search">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-0 mb-md-2">
                                        <i
                                            class="bx bx-refresh scaleX-n1-rtl cursor-pointer email-refresh me-2 bx-sm text-muted"></i>
                                        <div class="dropdown">
                                            <i class="bx bx-dots-vertical-rounded cursor-pointer bx-sm text-muted"
                                                id="emailsActions" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </i>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="emailsActions">
                                                <a class="dropdown-item" href="javascript:void(0)">Mark as read</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Mark as unread</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Archive</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mx-n3 emails-list-header-hr">
                                <!-- Email List: Actions -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="dropdown">
                                            <i class="bx bx-label fs-4 cursor-pointer me-3" id="dropdownLabel"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </i>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLabel">
                                                <a class="dropdown-item" href="javascript:void(0)">
                                                    <i class="badge badge-dot bg-success me-1"></i>
                                                    <span class="align-middle">Workshop</span>
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)">
                                                    <i class="badge badge-dot bg-primary me-1"></i>
                                                    <span class="align-middle">Company</span>
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)">
                                                    <i class="badge badge-dot bg-warning me-1"></i>
                                                    <span class="align-middle">Important</span>
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)">
                                                    <i class="badge badge-dot bg-danger me-1"></i>
                                                    <span class="align-middle">Private</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="email-pagination d-sm-flex d-none align-items-center flex-wrap justify-content-between justify-sm-content-end">
                                        <span class="d-sm-block d-none mx-3 text-muted">1-10 of 653</span>
                                        <i
                                            class="email-prev bx bx-chevron-left scaleX-n1-rtl cursor-pointer text-muted me-4 fs-4"></i>
                                        <i class="email-next bx bx-chevron-right scaleX-n1-rtl cursor-pointer fs-4"></i>
                                    </div>
                                </div>
                            </div>
                            <hr class="container-m-nx m-0">
                            <!-- Email List: Items -->
                            <div class="email-list pt-0 ps ps--active-y">
                                <ul class="list-unstyled m-0">
                                    <li class="email-list-item email-marked-read py-3 px-5" data-starred="true"
                                        data-bs-toggle="sidebar" data-target="#app-email-view"
                                        v-for="delivery in deliveries">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="email-list-item-input form-check-input" type="checkbox"
                                                    id="email-1">
                                                <label class="form-check-label" for="email-1"></label>
                                            </div>

                                            <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                                <span class="email-list-item-username me-2 h6">{{
                                                    delivery.contract.quotation.customer.name
                                                }}</span>
                                                <span class="email-list-item-subject d-xl-inline-block d-block"> {{
                                                    delivery.advance
                                                }}</span>
                                            </div>
                                            <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                                <span
                                                    class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
                                                    data-label="private"></span>
                                                <small class="email-list-item-time text-muted">08:40 AM</small>

                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="app-overlay"></div>
                    </div>
                    <!-- /Emails List -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            deliveries: []
        }
    },
    methods: {
        getAllDeliveries() {
            axios.get('/api/deliveries')
                .then((result) => {
                    this.deliveries = result.data
                }).catch((err) => {

                });
        }
    },
    mounted() {
        this.getAllDeliveries()
    }
}
</script>