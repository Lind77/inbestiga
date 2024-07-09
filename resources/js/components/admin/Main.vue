<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Admin de Sistema /</span> Inicio
        </h4>
        <h3>Bienvenido, Admind</h3>
        <h4>Cotizaciones de clientes entre 30 a 60 días</h4>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="quotation in quotations">
                    <td>
                        <p v-for="customer in quotation.customers">
                            {{ customer.name }}
                        </p>
                    </td>
                    <td>{{ quotation.date }}</td>
                    <td>{{ quotation.amount }}</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'quotation-file',
                                params: { id: quotation.id },
                            }"
                            target="_blank"
                            class="btn btn-sm btn-success text-white mx-1"
                            ><i class="bx bx-printer"></i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    data() {
        return {
            quotations: [],
        };
    },
    methods: {
        getQuotations() {
            axios
                .get("/api/filter-quotations")
                .then((result) => {
                    this.quotations = result.data.quotations.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getQuotations();
    },
};
</script>
