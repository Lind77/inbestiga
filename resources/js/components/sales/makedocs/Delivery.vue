<template>
    <tr>
        <td><input type="date" v-model="delivery.date" class="form-control"></td>
        <td><input type="text" v-model="delivery.advance" class="form-control"></td>
        <td><button @click="deleteDelivery(index)" class="btn btn-danger btn-icon"><i class="bx bx-x"></i></button>
        </td>
    </tr>
</template>
<script>
export default {
    props: {
        delivery: Object,
        index: Number
    },
    methods: {
        deleteDelivery(index) {
            this.$emit('deleteDelivery', index)
        },
    }
}
</script>
<style scoped></style>