<template>
    <div
        class="card tab-pane fade"
        id="navs-pills-top-messages"
        role="tabpanel"
    >
        <h5 class="card-header">Contratos</h5>
        <div class="col-6">
            <div class="input-group ps-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Nombre de cliente"
                    aria-label="Recipient's username"
                    v-model="searchWord"
                    @keyup.enter="searchContract"
                    aria-describedby="button-addon2"
                />
                <button
                    class="btn btn-outline-primary"
                    @click="searchContract"
                    type="button"
                    id="button-addon2"
                >
                    Buscar
                </button>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="contract in contracts">
                        <td>
                            <p
                                class="fw-bold"
                                v-for="customer in contract.quotation.customers"
                            >
                                {{ customer.name }}
                            </p>
                            <i
                                class="bx bx-star"
                                v-if="contract.quotation.status == 11"
                            ></i>
                        </td>
                        <td>{{ contract.date ? contract.date : "" }}</td>
                        <td>
                            <a
                                :href="`${appUrl}api/generateContract/${contract.id}`"
                                target="_blank"
                                class="btn btn-sm btn-primary mx-2 text-white"
                                disabled
                                ><i class="bx bx-printer"></i
                            ></a>
                            <button
                                class="btn btn-sm btn-warning mx-2"
                                @click="newDoc(contract.id)"
                            >
                                <i class="bx bx-printer"></i>
                            </button>
                            <button
                                class="btn btn-sm btn-danger"
                                @click="deleteContract(contract.id)"
                            >
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
            contracts: [],
            searchWord: "",
        };
    },
    methods: {
        searchContract() {
            axios
                .get(`/api/searchContracts/${this.searchWord}`)
                .then((res) => {
                    console.log(res);
                    this.contracts = res.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        newDoc(contractId) {
            this.$router.push({
                name: "contract-file",
                params: { contractId: contractId },
            });
        },
        deleteContract(contractId) {
            if (confirm("Estás seguro de eliminar este contrato?")) {
                axios
                    .delete("/api/contracts/" + contractId)
                    .then((res) => {
                        console.log(res);
                        this.getAllContracts();
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                    });
            }
        },
        getAllContracts() {
            axios
                .get("/api/contracts")
                .then((res) => {
                    console.log(res.data);
                    this.contracts = res.data.data;
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    mounted() {
        this.getAllContracts();
    },
};
</script>
<style scoped></style>
