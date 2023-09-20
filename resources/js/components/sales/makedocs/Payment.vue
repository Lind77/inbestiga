<template>
    <tr>
        <td><input type="date" v-model="payment.date" class="form-control"></td>
        <td><input type="number" @keyup="calcPercentage" v-model="payment.amount" class="form-control"></td>
        <td><input type="number" @keyup="calcByPercentage" v-model="payment.percentage" class="form-control">
            <!-- <input type="number" v-model="payment.percentage" class="form-control"> --></td>
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
        calcPercentage() {
            this.payment.percentage = (this.payment.amount / this.finalPrice * 100).toFixed(1)
        },
        calcByPercentage() {
            this.payment.amount = (this.finalPrice * this.payment.percentage / 100).toFixed(1)
        }
    }
}
</script>
<style></style>