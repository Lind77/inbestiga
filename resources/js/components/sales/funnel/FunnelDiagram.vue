<template>
    <div class="funnel-analytics-container mb-4">
        <!-- Top Row: Funnel Diagram & Retention Metrics -->
        <div class="row g-3 mb-3">
            <!-- Main Funnel Diagram Card -->
            <div class="col-12 col-xl-8">
                <div class="card analytics-card h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1 card-title-custom">Funnel de Ventas</h5>
                            <small class="text-muted-custom">Embudo de conversión en tiempo real</small>
                        </div>
                        <div class="d-flex align-items-center gap-1 badge bg-label-success px-3 py-1.5 rounded-pill fs-7">
                            <i class="bx bx-trending-up"></i>
                            <span>Tasa Global: <strong>{{ overallConversion }}%</strong></span>
                        </div>
                    </div>

                    <!-- Horizontal Funnel Stages Header -->
                    <div class="funnel-steps-header row text-center mb-2">
                        <!-- Step 1: Usuarios / Leads -->
                        <div class="col funnel-step-col">
                            <div class="step-label mb-1">
                                <span class="step-dot bg-warning me-1"></span>
                                <span class="fw-semibold">Usuarios</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-title-custom">{{ totalCustomers }}</h4>
                            <small class="text-muted-custom">Total Registrados</small>
                        </div>

                        <!-- Step 2: Cotizaciones -->
                        <div class="col funnel-step-col">
                            <div class="step-label mb-1">
                                <span class="step-dot bg-info me-1"></span>
                                <span class="fw-semibold">Cotizaciones</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-title-custom">{{ totalQuotations }}</h4>
                            <small class="text-success-custom fw-semibold">
                                <i class="bx bx-up-arrow-alt"></i> {{ quoteConversionRate }}% conv.
                            </small>
                        </div>

                        <!-- Step 3: Contratos / Ordenes -->
                        <div class="col funnel-step-col">
                            <div class="step-label mb-1">
                                <span class="step-dot bg-success me-1"></span>
                                <span class="fw-semibold">Contratos</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-title-custom">{{ totalContracts }}</h4>
                            <small class="text-success-custom fw-semibold">
                                <i class="bx bx-up-arrow-alt"></i> {{ contractConversionRate }}% conv.
                            </small>
                        </div>

                        <!-- Step 4: Proyectado Soles -->
                        <div class="col funnel-step-col">
                            <div class="step-label mb-1">
                                <span class="step-dot bg-primary me-1"></span>
                                <span class="fw-semibold">Monto Cotizado</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-primary">S/ {{ formatMoney(quotationsTotalAmount) }}</h4>
                            <small class="text-muted-custom">En Proceso</small>
                        </div>
                    </div>

                    <!-- SVG Graphic Trapezoid Funnel Diagram with Particle Dots -->
                    <div class="funnel-graphic-wrapper mt-2 position-relative">
                        <svg viewBox="0 0 800 160" class="w-100 h-auto overflow-visible" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="funnelGrad1" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#1D5EFF" stop-opacity="0.85" />
                                    <stop offset="100%" stop-color="#38BDF8" stop-opacity="0.6" />
                                </linearGradient>
                                <linearGradient id="funnelGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#EC4899" stop-opacity="0.75" />
                                    <stop offset="100%" stop-color="#F472B6" stop-opacity="0.5" />
                                </linearGradient>
                                <linearGradient id="funnelGrad3" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#F97316" stop-opacity="0.75" />
                                    <stop offset="100%" stop-color="#FB923C" stop-opacity="0.5" />
                                </linearGradient>
                                <linearGradient id="funnelGrad4" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#10B981" stop-opacity="0.85" />
                                    <stop offset="100%" stop-color="#34D399" stop-opacity="0.6" />
                                </linearGradient>
                            </defs>

                            <!-- Funnel Trapezoid Segment 1 -->
                            <polygon points="10,10 250,30 250,130 10,150" fill="url(#funnelGrad1)" />
                            <!-- Funnel Segment 2 -->
                            <polygon points="255,30 500,45 500,115 255,130" fill="url(#funnelGrad2)" />
                            <!-- Funnel Segment 3 -->
                            <polygon points="505,45 790,55 790,105 505,115" fill="url(#funnelGrad4)" />

                            <!-- Lead Particles in Segment 1 -->
                            <g fill="#FFFFFF" opacity="0.85">
                                <circle cx="40" cy="50" r="4.5" />
                                <circle cx="70" cy="90" r="3.5" />
                                <circle cx="90" cy="40" r="5" />
                                <circle cx="120" cy="110" r="4" />
                                <circle cx="140" cy="70" r="4.5" />
                                <circle cx="170" cy="95" r="3.5" />
                                <circle cx="200" cy="60" r="5" />
                                <circle cx="220" cy="105" r="4" />
                            </g>

                            <!-- Lead Particles in Segment 2 -->
                            <g fill="#FFFFFF" opacity="0.9">
                                <circle cx="280" cy="60" r="4.5" />
                                <circle cx="320" cy="90" r="4" />
                                <circle cx="360" cy="65" r="5" />
                                <circle cx="400" cy="85" r="4" />
                                <circle cx="440" cy="70" r="4.5" />
                                <circle cx="470" cy="90" r="3.5" />
                            </g>

                            <!-- Lead Particles in Segment 3 -->
                            <g fill="#FFFFFF" opacity="0.95">
                                <circle cx="540" cy="75" r="4.5" />
                                <circle cx="590" cy="85" r="4" />
                                <circle cx="640" cy="72" r="5" />
                                <circle cx="690" cy="88" r="4" />
                                <circle cx="740" cy="80" r="4.5" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Conversion & Retention Donut Metric Card -->
            <div class="col-12 col-xl-4">
                <div class="card analytics-card h-100 p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 card-title-custom">Tasa de Conversión</h6>
                            <span class="badge bg-label-info px-2 py-1 fs-8">Efectividad</span>
                        </div>

                        <!-- Donut Chart Center Graphic -->
                        <div class="donut-wrapper my-3 position-relative d-flex justify-content-center align-items-center">
                            <svg width="150" height="150" viewBox="0 0 100 100" class="donut-chart">
                                <circle cx="50" cy="50" r="40" stroke="rgba(29, 94, 255, 0.12)" stroke-width="12" fill="none" />
                                <circle cx="50" cy="50" r="40" stroke="#1D5EFF" stroke-width="12" fill="none"
                                        :stroke-dasharray="251.2"
                                        :stroke-dashoffset="251.2 - (251.2 * (overallConversion / 100))"
                                        stroke-linecap="round"
                                        transform="rotate(-90 50 50)" />
                            </svg>
                            <div class="donut-center-text text-center position-absolute">
                                <h3 class="fw-bold mb-0 text-title-custom">{{ overallConversion }}%</h3>
                                <small class="text-muted-custom">Cierre Total</small>
                            </div>
                        </div>
                    </div>

                    <!-- Metrics List -->
                    <div class="metrics-list border-top pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-1.5 font-size-sm">
                            <span class="d-flex align-items-center text-muted-custom">
                                <span class="legend-indicator bg-primary me-2"></span> Cotizados a Cierre
                            </span>
                            <strong class="text-title-custom">{{ contractConversionRate }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center font-size-sm">
                            <span class="d-flex align-items-center text-muted-custom">
                                <span class="legend-indicator bg-info me-2"></span> Leads a Cotizados
                            </span>
                            <strong class="text-title-custom">{{ quoteConversionRate }}%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Growth, Top Owners & Revenue Campaign -->
        <div class="row g-3">
            <!-- User Growth Ratio -->
            <div class="col-12 col-md-4">
                <div class="card analytics-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 card-title-custom">Crecimiento de Leads</h6>
                            <small class="text-success-custom fw-semibold"><i class="bx bx-up-arrow-alt"></i> Activo</small>
                        </div>
                        <div class="d-flex align-items-center gap-3 my-2">
                            <div class="mini-donut position-relative">
                                <svg width="85" height="85" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="38" stroke="rgba(56, 189, 248, 0.15)" stroke-width="12" fill="none" />
                                    <circle cx="50" cy="50" r="38" stroke="#38BDF8" stroke-width="12" fill="none"
                                            stroke-dasharray="238.7" stroke-dashoffset="50" stroke-linecap="round"
                                            transform="rotate(-90 50 50)" />
                                </svg>
                                <span class="mini-donut-text fw-bold text-title-custom">80%</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-title-custom">{{ totalCustomers }} Leads</h5>
                                <p class="mb-0 text-muted-custom font-size-sm">Captación continua en embudo de ventas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-top pt-2">
                        <small class="text-muted-custom d-block font-size-xs">
                            <i class="bx bx-info-circle text-primary me-1"></i> Optimización en tiempo real de leads asignados.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Top Sales Owners -->
            <div class="col-12 col-md-4">
                <div class="card analytics-card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 card-title-custom">Ejecutivos Destacados</h6>
                        <small class="text-primary font-semibold cursor-pointer">Ver todos</small>
                    </div>
                    <div class="owners-list d-flex flex-column gap-2">
                        <div v-for="(owner, idx) in topOwners" :key="idx" class="owner-item d-flex align-items-center justify-content-between p-2 rounded-2 border-subtle">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded-circle bg-label-primary font-semibold">{{ getInitials(owner.name) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-size-sm fw-bold text-title-custom">{{ owner.name }}</h6>
                                    <small class="text-muted-custom font-size-xs">{{ owner.count }} asignaciones</small>
                                </div>
                            </div>
                            <span class="badge bg-label-primary px-2 py-1 font-semibold">S/ {{ formatMoney(owner.totalAmount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Banner -->
            <div class="col-12 col-md-4">
                <div class="card analytics-card p-3 h-100 d-flex flex-column justify-content-between text-center bg-gradient-banner">
                    <div>
                        <div class="icon-circle bg-primary-subtle text-primary mx-auto mb-2">
                            <i class="bx bx-dollar-circle fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-1 text-title-custom">Proyección de Ingresos</h6>
                        <h3 class="fw-bold text-primary mb-2">S/ {{ formatMoney(contractsTotalAmount) }}</h3>
                        <p class="text-muted-custom font-size-sm mb-3">Monto total cerrado en contratos y ordenes vigentes.</p>
                    </div>
                    <button class="btn btn-primary btn-sm w-100 py-2 font-semibold shadow-sm" @click="$emit('filterDate', '')">
                        Ver Proyectos Activos
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        customers: { type: Array, default: () => [] },
        quotations: { type: Array, default: () => [] },
        contracts: { type: Array, default: () => [] },
        owners: { type: Array, default: () => [] },
        totalCustomersCount: { type: Number, default: null },
        totalQuotationsCount: { type: Number, default: null },
        totalContractsCount: { type: Number, default: null },
        totalQuotationsAmount: { type: Number, default: null },
        totalContractsAmount: { type: Number, default: null }
    },
    computed: {
        totalCustomers() {
            return (this.totalCustomersCount !== null && this.totalCustomersCount !== undefined)
                ? this.totalCustomersCount
                : this.customers.length;
        },
        totalQuotations() {
            return (this.totalQuotationsCount !== null && this.totalQuotationsCount !== undefined)
                ? this.totalQuotationsCount
                : this.quotations.length;
        },
        totalContracts() {
            return (this.totalContractsCount !== null && this.totalContractsCount !== undefined)
                ? this.totalContractsCount
                : this.contracts.length;
        },
        quotationsTotalAmount() {
            if (this.totalQuotationsAmount !== null && this.totalQuotationsAmount !== undefined && this.totalQuotationsAmount > 0) {
                return this.totalQuotationsAmount;
            }
            return this.quotations.reduce((acc, q) => acc + (parseFloat(q.amount) || 0), 0);
        },
        contractsTotalAmount() {
            if (this.totalContractsAmount !== null && this.totalContractsAmount !== undefined && this.totalContractsAmount > 0) {
                return this.totalContractsAmount;
            }
            return this.contracts.reduce((acc, c) => {
                const amt = c.quotation ? parseFloat(c.quotation.amount) : (parseFloat(c.amount) || 0);
                return acc + amt;
            }, 0);
        },
        overallConversion() {
            if (this.totalCustomers === 0) return 0;
            return ((this.totalContracts / this.totalCustomers) * 100).toFixed(1);
        },
        quoteConversionRate() {
            if (this.totalCustomers === 0) return 0;
            return ((this.totalQuotations / this.totalCustomers) * 100).toFixed(1);
        },
        contractConversionRate() {
            if (this.totalQuotations === 0) return 0;
            return ((this.totalContracts / this.totalQuotations) * 100).toFixed(1);
        },
        topOwners() {
            if (!this.owners || this.owners.length === 0) {
                return [
                    { name: 'Equipo de Ventas', count: this.totalCustomers, totalAmount: this.contractsTotalAmount }
                ];
            }

            // Map owners with counts
            const map = {};
            this.customers.forEach(c => {
                const ownerName = c.user ? c.user.name : 'Sin Asignar';
                if (!map[ownerName]) map[ownerName] = { name: ownerName, count: 0, totalAmount: 0 };
                map[ownerName].count++;
            });

            this.contracts.forEach(cnt => {
                const ownerName = (cnt.quotation && cnt.quotation.customers && cnt.quotation.customers[0] && cnt.quotation.customers[0].user) 
                    ? cnt.quotation.customers[0].user.name 
                    : (cnt.user ? cnt.user.name : 'Ventas');
                const amt = cnt.quotation ? parseFloat(cnt.quotation.amount) : 0;
                if (!map[ownerName]) map[ownerName] = { name: ownerName, count: 1, totalAmount: 0 };
                map[ownerName].totalAmount += amt;
            });

            return Object.values(map).sort((a, b) => b.totalAmount - a.totalAmount).slice(0, 3);
        }
    },
    methods: {
        formatMoney(val) {
            if (!val || isNaN(val)) return '0.00';
            return parseFloat(val).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        getInitials(name) {
            if (!name) return 'AG';
            const parts = name.split(' ');
            if (parts.length >= 2) return (parts[0][0] + parts[1][0]).toUpperCase();
            return name.substring(0, 2).toUpperCase();
        }
    }
}
</script>

<style scoped>
.analytics-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* Light Mode Styles */
:deep(body.light-mode) .analytics-card,
body.light-mode .analytics-card {
    background-color: #FFFFFF !important;
    border: 1px solid #E2E8F0 !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03) !important;
}

:deep(body.light-mode) .card-title-custom,
body.light-mode .card-title-custom {
    color: #0F172A !important;
}

:deep(body.light-mode) .text-title-custom,
body.light-mode .text-title-custom {
    color: #0F172A !important;
}

:deep(body.light-mode) .text-muted-custom,
body.light-mode .text-muted-custom {
    color: #64748B !important;
}

:deep(body.light-mode) .border-subtle,
body.light-mode .border-subtle {
    border: 1px solid #E2E8F0 !important;
    background-color: #F8FAFC !important;
}

/* Dark Mode Styles */
body.dark-mode .analytics-card,
.analytics-card {
    background-color: #222222 !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
}

body.dark-mode .card-title-custom,
.card-title-custom {
    color: #FFFFFF !important;
}

body.dark-mode .text-title-custom,
.text-title-custom {
    color: #FFFFFF !important;
}

body.dark-mode .text-muted-custom,
.text-muted-custom {
    color: #94A3B8 !important;
}

body.dark-mode .border-subtle,
.border-subtle {
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    background-color: rgba(255, 255, 255, 0.02) !important;
}

.step-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.donut-center-text h3 {
    font-size: 1.6rem;
}

.donut-center-text small {
    font-size: 0.7rem;
}

.legend-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 3px;
}

.font-size-sm { font-size: 0.82rem; }
.font-size-xs { font-size: 0.72rem; }

.mini-donut {
    display: flex;
    align-items: center;
    justify-content: center;
}

.mini-donut-text {
    position: absolute;
    font-size: 0.85rem;
}

.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.text-success-custom {
    color: #10B981 !important;
}
</style>
