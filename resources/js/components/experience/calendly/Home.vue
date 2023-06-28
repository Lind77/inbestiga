<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendly</h4>
        <div class="card text-start mt-2" v-for="item in collection">

            <div class="card-header"></div>
            <div class="card-body">
                <h4 class="card-title">{{ item.name }}</h4>
                <p class="card-text">{{ formatDate(item.start_time) }}</p>
                <p class="card-text">{{ formatTime(item.start_time) }} - {{ formatTime(item.end_time) }}</p>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment"
export default {
    data() {
        return {
            user: {},
            collection: []
        }
    },
    methods: {
        formatDate(time) {
            return moment(time).format('DD/MM/YYYY')
        },
        formatTime(time) {
            return moment(time).format('hh:mm a')
        },
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
                    code: this.$route.query.code,
                    redirect_uri: 'http://localhost/inbestiga/experience/calendly'
                }
            };
            axios.request(options)
                .then((result) => {
                    console.log(result.data);
                    this.consultEvents(result.data.access_token)
                }).catch((err) => {
                    console.error(err);
                });
        },
        consultEvents(token) {
            const options = {
                method: 'GET',
                url: 'https://api.calendly.com/scheduled_events',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + token
                },
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

    },
    mounted() {
        if (!this.$route.query.code) {
            window.location.href = 'https://auth.calendly.com/oauth/authorize?client_id=-YNvCOQqVnBK9puAQFjOMNSa_AGBGHvmuSk2zMKX-oI&response_type=code&redirect_uri=http://localhost/inbestiga/experience/calendly'
        } else {
            this.login()
        }
    }
}
</script>
<style></style>