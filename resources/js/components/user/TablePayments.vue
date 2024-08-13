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
            {{
                project
            }}
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
</style>
