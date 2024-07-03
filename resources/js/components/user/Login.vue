<template>
    <div class="bg-login-user">
        <div class="container glass">
            <img
                src="https://inbestiga.com/inbestiga/public/img/ib_newlogo.png"
                alt="Logo"
                class="w-25"
            />
            <form class="p-1" autocomplete="off">
                <h4 class="fw-normal text-white py-4 text-center">Login</h4>
                <div class="form-group mx-4">
                    <input
                        type="email"
                        class="form-control"
                        autocomplete="off"
                        v-model="email"
                        placeholder="Correo"
                    />
                </div>
                <div class="form-group mt-5 mx-4">
                    <input
                        type="password"
                        class="form-control"
                        autocomplete="off"
                        v-model="password"
                        placeholder="Contraseña"
                    />
                </div>
                <div class="form-group my-3 mx-4">
                    <input
                        type="submit"
                        value="Ingresar"
                        class="btn-submit"
                        @click="login"
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { userStore } from "../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        login(e) {
            e.preventDefault();
            const fd = new FormData();
            fd.append("email", this.email);
            fd.append("password", this.password);
            fd.append("device_name", "browser");

            axios
                .post("/api/login-user", fd)
                .then((result) => {
                    localStorage.setItem("token", result.data.token);
                    this.store.setUser(result.data.user);
                    this.$router.push({
                        path: "/home-user/" + result.data.user.id,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        icon: "error",
                        title: "Credenciales incorrectas",
                    });
                    console.error(err);
                });
        },
    },
};
</script>

<style scoped>
label {
    color: #fff;
}

.form-control {
    background: none;
    margin: 0px;
    border-radius: 0px;
    border-bottom: 1px #fff solid;
    border-width: 0px 0px 1px 0px;
    color: #fff;
    padding-bottom: 3px;
    padding-left: 3px;
}

::placeholder {
    color: #fff;
    font-weight: 500;
    font-size: 18px;
}

.bg-login-user {
    background-image: url("/inbestiga/public/img/loginUser.jpg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    width: 30%;
    padding: 30px;
    background-color: rgba(0, 0, 0, 0.32);
    border-radius: 5px;
}

.glass {
    background: rgb(255, 255, 255);
    background: linear-gradient(
        155deg,
        rgba(255, 255, 255, 1) -10%,
        rgba(0, 0, 0, 0.24) 8%,
        rgba(255, 255, 255, 0) 92%,
        rgba(255, 255, 255, 1) 120%
    );
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 5px;
}

.btn-submit {
    margin-top: 50px;
    width: 100%;
    border: 1px #fff solid;
    border-radius: 5px;
    padding: 7px 0px;
    position: relative;
    z-index: 1;
    background-color: rgba(0, 0, 0, 0) !important;
    color: #fff;
    font-weight: 600;
    font-size: 18px;
    transition: 0.8s;
}

.btn-submit:hover {
    transition: 0.8s;
    background-color: rgba(127, 33, 251, 0.2) !important;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}

@media only screen and (max-width: 600px) {
    .container {
        width: 80%;
        padding: 30px;
    }
}
</style>
