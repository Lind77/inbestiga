<template>
    <div class="glass-card col-4 p-4">
        <img
            src="https://i.pinimg.com/564x/8f/ee/ec/8feeec43a7ff61f24e2b7fd3791ed5b5.jpg"
            alt=""
        />
        <h4 class="fw-normal text-white">Proyecto 1</h4>
        <p class="text-white">Fecha de Inicio: 24/06/2024</p>
    </div>
</template>
<script>
export default {};
</script>
<style scoped>
.glass-card {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 8px;

    padding: 0px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.glass-card > img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 100%;
    margin-bottom: 15px;
}
</style>
