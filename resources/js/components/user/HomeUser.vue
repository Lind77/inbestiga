<template>
    <div>
        <div class="container">
            <div class="card mt-5 bg-info">
                <h4 class="card-header"></h4>
                <div class="card-body">
                    <ul class="timeline" v-for="quotation in info.quotations">
                        <li class="timeline-item timeline-item-transparent mb-3" v-for="project in projects">
                            <!-- <span class="timeline-point-wrapper"><span
                                    class="timeline-point timeline-point-primary"></span></span> -->
                            <div class="timeline-event ps-3 my-4">
                                <div class="timeline-header border-bottom mb-3 mt-3">
                                    <h5 class="mb-0">Proyecto {{ project.id }}</h5>
                                    <span>Fecha: {{ project.deadline }}</span>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap mb-0">
                                    <div>
                                        <!-- <span>{{ project }}</span> -->
                                        <!-- <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                        <span>Heathrow Airport, London</span> -->
                                    </div>
                                    <!-- <div>
                                        <span class="text-muted">6:30 AM</span>
                                    </div> -->
                                </div>
                                <button class="btn btn-primary" @click="showCustomerModal(quotation.id)"> Ver más
                                </button>
                            </div>
                        </li>
                        <!-- < li class=" timeline-item timeline-item-transparent">
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
            info: {},
            projects: []
        }
    },
    methods: {
        showCustomerModal(quotationId) {
            this.$router.push({ name: 'user-documentation', params: { quotationId: quotationId } })
        },
        getUserInfo() {
            axios.get('/api/customer-by-id/' + this.$route.params.customerId)
                .then((result) => {
                    this.info = result.data
                    result.data.quotations.forEach(quotation => {
                        quotation.contract.projects.forEach(project => {
                            this.projects.push(project)
                        })
                    });
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