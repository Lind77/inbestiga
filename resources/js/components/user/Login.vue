<template>
    <div class="bg-login-user">
        <div class="container glass">
            <form class="p-2" autocomplete="off">
                <h5 class="fw-bold text-white pt-5 pb-2">¡Bienvenido a InBESTiga!</h5>
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
    background-image: url('/inbestiga/public/img/loginUser.jpg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    width: 37%;
    padding: 60px;
    background-color: rgba(0, 0, 0, 0.32);
    border-radius: 30px;
}

.glass {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.191), rgba(255, 255, 255, 0));
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
}

.btn-submit {
    margin-top: 50px;
    width: 100%;
    border: none;
    border-radius: 10px;
    padding: 7px 0px;
    position: relative;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0.32) !important;
    color: #fff;
    font-weight: 600;
    font-size: 15px;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}
</style>