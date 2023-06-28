<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Permisos</h4>
        <div class="row">
            <div class="col-md-4" v-for="user in users">
                <div class="card text-start mt-2">
                    <div class="card-body">
                        <h4 class="card-title">{{ user.name }}</h4>
                        <p class="card-text">Permisos</p>
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
            users: []
        }
    },
    methods: {
        getAllUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
    },
    mounted() {
        this.getAllUsers()
    }
}
</script>
