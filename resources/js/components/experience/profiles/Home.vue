<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Perfiles</h4>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3" v-for="profile in profiles">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="max-width: 500px">{{ profile.name }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">S./ {{ profile.quotations[0].amount }}</h4>
                                    <small class="text-success">(+29%)</small>
                                </div>
                                <small>{{ profile.career }}</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
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
            profiles: []
        }
    },
    methods: {
        getProfiles() {
            axios.get('/api/profiles')
                .then((result) => {
                    this.profiles = result.data
                }).catch((err) => {
                    console.log(err);
                });
        }
    },
    computed: {

    },
    mounted() {
        this.getProfiles()
    }
}
</script>