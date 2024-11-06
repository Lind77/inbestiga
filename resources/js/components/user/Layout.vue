<template>
    <div class="bg-user">
        <div class="container pt-5">
            <Navbar />
            <div class="row">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import Navbar from "./Navbar.vue";

export default {
    components: { Navbar },
};
</script>
<style>
.bg-user {
    width: 100%;
    min-height: 100vh;
    height: auto;
    background-image: linear-gradient(
        135deg,
        rgba(95, 29, 95, 1) 2%,
        rgba(41, 21, 41, 1) 25%,
        rgba(41, 21, 41, 1) 57%,
        rgba(95, 29, 95, 1) 92%
    );
    background-size: cover;
}
</style>
