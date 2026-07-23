<template>
    <div>
        <!-- Backdrop Overlay -->
        <div
            v-if="isOpen"
            class="deal-overlay-backdrop"
            @click="close"
        ></div>

        <!-- Slide-over Right Drawer -->
        <div class="deal-overlay-drawer" :class="{ 'is-open': isOpen }">
            <template v-if="deal">
                <!-- Header -->
                <div class="drawer-header p-4 border-bottom d-flex justify-content-between align-items-start">
                    <div class="pe-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="fw-bold mb-0 text-title-custom">{{ dealName }}</h4>
                            <span class="badge bg-label-primary fs-7 font-bold px-2.5 py-1">
                                S/ {{ formatMoney(dealAmount) }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-muted-custom font-size-sm">
                            <span><i class="bx bx-building me-1"></i> {{ dealSubtext }}</span>
                            <span v-if="dealOwner"><i class="bx bx-user me-1"></i> {{ dealOwner }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close-custom" @click="close">
                        <i class="bx bx-x fs-3"></i>
                    </button>
                </div>

                <!-- Stage Progress Tracker Bar -->
                <div class="px-4 py-3 border-bottom bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-2 font-size-xs fw-semibold text-muted-custom">
                        <span>Etapa Actual: <strong class="text-primary">{{ currentStageName }}</strong></span>
                        <span><i class="bx bx-calendar me-1"></i> {{ currentDate }}</span>
                    </div>
                    <!-- Segmented Progress Bar -->
                    <div class="progress-segmented d-flex gap-1">
                        <div
                            v-for="step in [1, 2, 3, 4]"
                            :key="step"
                            class="progress-segment flex-grow-1"
                            :class="{ active: step <= currentStageStep }"
                        ></div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="px-4 border-bottom">
                    <div class="nav nav-tabs border-0 gap-3">
                        <button
                            class="nav-link-custom py-3 border-0 font-semibold"
                            :class="{ active: activeTab === 'overview' }"
                            @click="activeTab = 'overview'"
                        >
                            Resumen
                        </button>
                        <button
                            class="nav-link-custom py-3 border-0 font-semibold"
                            :class="{ active: activeTab === 'activity' }"
                            @click="activeTab = 'activity'"
                        >
                            Actividad
                        </button>
                        <button
                            class="nav-link-custom py-3 border-0 font-semibold"
                            :class="{ active: activeTab === 'actions' }"
                            @click="activeTab = 'actions'"
                        >
                            Acciones
                        </button>
                        <button
                            class="nav-link-custom py-3 border-0 font-semibold"
                            :class="{ active: activeTab === 'notes' }"
                            @click="activeTab = 'notes'"
                        >
                            Notas
                        </button>
                    </div>
                </div>

                <!-- Drawer Body Content -->
                <div class="drawer-body p-4 overflow-auto flex-grow-1">
                    <!-- TAB 1: Resumen (Overview) -->
                    <div v-if="activeTab === 'overview'">
                        <div class="card p-3 mb-3 border-subtle">
                            <h6 class="fw-bold mb-2 text-title-custom">Detalles del Cliente</h6>
                            <div class="row g-2 font-size-sm">
                                <div class="col-6">
                                    <span class="text-muted-custom d-block">Nombre:</span>
                                    <strong class="text-title-custom">{{ dealName }}</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted-custom d-block">Teléfono / WhatsApp:</span>
                                    <strong class="text-title-custom">{{ dealCell || 'Sin teléfono' }}</strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <span class="text-muted-custom d-block">Carrera / Especialidad:</span>
                                    <strong class="text-title-custom">{{ dealCareer || 'General' }}</strong>
                                </div>
                                <div class="col-6 mt-2">
                                    <span class="text-muted-custom d-block">Universidad / Institución:</span>
                                    <strong class="text-title-custom">{{ dealUniversity || 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="card p-3 border-subtle">
                            <h6 class="fw-bold mb-2 text-title-custom">Información Comercial</h6>
                            <div class="d-flex justify-content-between align-items-center font-size-sm">
                                <span class="text-muted-custom">Monto de Oportunidad:</span>
                                <strong class="text-primary fs-6">S/ {{ formatMoney(dealAmount) }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Actividad (Activity) -->
                    <div v-if="activeTab === 'activity'">
                        <div class="timeline p-2">
                            <div class="timeline-item d-flex gap-3 mb-3">
                                <div class="timeline-icon bg-label-primary rounded-circle p-2">
                                    <i class="bx bx-user-plus text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-size-sm fw-bold text-title-custom">Lead Registrado</h6>
                                    <small class="text-muted-custom">Ingresado al sistema en funnel de ventas</small>
                                </div>
                            </div>
                            <div class="timeline-item d-flex gap-3 mb-3" v-if="status >= 2">
                                <div class="timeline-icon bg-label-info rounded-circle p-2">
                                    <i class="bx bx-file text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-size-sm fw-bold text-title-custom">Cotización Generada</h6>
                                    <small class="text-muted-custom">Propuesta comercial enviada al cliente</small>
                                </div>
                            </div>
                            <div class="timeline-item d-flex gap-3" v-if="status >= 3">
                                <div class="timeline-icon bg-label-success rounded-circle p-2">
                                    <i class="bx bx-check-circle text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-size-sm fw-bold text-title-custom">Contrato Firmado</h6>
                                    <small class="text-muted-custom">Pasa a ejecución con orden de trabajo</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: Acciones (Actions - Matches User Image!) -->
                    <div v-if="activeTab === 'actions'" class="d-flex flex-column gap-3">
                        <!-- Action 1: Create Task -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('task')">
                            <div class="action-icon bg-label-primary rounded-3 p-2.5">
                                <i class="bx bx-list-check fs-4 text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Crear una Tarea</h6>
                                <small class="text-muted-custom">Programa una tarea asociada en tu calendario</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>

                        <!-- Action 2: Send Email -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('email')">
                            <div class="action-icon bg-label-info rounded-3 p-2.5">
                                <i class="bx bx-envelope fs-4 text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Enviar Correo Electrónico</h6>
                                <small class="text-muted-custom">Envía un mensaje personalizado a este contacto</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>

                        <!-- Action 3: Call / Voicemail -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('call')">
                            <div class="action-icon bg-label-success rounded-3 p-2.5">
                                <i class="bx bx-phone-call fs-4 text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Registrar Llamada / Mensaje de Voz</h6>
                                <small class="text-muted-custom">Registra la llamada o envía recordatorio de voz</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>

                        <!-- Action 4: Send SMS / WhatsApp -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('whatsapp')">
                            <div class="action-icon bg-label-warning rounded-3 p-2.5">
                                <i class="bx bxl-whatsapp fs-4 text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Enviar SMS / WhatsApp</h6>
                                <small class="text-muted-custom">Envía un mensaje rápido por WhatsApp a su celular</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>

                        <!-- Action 5: Send Invoice / Quotation -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('quotation')">
                            <div class="action-icon bg-label-secondary rounded-3 p-2.5">
                                <i class="bx bx-file fs-4 text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Generar Cotización</h6>
                                <small class="text-muted-custom">Crea automáticamente una cotización para esta oferta</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>

                        <!-- Action 6: Send Document / Contract -->
                        <div class="action-card p-3 rounded-3 border-subtle d-flex align-items-center gap-3 cursor-pointer" @click="handleAction('contract')">
                            <div class="action-icon bg-label-danger rounded-3 p-2.5">
                                <i class="bx bx-paperclip fs-4 text-danger"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-title-custom">Enviar Documento / Contrato</h6>
                                <small class="text-muted-custom">Selecciona un contrato o archivo para enviar al cliente</small>
                            </div>
                            <i class="bx bx-chevron-right text-muted-custom fs-4"></i>
                        </div>
                    </div>

                    <!-- TAB 4: Notas (Notes) -->
                    <div v-if="activeTab === 'notes'">
                        <div class="mb-3">
                            <textarea
                                v-model="newNote"
                                class="form-control form-control-custom p-3"
                                rows="3"
                                placeholder="Escribe una nota o observación sobre este cliente..."
                            ></textarea>
                            <button class="btn btn-primary btn-sm mt-2 font-semibold float-end" @click="addNote">
                                Guardar Nota
                            </button>
                        </div>
                        <div class="notes-list mt-5 pt-2">
                            <div v-for="(note, idx) in notes" :key="idx" class="card p-3 mb-2 border-subtle">
                                <p class="mb-1 font-size-sm text-title-custom">{{ note.text }}</p>
                                <small class="text-muted-custom font-size-xs">{{ note.date }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: { type: Boolean, default: false },
        deal: { type: Object, default: null },
        status: { type: Number, default: 1 }
    },
    data() {
        return {
            activeTab: 'actions',
            newNote: '',
            notes: [
                { text: 'Cliente solicita seguimiento sobre propuesta académica.', date: 'Hoy, 10:30 AM' }
            ]
        };
    },
    computed: {
        dealName() {
            if (!this.deal) return 'Detalle de Oportunidad';
            if (this.deal.name) return this.deal.name;
            if (this.deal.customers && this.deal.customers.length > 0) return this.deal.customers[0].name;
            if (this.deal.quotation && this.deal.quotation.customers && this.deal.quotation.customers.length > 0) {
                return this.deal.quotation.customers[0].name;
            }
            return `Oportunidad #${this.deal.id}`;
        },
        dealSubtext() {
            if (!this.deal) return 'Inbestiga SaaS';
            if (this.deal.cell) return `Teléfono: ${this.deal.cell}`;
            if (this.deal.career) return `Carrera: ${this.deal.career}`;
            return 'Inbestiga Corporate';
        },
        dealOwner() {
            if (!this.deal) return null;
            if (this.deal.user) return this.deal.user.name;
            if (this.deal.customers && this.deal.customers[0] && this.deal.customers[0].user) {
                return this.deal.customers[0].user.name;
            }
            return 'Asesor de Ventas';
        },
        dealCell() {
            if (!this.deal) return null;
            if (this.deal.cell) return this.deal.cell;
            if (this.deal.customers && this.deal.customers[0]) return this.deal.customers[0].cell;
            return null;
        },
        dealCareer() {
            if (!this.deal) return null;
            if (this.deal.career) return this.deal.career;
            if (this.deal.customers && this.deal.customers[0]) return this.deal.customers[0].career;
            return null;
        },
        dealUniversity() {
            if (!this.deal) return null;
            if (this.deal.university) return this.deal.university;
            if (this.deal.customers && this.deal.customers[0]) return this.deal.customers[0].university;
            return null;
        },
        dealAmount() {
            if (!this.deal) return 0;
            if (this.deal.amount) return parseFloat(this.deal.amount);
            if (this.deal.quotation && this.deal.quotation.amount) return parseFloat(this.deal.quotation.amount);
            return 250;
        },
        currentStageName() {
            return {
                1: 'Usuarios / Leads',
                2: 'Cotización Enviada',
                3: 'Contrato Aprobado',
                4: 'Cliente Fijo'
            }[this.status] || 'Lead Activo';
        },
        currentStageStep() {
            return this.status > 4 ? 4 : this.status;
        },
        currentDate() {
            return new Date().toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' });
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        formatMoney(val) {
            if (!val || isNaN(val)) return '0.00';
            return parseFloat(val).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        handleAction(actionType) {
            const actionsMap = {
                task: 'Crear Tarea: Redirigiendo a calendario...',
                email: 'Enviar Correo: Abriendo editor de correo...',
                call: 'Registrar Llamada: Iniciando llamada al cliente...',
                whatsapp: `WhatsApp: Abriendo chat con ${this.dealCell || 'cliente'}...`,
                quotation: 'Generar Cotización: Abriendo módulo de cotizaciones...',
                contract: 'Enviar Documento: Preparando documento de contrato...'
            };

            this.$swal({
                title: 'Conexión de Acción',
                text: actionsMap[actionType] || 'Procesando acción comercial...',
                icon: 'info',
                confirmButtonText: 'Entendido'
            });

            if (actionType === 'whatsapp' && this.dealCell) {
                const cleanNum = this.dealCell.replace(/\D/g, '');
                window.open(`https://wa.me/51${cleanNum}`, '_blank');
            } else if (actionType === 'quotation') {
                this.close();
                this.$router.push({ name: 'home-docs', params: { customerId: this.deal.id } });
            }
        },
        addNote() {
            if (!this.newNote.trim()) return;
            this.notes.unshift({
                text: this.newNote,
                date: 'Hace un momento'
            });
            this.newNote = '';
        }
    }
}
</script>

<style scoped>
/* Backdrop Overlay */
.deal-overlay-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(4px);
    z-index: 1050;
    transition: opacity 0.3s ease;
}

/* Slide-over Right Drawer */
.deal-overlay-drawer {
    position: fixed;
    top: 0;
    right: 0;
    width: 480px;
    max-width: 90vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    z-index: 1060;
    transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: -10px 0 30px rgba(0, 0, 0, 0.15);
}

.deal-overlay-drawer.is-open {
    transform: translateX(0);
}

/* Light Mode Drawer Styling */
:deep(body.light-mode) .deal-overlay-drawer,
body.light-mode .deal-overlay-drawer {
    background-color: #FFFFFF !important;
    border-left: 1px solid #E2E8F0 !important;
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
    background-color: #FFFFFF !important;
}

:deep(body.light-mode) .action-card,
body.light-mode .action-card {
    background-color: #FFFFFF !important;
    border: 1px solid #E2E8F0 !important;
    transition: all 0.2s ease !important;
}

:deep(body.light-mode) .action-card:hover,
body.light-mode .action-card:hover {
    border-color: #1D5EFF !important;
    box-shadow: 0 4px 14px rgba(29, 94, 255, 0.08) !important;
    transform: translateY(-1px);
}

/* Dark Mode Drawer Styling */
body.dark-mode .deal-overlay-drawer,
.deal-overlay-drawer {
    background-color: #1B1B22 !important;
    border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
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

body.dark-mode .action-card,
.action-card {
    background-color: rgba(255, 255, 255, 0.03) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    transition: all 0.2s ease !important;
}

body.dark-mode .action-card:hover,
.action-card:hover {
    border-color: #1D5EFF !important;
    background-color: rgba(29, 94, 255, 0.05) !important;
}

/* Progress Segmented Bar */
.progress-segmented {
    height: 6px;
    border-radius: 3px;
    overflow: hidden;
}

.progress-segment {
    background-color: #E2E8F0;
    border-radius: 2px;
    height: 100%;
    transition: background-color 0.3s ease;
}

.progress-segment.active {
    background-color: #10B981;
}

/* Navigation Tabs */
.nav-link-custom {
    color: #64748B;
    background: transparent;
    border-bottom: 2px solid transparent !important;
    transition: all 0.2s ease;
}

.nav-link-custom:hover {
    color: #1D5EFF;
}

.nav-link-custom.active {
    color: #1D5EFF !important;
    border-bottom: 2px solid #1D5EFF !important;
}

.btn-close-custom {
    border: none;
    background: transparent;
    color: #64748B;
    cursor: pointer;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.btn-close-custom:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #0F172A;
}

.form-control-custom {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 0.9rem;
}

.font-size-sm { font-size: 0.85rem; }
.font-size-xs { font-size: 0.75rem; }
</style>
