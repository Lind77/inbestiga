<template>
    <div class="sticky-top glass d-flex mt-2">
        <ul
            class="navbar-nav d-flex flex-row justify-content-between align-items-center mx-4 w-100"
        >
            <div
                class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0"
            >
                <a
                    @click="toggleAside"
                    class="nav-item nav-link px-0 me-xl-4"
                    href="javascript:void(0)"
                >
                    <i class="bx bx-menu bx-sm text-white"></i>
                </a>
            </div>
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

export default {
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
    },
};
</script>
<style scoped>
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
