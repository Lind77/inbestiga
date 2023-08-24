<template>
    <div class="card shadow-none bg-info text-white mb-3" v-if="customer.id">
        <div class="card-body">
            <h5 class="card-title text-white">Cliente: {{ customer.name }} <i @click="deleteCustomer(customer.id)"
                    class='bx bx-x'></i></h5>
            <p class="card-text mb-0">
                Teléfono: {{ customer.cell }}
            </p>
            <p class="card-text mb-0">
                Carrera: {{ customer.career }}
            </p>
            <p class="card-text mb-0">
                Universidad: {{ customer.university }}
            </p>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        customer: Object
    },
    methods: {
        deleteCustomer(customerId) {
            this.$emit('deleteCustomer', customerId)
        }
    }
}
</script>