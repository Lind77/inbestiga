<template>
    <div class="container">

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" v-model="email" id="exampleFormControlInput1"
                placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="content"></textarea>
        </div>
        <button class="btn btn-success" @click="sendMail">Enviar Email</button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            content: '',
            email: ''
        }
    },
    methods: {
        sendMail() {
            const fd = new FormData()
            fd.append('email', this.email)
            fd.append('content', this.content)

            axios.post('/api/send-welcome-email', fd)
                .then((result) => {
                    this.$swal('Mensaje enviado correctamente')
                }).catch((err) => {
                    console.log(err)
                });
        },
    }
}
</script>
<style></style>