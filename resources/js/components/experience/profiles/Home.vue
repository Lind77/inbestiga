<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Perfiles</h4>
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3" v-for="profile in profiles">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="max-width: 500px" :title="profile.university">{{
                                    profile.university.length > 15 ? profile.university.substring(0, 15) + '...' :
                                    profile.university }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" :title="profile.name">{{
                                        profile.name.length > 15 ? profile.name.substring(0, 15) + '...' : profile.name }}
                                    </h4>
                                    <!-- <small class="text-success">(+29%)</small> -->
                                </div>
                                <small :title="profile.career">{{ profile.career.length > 20 ? profile.career.substring(0,
                                    20) + '...' :
                                    profile.career }}</small>
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