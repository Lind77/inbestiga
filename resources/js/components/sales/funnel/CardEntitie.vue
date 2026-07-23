<template>
    <div
        class="cardSpace mb-2.5"
        draggable="true"
        @dragover.prevent
        @drop.stop.prevent
        @dragstart="drag"
        :id="`${entitie.id}`"
    >
        <div
            class="card card-deal-item p-3 cursor-pointer"
            :id="`card${entitie.id}`"
            @click="$emit('openOverlay', entitie)"
        >
            <!-- Card Header: Title & Company/Subtitle -->
            <div class="mb-2">
                <h6 class="fw-bold text-title-custom mb-1 text-truncate" style="font-size: 0.95rem;">
                    {{ entitieTitle }}
                </h6>
                <small class="text-muted-custom font-size-xs d-block text-truncate">
                    {{ entitieSubtitle }}
                </small>
            </div>

            <!-- Card Footer Row: Money Badge, Icons & User Avatar (Matches Image!) -->
            <div class="d-flex align-items-center justify-content-between pt-2 border-top-subtle">
                <div class="d-flex align-items-center gap-2">
                    <!-- Money Badge -->
                    <span class="badge bg-label-primary font-bold px-2 py-1 fs-8">
                        <i class="bx bx-dollar me-0.5"></i> S/ {{ formatMoney(entitieAmount) }}
                    </span>

                    <!-- Quick Icon Badges -->
                    <span class="badge bg-label-secondary px-1.5 py-1 text-muted-custom" title="Documentos">
                        <i class="bx bx-notepad fs-7"></i>
                    </span>
                    <span v-if="status === 1" class="badge bg-label-warning px-1.5 py-1 text-warning" title="Lead Activo">
                        <i class="bx bx-error-circle fs-7"></i>
                    </span>
                </div>

                <!-- User Avatar / Initial -->
                <div class="avatar avatar-xs" :title="ownerName">
                    <span class="avatar-initial rounded-circle bg-label-primary font-bold fs-9">
                        {{ ownerInitials }}
                    </span>
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
    computed: {
        entitieTitle() {
            if (!this.entitie) return 'Oportunidad';
            if (this.entitie.name) return this.entitie.name;
            if (this.entitie.customers && this.entitie.customers.length > 0) {
                return this.entitie.customers[0].name;
            }
            if (this.entitie.quotation && this.entitie.quotation.customers && this.entitie.quotation.customers.length > 0) {
                return this.entitie.quotation.customers[0].name;
            }
            return `Cotización #${this.entitie.id}`;
        },
        entitieSubtitle() {
            if (!this.entitie) return 'Inbestiga LLC';
            if (this.entitie.cell) return `Tel: ${this.entitie.cell}`;
            if (this.entitie.university) return this.entitie.university;
            if (this.entitie.customers && this.entitie.customers[0]) {
                return this.entitie.customers[0].university || `Cotización #${this.entitie.id}`;
            }
            if (this.entitie.quotation) return `Contrato / Orden #${this.entitie.id}`;
            return 'Inbestiga LLC';
        },
        entitieAmount() {
            if (!this.entitie) return 250;
            if (this.entitie.amount) return parseFloat(this.entitie.amount);
            if (this.entitie.quotation && this.entitie.quotation.amount) {
                return parseFloat(this.entitie.quotation.amount);
            }
            return 250;
        },
        ownerName() {
            if (!this.entitie) return 'Asesor';
            if (this.entitie.user) return this.entitie.user.name;
            if (this.entitie.customers && this.entitie.customers[0] && this.entitie.customers[0].user) {
                return this.entitie.customers[0].user.name;
            }
            return 'Ventas';
        },
        ownerInitials() {
            const name = this.ownerName;
            if (!name) return 'AG';
            const parts = name.split(' ');
            if (parts.length >= 2) return (parts[0][0] + parts[1][0]).toUpperCase();
            return name.substring(0, 2).toUpperCase();
        }
    },
    methods: {
        formatMoney(val) {
            if (!val || isNaN(val)) return '250';
            return parseFloat(val).toLocaleString('es-PE', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
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
            if (this.entitie.quotation) {
                e.dataTransfer.setData("quotationId", this.entitie.id);
                e.dataTransfer.setData("type", 2);
            } else {
                e.dataTransfer.setData("customerId", this.entitie.id);
                e.dataTransfer.setData("type", 1);
            }
        }
    },
};
</script>

<style scoped>
.cardSpace {
    transition: transform 0.2s ease;
}

.card-deal-item {
    border-radius: 12px !important;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

/* Light Mode Card Styling */
:deep(body.light-mode) .card-deal-item,
body.light-mode .card-deal-item {
    background: #FFFFFF !important;
    border: 1px solid #E2E8F0 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
}

:deep(body.light-mode) .card-deal-item:hover,
body.light-mode .card-deal-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
    border-color: #CBD5E1 !important;
}

:deep(body.light-mode) .text-title-custom,
body.light-mode .text-title-custom {
    color: #0F172A !important;
}

:deep(body.light-mode) .text-muted-custom,
body.light-mode .text-muted-custom {
    color: #64748B !important;
}

:deep(body.light-mode) .border-top-subtle,
body.light-mode .border-top-subtle {
    border-top: 1px solid #F1F5F9 !important;
}

/* Dark Mode Card Styling */
body.dark-mode .card-deal-item,
.card-deal-item {
    background: #222222 !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}

body.dark-mode .card-deal-item:hover,
.card-deal-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25) !important;
    border-color: rgba(255, 255, 255, 0.18) !important;
}

body.dark-mode .text-title-custom,
.text-title-custom {
    color: #FFFFFF !important;
}

body.dark-mode .text-muted-custom,
.text-muted-custom {
    color: #94A3B8 !important;
}

body.dark-mode .border-top-subtle,
.border-top-subtle {
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}

.fs-7 { font-size: 0.78rem; }
.fs-8 { font-size: 0.72rem; }
.fs-9 { font-size: 0.65rem; }
.font-size-xs { font-size: 0.78rem; }

.space {
    height: 6px;
    border-radius: 3px;
    background-color: transparent;
    transition: background-color 0.2s;
}

.space-show {
    background-color: rgba(29, 94, 255, 0.4) !important;
}
</style>
