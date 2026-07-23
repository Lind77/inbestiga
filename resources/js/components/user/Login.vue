<template>
    <div class="bg-login-user">
        <div class="container glass">
            <img
                src="/img/logo_ag.png"
                alt="AG Logo"
                class="my-2"
                style="max-height: 65px; object-fit: contain;"
            />
            <form class="p-1" autocomplete="off">
                <h4 class="fw-normal text-white py-4 text-center">Login</h4>
                <transition name="fade">
                    <div v-if="errorMessage" class="login-alert font-poppins mx-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="alert-icon me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span>{{ errorMessage }}</span>
                    </div>
                </transition>
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
            errorMessage: "",
        };
    },
    methods: {
        login(e) {
            e.preventDefault();
            this.errorMessage = "";
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
                        path: "/user/" + result.data.user.id,
                    });
                })
                .catch((err) => {
                    console.error(err);
                    if (err.response && err.response.data) {
                        if (err.response.data.message && err.response.data.message !== "Unauthenticated." && err.response.data.message !== "The given data was invalid.") {
                            this.errorMessage = err.response.data.message;
                        } else if (err.response.data.errors) {
                            const firstKey = Object.keys(err.response.data.errors)[0];
                            this.errorMessage = err.response.data.errors[firstKey][0];
                        } else {
                            this.errorMessage = "Credenciales incorrectas. Verifica tu correo y contraseña.";
                        }
                    } else {
                        this.errorMessage = "Credenciales incorrectas. Verifica tu correo y contraseña.";
                    }
                });
        },
    },
};
</script>

<style scoped>
.login-alert {
    display: flex;
    align-items: center;
    padding: 0.85rem 1.1rem;
    background-color: rgba(234, 84, 85, 0.15);
    border: 1px solid rgba(234, 84, 85, 0.4);
    border-radius: 6px;
    color: #FF6B6B;
    font-size: 0.88rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(234, 84, 85, 0.15);
}

.alert-icon {
    flex-shrink: 0;
    color: #FF6B6B;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
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
    background-image: url("/img/loginUser.jpg");
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
input:-webkit-autofill:active,
input:autofill,
input:autofill:hover,
input:autofill:focus,
input:autofill:active {
    -webkit-text-fill-color: #ffffff !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
    -webkit-box-shadow: 0 0 0 1000px #1b1b1b inset !important;
    box-shadow: 0 0 0 1000px #1b1b1b inset !important;
    transition: background-color 50000s ease-in-out 0s !important;
}

@media only screen and (max-width: 600px) {
    .container {
        width: 80%;
        padding: 30px;
    }
}
</style>
