<template lang="">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Post venta</h4>
        <div class="card pt-2">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Contrato</th>
                            <th>Postventa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="postsale in postSales">
                            <td>
                                <p class="fw-bold">{{ postsale.name }}</p>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            postSales: [],
        };
    },
    methods: {
        getPostSale() {
            axios
                .get("/api/post-sales")
                .then((result) => {
                    this.postSales = result.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getPostSale();
    },
};
</script>
