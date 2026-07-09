<template>
    <div
        class="cardSpace"
        draggable="true"
        @dragover.prevent
        @drop.stop.prevent
        @dragstart="drag"
        :id="`${entitie.id}`"
    >
        <div
            :class="`card p-3 cursor-pointer bg-${bgByStatus[entitieStatus]} text-white mb-2`"
            :id="`card${entitie.id}`"
        >
            <div class="d-flex align-items-start">
                <!-- Icon badge indicator -->
                <div class="me-3">
                    <span
                        :class="`badge-icon bg-label-${bgByStatus[entitieStatus]}`"
                    >
                        <i :class="`bx bx-${iconByStatus[entitieStatus]} text-${bgByStatus[entitieStatus]}`"></i>
                    </span>
                </div>
                
                <!-- Information and Actions -->
                <div class="d-flex flex-column flex-grow-1">
                    <!-- Case 1: Standard Customer Entity (Status = 1) -->
                    <template v-if="entitie && status == 1">
                        <h6 class="mb-1 fw-bold text-white text-wrap" style="font-size: 0.95rem; line-height: 1.3;">
                            {{ entitie.name }}
                        </h6>
                        <small class="text-muted-light mb-2">{{ entitie.cell }}</small>
                        <div class="d-flex gap-2 mt-1">
                            <button
                                class="btn btn-icon btn-sm btn-primary rounded-circle shadow-sm"
                                @click="showModalUpdateData(entitie)"
                                title="Editar Datos"
                            >
                                <i class="bx bx-edit" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                class="btn btn-icon btn-sm btn-danger rounded-circle shadow-sm"
                                v-if="entitieStatus == 1"
                                @click="noConnect(entitie)"
                                title="No Atendido / Sin Contacto"
                            >
                                <i class="bx bx-user-x" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                class="btn btn-icon btn-sm btn-success rounded-circle shadow-sm"
                                @click="toQuotation(entitie)"
                                title="Generar Cotización"
                            >
                                <i class="bx bx-file" style="font-size: 0.85rem;"></i>
                            </button>
                        </div>
                    </template>

                    <!-- Case 2: Customer list in Quotations (Status = 2) -->
                    <template v-if="entitie.customers">
                        <h6
                            class="mb-1 fw-bold text-white text-wrap"
                            v-for="customer in entitie.customers"
                            :key="customer.id"
                            :title="customer.name"
                            style="font-size: 0.95rem; line-height: 1.3;"
                        >
                            {{ customer.name }}
                        </h6>
                        <small class="text-muted-light mb-2">Cotización #{{ entitie.id }}</small>
                        <div class="d-flex gap-2 mt-1">
                            <button
                                class="btn btn-icon btn-sm btn-primary rounded-circle shadow-sm"
                                @click="editQuotation(entitie)"
                                title="Editar Cotización"
                            >
                                <i class="bx bx-edit" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                class="btn btn-icon btn-sm btn-danger rounded-circle shadow-sm"
                                @click="deleteQuotation(entitie)"
                                title="Eliminar Cotización"
                            >
                                <i class="bx bx-trash" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                class="btn btn-icon btn-sm btn-success rounded-circle shadow-sm"
                                @click="toOrder(entitie)"
                                title="Pasar a Orden de Trabajo"
                            >
                                <i class="bx bx-file" style="font-size: 0.85rem;"></i>
                            </button>
                        </div>
                    </template>

                    <!-- Case 3: Customer list in Contracts (Status = 3) -->
                    <template v-if="entitie.quotation">
                        <h6
                            class="mb-1 fw-bold text-white text-wrap"
                            v-for="customer in entitie.quotation.customers"
                            :key="customer.id"
                            :title="customer.name"
                            style="font-size: 0.95rem; line-height: 1.3;"
                        >
                            {{ customer.name }}
                        </h6>
                        <small class="text-muted-light mb-2">Contrato / Orden #{{ entitie.id }}</small>
                        <div class="d-flex gap-2 mt-1">
                            <button
                                class="btn btn-icon btn-sm btn-info rounded-circle shadow-sm"
                                @click="toOrder(entitie.quotation)"
                                title="Ver Orden"
                            >
                                <i class="bx bx-edit" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                class="btn btn-icon btn-sm btn-danger rounded-circle shadow-sm"
                                @click="deleteContract(entitie)"
                                title="Eliminar Contrato"
                            >
                                <i class="bx bx-trash" style="font-size: 0.85rem;"></i>
                            </button>
                            <button
                                v-if="status == 3"
                                class="btn btn-icon btn-sm btn-success rounded-circle shadow-sm"
                                @click="assendContract(entitie.quotation)"
                                title="Ascender a Cliente Fijo"
                            >
                                <i class="bx bx-user-check" style="font-size: 0.85rem;"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- Droppable spacing indicator -->
        <div
            class="space py-1"
            :id="'space' + entitie.id"
            @dragover="changeColor(entitie.id)"
            @dragleave="removeColor(entitie.id)"
            @drop="dropSpace"
        ></div>
    </div>
</template>

<script>
export default {
    props: {
        entitie: Object,
        status: Number,
    },
    data() {
        return {
            bgByStatus: {
                0: "danger",
                1: "warning",
                2: "info",
                3: "primary",
                4: "success",
            },
            iconByStatus: {
                0: "user",
                1: "user",
                2: "file",
                3: "pen",
                4: "money",
            },
            entitieStatus: this.status,
        };
    },
    methods: {
        assendContract(quotation) {
            if (
                confirm(
                    "¿Tienes la seguridad de convertir a este lead en cliente?"
                )
            ) {
                this.$emit("updateInBd", quotation.id, 11);
            }
        },
        dropSpace(e) {
            var customerId = e.dataTransfer.getData("customerId");
            e.dataTransfer.setData("quotationId", this.entitie.id);
            if (this.status == 1) {
                this.$router.push({
                    name: "home-docs",
                    params: { customerId: customerId },
                });
            } else {
                this.$router.push({
                    name: "contract-orders",
                    params: { quotationId: customerId },
                });
            }
        },
        showModalUpdateData(customer) {
            this.$emit("showModalUpdateData", customer);
        },
        editQuotation(quotation) {
            this.$router.push({
                name: "home-docs",
                params: { customerId: quotation.customer_id },
            });
        },
        deleteQuotation(quotation) {
            if (confirm("Tienes la seguridad de eliminar esta cotización?")) {
                axios
                    .delete("/api/quotations/" + quotation.id)
                    .then((result) => {
                        this.$swal("Cotización eliminada correctamente");
                        this.$parent.getCustomers();
                    })
                    .catch((err) => {
                        this.$swal("Hubo un error");
                    });
            }
        },
        deleteContract(contract) {
            if (confirm("Tienes la seguridad de eliminar este contrato?")) {
                axios
                    .delete("/api/contracts/" + contract.id)
                    .then((result) => {
                        this.$swal("Contrato eliminado correctamente");
                        this.$parent.getCustomers();
                    })
                    .catch((err) => {
                        this.$swal("Hubo un error");
                    });
            }
        },
        changeColor(index) {
            var spaceSelected = document.getElementById("space" + index);
            if (spaceSelected) {
                spaceSelected.classList.add("space-show");
            }
        },
        removeColor(index) {
            var spaceSelected = document.getElementById("space" + index);
            if (spaceSelected) {
                spaceSelected.classList.remove("space-show");
            }
        },
        drag(e) {
            if (this.quotation) {
                e.dataTransfer.setData("quotationId", this.entitie.id);
                e.dataTransfer.setData("type", 2);
            } else {
                e.dataTransfer.setData("customerId", this.entitie.id);
                e.dataTransfer.setData("type", 1);
            }
        },
        toOrder(quotation) {
            $("#funnelModal").modal("hide");
            this.$router.push({
                name: "contract-orders",
                params: { quotationId: quotation.id },
            });
        },
        toQuotation(customer) {
            this.$router.push({
                name: "home-docs",
                params: { customerId: customer.id },
            });
        },
    },
};
</script>

<style scoped>
.cardSpace {
    transition: transform 0.2s ease;
}

.cardSpace .card {
    background: rgba(24, 24, 35, 0.55) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-left: 4px solid #1D5EFF !important; /* fallback default */
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    border-radius: 8px !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
}

.cardSpace .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25) !important;
    border-color: rgba(255, 255, 255, 0.18) !important;
}

/* Status Left Border Colors */
.cardSpace .card.bg-warning {
    border-left: 4px solid #ff9f43 !important;
}
.cardSpace .card.bg-info {
    border-left: 4px solid #00cfe8 !important;
}
.cardSpace .card.bg-success {
    border-left: 4px solid #13b584 !important;
}
.cardSpace .card.bg-primary {
    border-left: 4px solid #1D5EFF !important;
}
.cardSpace .card.bg-danger {
    border-left: 4px solid #ea5455 !important;
}

/* Badge Icon styles */
.badge-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background-color: rgba(255, 255, 255, 0.05) !important;
    transition: background-color 0.2s;
}
.cardSpace .card:hover .badge-icon {
    background-color: rgba(255, 255, 255, 0.1) !important;
}
.badge-icon i {
    font-size: 1.15rem;
}

.text-muted-light {
    color: rgba(255, 255, 255, 0.5) !important;
    font-size: 0.78rem;
}

.space {
    height: 8px;
    border-radius: 4px;
    background-color: transparent;
    transition: background-color 0.2s;
}

.space-show {
    background-color: rgba(29, 94, 255, 0.4) !important;
}

.bg-hover {
    background-color: rgba(29, 94, 255, 0.2) !important;
}

.btn-icon {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}
</style>
