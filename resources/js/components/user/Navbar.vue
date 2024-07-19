<template>
    <div class="sticky-top glass-bg d-flex">
        <ul
            class="navbar-nav d-flex flex-row justify-content-between align-items-center mx-4 w-100"
        >
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a
                    class="nav-link dropdown-toggle hide-arrow pt-2"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                >
                    <i class="bx bx-grid-alt text-white"></i>
                </a>
                <Dropdown :customerId="store.authUser.id" />
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a
                    class="nav-link dropdown-toggle hide-arrow pt-2"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                >
                    <div class="avatar">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-md me-4">
                                <img
                                    src="https://inbestiga.com/inbestiga/public/files/1709671609.png"
                                    alt="Avatar"
                                    class="rounded-circle"
                                />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item cursor-pointer" @click="logout">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Salir</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>
<script>
import { userStore } from "../../stores/UserStore";
import Dropdown from "./Dropdown.vue";

export default {
    components: { Dropdown },
    setup() {
        const store = userStore();
        return { store };
    },
    data() {
        return {
            token: localStorage.getItem("token"),
        };
    },
    methods: {
        toggleAside() {
            this.$emit("toggleSidebar");
        },
        logout() {
            window.axios.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
            this.axios
                .post("/api/logout-customer")
                .then((res) => {
                    localStorage.removeItem("token");
                    this.store.authUser = null;
                    this.$router.push({ name: "user-login" });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        toMyProjects() {
            this.$router.push({
                name: "project-user",
                params: { customerId: this.store.authUser.id },
            });
        },
    },
};
</script>
<style scoped>
i {
    font-size: 2.3rem;
}
.glass-bg {
    padding: 5px 0px;
    background: rgba(255, 255, 255, 0.112);
    border-radius: 10px !important;
}

.glass-bg::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(10px);
    z-index: -1;
}

@media only screen and (max-width: 576px) {
    .glass {
        height: 3% !important;
    }
    .avatar {
        height: 2.3rem;
        width: 2.3rem;
    }
}
</style>
