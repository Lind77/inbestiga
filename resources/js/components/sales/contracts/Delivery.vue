<template>
    <div class="col-4" v-for="delivery in deliveries">
        <div class="card bg-success text-white">
            <div class="card-body">
            Fecha
            <input type="date" class="form-control" v-model="delivery.date">
            <br>
            Avance
            <input type="text" class="form-control" v-model="delivery.advance">
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            deliveries: Array
        }
    }
</script>