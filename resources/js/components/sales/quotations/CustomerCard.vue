<template>
    <div class="card shadow-none bg-transparent border border-info mb-3"  v-if="customerSelected.id">
        <div class="card-body">
        <h5 class="card-title">Cliente: {{ customerSelected.name }}</h5>
        <p class="card-text">
            Teléfono: {{ customerSelected.cell }}
        </p>
        <p class="card-text">
            Carrera: {{ customerSelected.career }}
        </p>
        <p class="card-text">
            Universidad: {{ customerSelected.university }}
        </p>
        <!-- <p class="card-text">
            Estado: {{ status[customerSelected.status] }}
        </p> -->
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            customerSelected: Object
        }
    }
</script>