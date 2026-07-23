<template>
    <div class="kanban-column-wrapper">
        <div class="kanban-column p-3 rounded-3">
            <!-- Header section matching reference image -->
            <div class="kanban-header mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="d-flex align-items-center">
                        <span :class="'status-dot me-2 bg-' + getStatusColor(status)"></span>
                        <h5 class="fw-bold mb-0 text-title-custom" style="font-size: 1.05rem;">
                            {{ title }}
                        </h5>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button v-if="stage" class="btn btn-icon btn-sm text-muted-custom" @click="$emit('editStage', stage)" title="Editar Columna">
                            <i class="bx bx-pencil" style="font-size: 0.9rem;"></i>
                        </button>
                        <button v-if="stage && !stage.is_system" class="btn btn-icon btn-sm text-danger" @click="$emit('deleteStage', stage)" title="Eliminar Columna">
                            <i class="bx bx-trash" style="font-size: 0.9rem;"></i>
                        </button>
                    </div>
                </div>

                <!-- Column Summary Subheader: Total Money & Count -->
                <div class="d-flex align-items-center gap-2 font-size-xs text-muted-custom ps-3">
                    <span class="fw-semibold text-primary">S/ {{ columnTotalAmount }}</span>
                    <span>•</span>
                    <span>{{ (entities || []).length }} elementos</span>
                </div>
            </div>
            
            <!-- Cards scrollable area -->
            <div
                :id="'draggableArea' + status"
                class="container-cards overflow-auto flex-grow-1 pe-1"
                @drop="drop"
                @dragenter.prevent
                @dragover.prevent
                style="min-height: 250px; max-height: calc(100vh - 280px);"
            >
                <template v-if="entities && entities.length != 0">
                    <template v-for="(entitie, index) in entities" :key="index">
                        <CardEntitie
                            :entitie="entitie"
                            :status="status"
                            @showModalUpdateData="showModalUpdateData"
                            @updateInBd="updateInBd"
                            @openOverlay="$emit('openOverlay', $event, status)"
                        />
                    </template>
                </template>
                <div v-else class="text-center py-5 text-muted-custom">
                    <i class="bx bx-folder-open fs-2 mb-2 d-block"></i>
                    <span>Sin elementos</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UpdateCom from "../prelead/UpdateCom.vue";
import CardCustomer from "../prelead/CardCustomer.vue";
import CardQuotation from "./CardQuotation.vue";
import CardEntitie from "./CardEntitie.vue";

export default {
    components: { CardCustomer, UpdateCom, CardQuotation, CardEntitie },
    data() {
        return {
            visible: false,
            comunication: {},
            customer: {},
        };
    },
    props: {
        title: String,
        bg: String,
        status: Number,
        entities: Array,
        stage: Object
    },
    computed: {
        columnTotalAmount() {
            if (!this.entities || this.entities.length === 0) return '0.00';
            const sum = this.entities.reduce((acc, ent) => {
                const amt = ent.amount ? parseFloat(ent.amount) : (ent.quotation ? parseFloat(ent.quotation.amount) : 250);
                return acc + amt;
            }, 0);
            return parseFloat(sum).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    },
    methods: {
        getStatusColor(status) {
            return {
                1: 'warning',
                2: 'info',
                3: 'success',
                4: 'primary'
            }[status] || 'primary';
        },
        updateInBd(quotationId, status) {
            this.$parent.updateInBd(quotationId, status);
            if (status == 11) {
                var entitieSelected = (this.entities || []).findIndex(
                    (entitie) => entitie.quotation_id == quotationId
                );
                if (entitieSelected !== -1) {
                    this.entities.splice(entitieSelected, 1);
                }
            }
        },
        getCustomers() {
            this.$emit("getAllCustomers");
        },
        updateStatusPrelead(customerId) {
            this.$emit("updateStatusPrelead", customerId, this.status);
        },
        transformLead(customerId) {
            this.$router.push({
                name: "home-quotation",
                params: { idCustomer: customerId },
            });
        },
        showModalFunnelCustomer(customer) {
            this.$emit("showModalFunnelCustomer", customer);
        },
        showModalQuotationFunnel(quotation) {
            this.$emit("showModalQuotationFunnel", quotation);
        },
        cleanLead(id) {
            var leadSelected = (this.customers || []).find(
                (customer) => customer.id == id
            );
            if (leadSelected) leadSelected.status = 3;
        },
        convertLead(id) {
            this.$emit("convertLead", id);
        },
        showModalUpdateCom(com) {
            this.$emit("callModal", com);
        },
        showModalUpdateData(customer) {
            this.$emit("showModalUpdateData", customer);
        },
        hide(e) {
            e.preventDefault();
            e.target.classList.remove("pt-20");
        },
        allowDrop(e) {
            e.preventDefault();
            e.target.classList.add("bg-hover");
        },
        drop(e) {
            e.preventDefault();
            var quotation = e.dataTransfer.getData("quot");
            var customer = e.dataTransfer.getData("customerId");
            var quotationId = e.dataTransfer.getData("quotationId");
            if (this.status == 5) {
                this.$emit("transformQuotation", customer);
            } else {
                if (customer) {
                    this.$emit("updateStatusSpace", customer, this.status);
                } else {
                    this.$emit("updateStatusSpace", quotationId, this.status);
                }
            }
        },
        updateStatusSpace(quotationId) {
            this.$emit("updateStatusSpace", quotationId, this.status);
        },
        updateStatus(id) {
            axios
                .get(`/api/updateCustomerGrade/${id}/${this.status}`)
                .then((res) => {
                    console.log(res.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        setProject(id) {
            const fd = new FormData();
            fd.append("id_customer", id);
            fd.append("emisor_id", this.store.authUser[0].id);
            axios
                .post(`/api/setProject`, fd)
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    this.$swal(err.response.data.msg);
                });
        },
    },
};
</script>

<style scoped>
.kanban-column-wrapper {
    min-width: 320px;
    flex: 1 1 0;
    margin-bottom: 1.5rem;
}

.kanban-column {
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.25s ease;
}

/* Light Mode Styles */
:deep(body.light-mode) .kanban-column,
body.light-mode .kanban-column {
    background: #F1F5F9 !important;
    border: 1px solid #E2E8F0 !important;
}

:deep(body.light-mode) .text-title-custom,
body.light-mode .text-title-custom {
    color: #0F172A !important;
}

:deep(body.light-mode) .text-muted-custom,
body.light-mode .text-muted-custom {
    color: #64748B !important;
}

/* Dark Mode Styles */
body.dark-mode .kanban-column,
.kanban-column {
    background: rgba(255, 255, 255, 0.02) !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
}

body.dark-mode .text-title-custom,
.text-title-custom {
    color: #FFFFFF !important;
}

body.dark-mode .text-muted-custom,
.text-muted-custom {
    color: rgba(255, 255, 255, 0.3) !important;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.btn-icon {
    width: 26px;
    height: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border-radius: 4px;
}

.font-size-xs {
    font-size: 0.78rem;
}

/* Custom internal scrollbars for cards area */
.container-cards::-webkit-scrollbar {
    width: 4px;
}
.container-cards::-webkit-scrollbar-track {
    background: transparent;
}
.container-cards::-webkit-scrollbar-thumb {
    background: rgba(150, 150, 150, 0.2);
    border-radius: 10px;
}
.container-cards::-webkit-scrollbar-thumb:hover {
    background: rgba(150, 150, 150, 0.4);
}
</style>
