<template>
    <div class="bg-login-user">
        <div class="container">
            <form class="p-3" autocomplete="off">
                <h5 class="fw-bold text-white pt-5">¡Bienvenido a InBESTiga!</h5>
                <div class="form-group">
                    <label for="">Ingresa tu email</label>
                    <input type="email" class="form-control" autocomplete="off" v-model="email">
                </div>
                <div class="form-group mt-3">
                    <label for="">Contraseña</label>
                    <input type="password" class="form-control" autocomplete="off" v-model="password">
                </div>
                <div class="form-group">
                    <input type="submit" value="Ingresar" class="btn-submit" @click="login">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login(e) {
            e.preventDefault()
            const fd = new FormData()
            fd.append('email', this.email)
            fd.append('password', this.password)
            fd.append('device_name', 'browser')

            axios.post('/api/login-user', fd)
                .then((result) => {
                    console.log(result.data)
                    this.$router.push({ path: '/home-user/' + result.data.id })
                }).catch((err) => {
                    this.$swal({
                        icon: 'error',
                        title: 'Credenciales incorrectas'
                    })
                    console.error(err)
                });
        }
    }
}
</script>

<style scoped>
label {
    color: #fff;
}

.form-control {
    background-color: #fff !important;
}

.bg-login-user {
    background: url('/inbestiga/public/img/login-user.png') no-repeat;
    background-attachment: fixed;
    background-size: cover;
    display: grid;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.container {
    width: 30rem;
    height: 25rem;
    box-shadow: 0 0 1rem 0 rgb(0, 0, 0);
    border-radius: 20px;
    position: relative;
    z-index: 1;
    background: inherit;
    overflow: hidden;
}

.container:before {
    content: "";
    position: absolute;
    background: inherit;
    z-index: -1;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    box-shadow: inset 0 0 2000px rgba(46, 46, 46, 0.238);
    filter: blur(10px);
    margin: -20px;
}

.btn-submit {
    margin-top: 50px;
    width: 100%;
    border: none;
    border-radius: 5px;
    position: relative;
    z-index: 1;
    background-color: #0000009d !important;
    color: #fff;
    padding: 5px 0px;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}
</style>