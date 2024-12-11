<template></template>
<script>
import Chart from "./Chart.vue";

export default {
    components: { Chart },
    data() {
        return {
            customerSelected: {},
        };
    },
    props: {
        quotation: Object,
    },
    methods: {
        updateCustomer(customer) {
            this.$emit("updateCustomer", customer);
        },
        selectCustomer(customer) {
            this.customerSelected = customer;
        },
    },
    watch: {
        quotation(val) {
            this.customerSelected = this.quotation.customers[0];
        },
    },
};
</script>
<style lang=""></style>
