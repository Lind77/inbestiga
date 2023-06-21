<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendly</h4>
        <button class="btn btn-primary" @click="login">Login</button>
        <button class="btn btn-primary ms-2" @click="consult">Consultar</button>
        <div class="card text-start mt-2" v-for="item in collection">

            <div class="card-header"></div>
            <div class="card-body">
                <h4 class="card-title">{{ item.name }}</h4>
                <p class="card-text">{{ item.start_time }} - {{ item.end_time }}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: {},
            collection: []
        }
    },
    methods: {
        login() {
            const authHeader = 'LVlOdkNPUXFWbkJLOXB1QVFGak9NTlNhX0FHQkdIdm11U2syek1LWC1vSTpQMGt2eFEzX2xYY1pLRlhEXzhRVDNzaHR6Nk5nNV8zdnV1UmdHMHFSbDZv';
            const options = {
                method: 'POST',
                url: 'https://auth.calendly.com/oauth/token',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    Authorization: `Basic ${authHeader}`
                },
                data: {
                    grant_type: 'authorization_code',
                    code: 'hWowJLXaTTUKNtyK1NZ0leD08WOks5ALW91vpcQMccQ',
                    redirect_uri: 'http://localhost/inbestiga/experience/calendly'
                }
            };
            axios.request(options).then(function (response) {
                console.log(response.data);
            }).catch(function (error) {
                console.error(error);
            });
        },
        consult() {
            const options = {
                method: 'GET',
                url: 'https://api.calendly.com/scheduled_events',
                headers: { 'Content-Type': 'application/json', Authorization: 'Bearer' },
                params: {
                    user: 'https://api.calendly.com/users/e28cabfc-357b-4003-9b01-984cb4590c73'
                }
            };
            this.user = {}
            axios.request(options)
                .then((response) => {
                    console.log(response.data);
                    this.user = response.data
                    this.collection = response.data.collection
                }).catch((error) => {
                    console.error(error);
                });
        },

    }
}
</script>
<style></style>