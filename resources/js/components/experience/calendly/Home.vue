<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendly</h4>
        <button class="btn btn-primary" @click="login">Login</button>
    </div>
</template>
<script>
export default {
    methods: {
        login() {
            const options = {
                method: 'POST',
                url: 'https://auth.calendly.com/oauth/token',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Access-Control-Allow-Origin': '*',
                    Authorization: 'Basic undefined'
                },
                data: {
                    grant_type: 'authorization_code',
                    code: '2WG66Ic_iVyBP9XaGPznsZMV8tEzRinYfh5gpvkxrGY',
                    redirect_uri: 'https://sistema.inbestiga.com/experience/calendly'
                }
            };
            axios.request(options).then(function (response) {
                console.log(response.data);
            }).catch(function (error) {
                console.error(error);
            });
        }
    }
}
</script>
<style></style>