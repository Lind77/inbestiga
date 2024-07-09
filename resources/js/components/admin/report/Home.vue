<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4>Cotizaciones de clientes entre 30 a 60 días</h4>
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex">
                <div class="mb-3">
                    <label for="">Desde</label>
                    <input
                        type="date"
                        class="form-control"
                        v-model="startDate"
                    />
                </div>
                <div class="mb-3">
                    <label for="">Hasta</label>
                    <input type="date" class="form-control" v-model="endDate" />
                </div>
            </div>
            <button class="btn btn-success h-25" @click="filterByDates">
                Buscar
            </button>
        </div>
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
                    <td>S./{{ quotation.amount }}</td>
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
            startDate: null,
            endDate: null,
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
        filterByDates() {
            const fd = new FormData();

            fd.append("startDate", this.startDate);
            fd.append("endDate", this.endDate);

            axios
                .post("/api/filter-dates", fd)
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
<style lang=""></style>
