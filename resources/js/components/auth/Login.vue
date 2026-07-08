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
                        <use fill="#ffffff" xlink:href="#path-1"></use>
                    </svg>
                    <span class="ms-2 fw-bold text-white fs-5">Avantage</span>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="form-panel">
                <div class="form-content">
                    <h1 class="title" style="color: #000 !important;"> Avantage</h1>

                    <form @submit.prevent="login">
                        
                        <div class="input-group-custom mb-3">
                            <label for="email" class="custom-label">
                                <i class="bx bx-envelope me-2"></i> Email Address
                            </label>
                            <input type="email" id="email" class="custom-input" v-model="email" placeholder="Enter your email" required autofocus />
                        </div>

                        <div class="input-group-custom mb-4">
                            <label for="password" class="custom-label">
                                <i class="bx bx-lock-alt me-2"></i> Password
                            </label>
                            <input type="password" id="password" class="custom-input" v-model="password" placeholder="Enter your password" required />
                        </div>

                        <button type="submit" class="custom-btn">
                            Enter Avantage
                        </button>
                    </form>
                </div>
                
                <div class="form-footer">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
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
        };
    },
    setup() {
        const store = userStore();
        return { store };
    },
    methods: {
        login() {
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
                    this.$swal({
                        icon: "error",
                        title: "Credenciales incorrectas",
                    });
                    console.error(err);
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                    closeLoader();
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
    background-color: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    z-index: 10000; /* over anything else */
    font-family: 'Public Sans', sans-serif;
}

.login-container {
    display: flex;
    width: 100%;
    max-width: 1200px;
    height: 80vh;
    min-height: 600px;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

/* Left Panel */
.image-panel {
    flex: 1.2;
    background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
    margin: 1rem;
    border-radius: 20px;
    position: relative;
}

.brand-logo {
    position: absolute;
    bottom: 2rem;
    left: 2rem;
    display: flex;
    align-items: center;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1.2rem;
    border-radius: 12px;
}

/* Right Panel */
.form-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 4rem;
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
    color: #1a1d27;
    margin-bottom: 0.5rem;
}

.subtitle {
    font-size: 0.95rem;
    color: #6c757d;
    margin-bottom: 2.5rem;
    line-height: 1.5;
}

/* Form Styles */
.custom-label {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4a505e;
    margin-bottom: 0.5rem;
}

.custom-input {
    width: 100%;
    padding: 1rem 1.2rem;
    border: 1px solid #e2e5e9;
    border-radius: 12px;
    background-color: #fafbfc;
    font-size: 0.95rem;
    color: #1a1d27;
    transition: all 0.2s;
}

.custom-input:focus {
    outline: none;
    border-color: #7451f8;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(116, 81, 248, 0.1);
}

.custom-btn {
    width: 100%;
    padding: 1rem;
    background-color: #ffffff;
    border: 1px solid #e2e5e9;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    color: #1a1d27;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}

.custom-btn:hover {
    border-color: #7451f8;
    color: #7451f8;
    background-color: #f8f7ff;
    box-shadow: 0 4px 12px rgba(116, 81, 248, 0.08);
}

/* Checkbox */
.custom-checkbox .form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    border-radius: 4px;
    margin-top: 0.1rem;
}
.custom-checkbox .form-check-input:checked {
    background-color: #1a1d27;
    border-color: #1a1d27;
}

/* Footer Links */
.form-footer {
    position: absolute;
    bottom: 2rem;
    right: 2rem;
    display: flex;
    gap: 1.5rem;
}

.form-footer a {
    font-size: 0.8rem;
    color: #a0a5b1;
    text-decoration: none;
    transition: color 0.2s;
}

.form-footer a:hover {
    color: #1a1d27;
}

@media (max-width: 992px) {
    .image-panel {
        display: none;
    }
    .form-panel {
        padding: 2rem;
    }
    .login-container {
        height: auto;
        min-height: 500px;
    }
}
</style>
