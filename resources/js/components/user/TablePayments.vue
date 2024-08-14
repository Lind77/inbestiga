<template lang="">
    <table>
        <thead>
            <tr>
                <th>Cuentas</th>
                <th>Fecha</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="payment in project.payments">
                <td>S./ {{ payment.amount }}</td>
                <td>{{ payment.date }}</td>
                <td>{{ payment.status }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    props: {
        project: Array,
    },
};
</script>
<style scoped>
th {
    color: #fff;
    text-align: center;
}
td {
    color: #fff;
    text-align: center;
}
</style>
