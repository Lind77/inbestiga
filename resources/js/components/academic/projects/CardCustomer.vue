<template>
<div class="card bg-warning text-white mb-3">
    <div class="card-header">Cliente</div>
    <div class="card-body">
        <h5 class="card-title text-white">{{ customer.name }}</h5>
        <p class="card-text">{{ customer.cell }} - {{ customer.career }}  {{ customer.university }}</p>
    </div>
</div>        
</template>
<script>
    export default{
        name:'CardCustomer',
        props:{
            customer: Object
        }
    }
</script>