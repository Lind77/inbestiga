<template>
    <div>
        <div class="container">
            <div class="card mt-5 bg-info">
                <h5 class="card-header">Mis Proyectos</h5>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span
                                    class="timeline-point timeline-point-primary"></span></span>
                            <div class="timeline-event ps-5">
                                <div class="timeline-header border-bottom mb-3">
                                    <h6 class="mb-0">Get on the flight</h6>
                                    <span class="text-muted">3rd October</span>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                    <div>
                                        <span>Charles de Gaulle Airport, Paris</span>
                                        <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                        <span>Heathrow Airport, London</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">6:30 AM</span>
                                    </div>
                                </div>
                                <a href="javascript:void(0)">
                                    <i class="bx bx-link"></i>
                                    bookingCard.pdf
                                </a>
                            </div>
                        </li>
                        <!--  <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span
                                    class="timeline-point timeline-point-success"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-sm-0 mb-3">
                                    <h6 class="mb-0">Design Review</h6>
                                    <span class="text-muted">4th October</span>
                                </div>
                                <p>
                                    Weekly review of freshly prepared design for our new
                                    application.
                                </p>
                                <div class="d-flex justify-content-between">
                                    <h6>New Application</h6>

                                </div>
                            </div>
                        </li> -->
                        <!--  <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>


    </div>
</template>
<script>
export default {
    data() {
        return {
            info: {}
        }
    },
    methods: {
        getUserInfo() {
            axios.get('/api/customer-by-id/' + this.$route.params.customerId)
                .then((result) => {
                    this.info = result.data
                }).catch((err) => {
                    console.log(err)
                });
        }
    },
    mounted() {
        this.getUserInfo()
    },
}
</script>
<style scoped>
.timeline {
    position: relative;
    height: 100%;
    width: 100%;
    padding: 0;
    list-style: none;
}

html:not([dir=rtl]) .timeline-item {
    border-left: 1px solid #444564;
}

.timeline .timeline-item .timeline-point-wrapper {
    position: absolute;
    top: -0.5rem;
    left: -0.4089999999999998rem;
    z-index: 2;
    display: block;
    height: 2.25rem;
    width: 2.25rem;
    background-color: #03c3ec;
}

.timeline .timeline-item .timeline-point {
    position: absolute;
    left: 0;
    top: 0.75rem;
    z-index: 3;
    display: block;
    height: 0.75rem;
    width: 0.75rem;
    border-radius: 50%;
    background-color: #696cff;
}

.timeline .timeline-point-primary {
    background-color: #696cff !important;
    box-shadow: 0 0 0 0.1875rem rgba(105, 108, 255, .16);
}
</style>