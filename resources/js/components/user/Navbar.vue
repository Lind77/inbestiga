<template>
    <div class="glass d-flex mt-2">
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
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a
                    class="nav-link dropdown-toggle hide-arrow pt-0 pe-3"
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
export default {
    methods: {
        toggleAside() {
            this.$emit("toggleSidebar");
        },
    },
};
</script>
<style lang=""></style>
