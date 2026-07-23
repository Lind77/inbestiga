<template>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Side: Image Panel -->
            <div class="image-panel">
                <div class="brand-logo">
                    <svg width="32" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                        </defs>
                        <use fill="#BFC2C7" xlink:href="#path-1"></use>
                    </svg>
                    <span class="ms-2 fw-bold fs-4 logo-text">AVANTAGE <span class="fw-normal" style="font-size: 0.6em; letter-spacing: 2px;">GROUP</span></span>
                </div>
                <div class="image-overlay">
                    <div class="overlay-text">
                        <h2 class="font-montserrat">Impulsamos el<br>conocimiento.<br>Creamos el futuro.</h2>
                        <p class="font-poppins text-muted-brand mt-3">Desarrollamos soluciones inteligentes a través de la investigación, la tecnología y el marketing digital.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="form-panel">
                <div class="form-content">
                    <h1 class="title font-montserrat">Iniciar Sesión</h1>
                    <p class="subtitle font-exo text-muted-brand">Accede a tu panel de control Avantage.</p>

                    <transition name="fade">
                        <div v-if="errorMessage" class="login-alert font-poppins mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="alert-icon me-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>{{ errorMessage }}</span>
                        </div>
                    </transition>

                    <form @submit.prevent="login">
                        
                        <div class="input-group-custom mb-3 mt-4">
                            <label for="email" class="custom-label font-poppins">
                                Email
                            </label>
                            <input type="email" id="email" class="custom-input font-poppins" v-model="email" placeholder="ejemplo@avantage.com" required autofocus />
                        </div>

                        <div class="input-group-custom mb-5">
                            <label for="password" class="custom-label font-poppins">
                                Contraseña
                            </label>
                            <input type="password" id="password" class="custom-input font-poppins" v-model="password" placeholder="••••••••" required />
                        </div>

                        <button type="submit" class="custom-btn font-montserrat">
                            Ingresar
                        </button>
                    </form>
                </div>
                
                <div class="form-footer font-poppins text-muted-brand">
                    <small>RESEARCH • TECHNOLOGY • INNOVATION • GROWTH</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { userStore } from "../../stores/UserStore.js";
import { showLoader } from "../../utils/Loader.js";
import { closeLoader } from "../../utils/CloseLoader.js";

export default {
    data() {
        return {
            email: "",
            password: "",
            device_name: "browser",
            errors: {},
            errorMessage: "",
        };
    },
    setup() {
        const store = userStore();
        return { store };
    },
    methods: {
        login() {
            this.errorMessage = "";
            showLoader();
            const fd = new FormData();
            fd.append("email", this.email);
            fd.append("password", this.password);
            fd.append("device_name", this.device_name);

            axios
                .post("/api/login", fd)
                .then((res) => {
                    localStorage.setItem("token", res.data.token);
                    this.store.setUser(res.data.user);
                    this.$router.push({ path: "/home" });
                    closeLoader();
                })
                .catch((err) => {
                    closeLoader();
                    console.error(err);
                    if (err.response && err.response.data) {
                        this.errors = err.response.data.errors || {};
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
/* Reset global dark mode for this page */
.login-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #1B1B1B; /* Brand black */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.login-container {
    display: flex;
    width: 100%;
    height: 100vh;
    background: #1B1B1B;
    overflow: hidden;
}

/* Typography utilities */
.font-montserrat { font-family: 'Montserrat', sans-serif; }
.font-exo { font-family: 'Exo 2', sans-serif; }
.font-poppins { font-family: 'Poppins', sans-serif; }
.text-muted-brand { color: #BFC2C7; } /* Silver */

/* Left Panel */
.image-panel {
    flex: 1.5;
    background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop'); /* Science/Tech background */
    background-size: cover;
    background-position: center;
    position: relative;
}

.image-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(27,27,27,0.9) 0%, rgba(27,27,27,0.4) 100%);
    display: flex;
    align-items: center;
    padding: 6rem;
}

.overlay-text {
    max-width: 500px;
}

.overlay-text h2 {
    color: #FFFFFF;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
}

.overlay-text p {
    font-size: 1.1rem;
    line-height: 1.6;
}

.brand-logo {
    position: absolute;
    top: 3rem;
    left: 3rem;
    display: flex;
    align-items: center;
    z-index: 10;
}

.logo-text {
    color: #FFFFFF;
    letter-spacing: 1px;
}

/* Right Panel */
.form-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 4rem;
    background-color: #1B1B1B;
    border-left: 1px solid #555B5C; /* Dark gray border */
    position: relative;
}

.form-content {
    max-width: 400px;
    margin: 0 auto;
    width: 100%;
}

.title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 0.5rem;
}

.subtitle {
    font-size: 1rem;
    margin-bottom: 2rem;
}

/* Alert Styling */
.login-alert {
    display: flex;
    align-items: center;
    padding: 0.85rem 1.1rem;
    background-color: rgba(234, 84, 85, 0.12);
    border: 1px solid rgba(234, 84, 85, 0.35);
    border-radius: 6px;
    color: #FF6B6B;
    font-size: 0.88rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(234, 84, 85, 0.12);
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

/* Form Styles */
.custom-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #FFFFFF;
    margin-bottom: 0.8rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.custom-input {
    width: 100%;
    padding: 1rem 1.2rem;
    border: 1px solid #555B5C;
    border-radius: 4px;
    background-color: #222222;
    font-size: 0.95rem;
    color: #FFFFFF;
    transition: all 0.3s ease;
}

.custom-input::placeholder {
    color: #555B5C;
}

.custom-input:focus {
    outline: none;
    border-color: #1D5EFF;
    background-color: #1B1B1B;
    box-shadow: 0 0 0 3px rgba(29, 94, 255, 0.2);
}

.custom-input:-webkit-autofill,
.custom-input:-webkit-autofill:hover,
.custom-input:-webkit-autofill:focus,
.custom-input:-webkit-autofill:active,
.custom-input:autofill,
.custom-input:autofill:hover,
.custom-input:autofill:focus,
.custom-input:autofill:active {
    -webkit-text-fill-color: #FFFFFF !important;
    color: #FFFFFF !important;
    caret-color: #FFFFFF !important;
    -webkit-box-shadow: 0 0 0 1000px #222222 inset !important;
    box-shadow: 0 0 0 1000px #222222 inset !important;
    transition: background-color 50000s ease-in-out 0s !important;
}

.custom-btn {
    width: 100%;
    padding: 1.2rem;
    background-color: #1D5EFF; /* Brand blue */
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 700;
    color: #FFFFFF;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.custom-btn:hover {
    background-color: #1545cc;
    box-shadow: 0 4px 15px rgba(29, 94, 255, 0.4);
    transform: translateY(-2px);
}

/* Footer Links */
.form-footer {
    position: absolute;
    bottom: 2rem;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 0.75rem;
    letter-spacing: 2px;
}

@media (max-width: 992px) {
    .image-panel {
        display: none;
    }
    .form-panel {
        padding: 2rem;
        border-left: none;
    }
}
</style>
