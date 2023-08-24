<template>
    <tr>
        <td><input type="date" v-model="payment.date" class="form-control"></td>
        <td>S/.{{ payment.amount }}</td>
        <td><input type="number" @keyup="calcAmount" v-model="payment.percentage" class="form-control"></td>
        <td><button @click="deletePayment(index)" class="btn btn-danger btn-icon"><i class="bx bx-x"></i></button>
        </td>
    </tr>
</template>
<script>
export default {
    props: {
        payment: Object,
        finalPrice: Number
    },
    methods: {
        deletePayment(index) {
            this.$emit('deletePayment', index)
        },
        calcAmount() {
            this.payment.amount = (this.finalPrice * this.payment.percentage / 100).toFixed(1)
        }
    }
}
</script>
<style></style>