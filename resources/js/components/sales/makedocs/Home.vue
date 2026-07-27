<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header / Document Type Switcher Bar -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-md me-3 bg-label-primary rounded p-2 d-flex align-items-center justify-content-center">
                        <i class="bx fs-3" :class="documentType == 1 ? 'bx-file' : (documentType == 2 ? 'bx-cart' : 'bx-task')"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">{{ titleByType[documentType] || 'Gestor de Documentos' }}</h4>
                        <small class="text-muted">Cree y gestione cotizaciones, órdenes y contratos por paquete</small>
                    </div>
                </div>
                <div class="btn-group shadow-sm" role="group" aria-label="Tipo de documento">
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        :class="{ 'active fw-bold': documentType == 1 }"
                        @click="documentType = 1"
                    >
                        <i class="bx bx-file me-1"></i> Cotización
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        :class="{ 'active fw-bold': documentType == 2 }"
                        @click="documentType = 2"
                    >
                        <i class="bx bx-cart me-1"></i> Orden
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        :class="{ 'active fw-bold': documentType == 3 }"
                        @click="documentType = 3"
                    >
                        <i class="bx bx-task me-1"></i> Contrato
                    </button>
                </div>
            </div>
        </div>

        <div class="row invoice-add">
            <!-- Left Column: Customer & Details -->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <!-- Customer Selection Card -->
                <CustomersCard
                    :customers="customers"
                    :quotationId="$route.params.quotationId"
                    @openModalCustomerEdit="openModalCustomerEdit"
                    @deleteCustomer="deleteCustomer"
                />

                <!-- Details Section (Package Details) -->
                <div class="card invoice-preview-card mt-3 border shadow-none bg-body">
                    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-package text-primary me-2 fs-4"></i>
                            <h5 class="fw-bold mb-0 text-dark">Detalles del Paquete</h5>
                            <span class="badge bg-label-primary rounded-pill ms-3">
                                {{ details.length }} {{ details.length === 1 ? 'ítem' : 'ítems' }}
                            </span>
                        </div>
                        <button
                            type="button"
                            class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center"
                            @click="addDetail"
                        >
                            <i class="bx bx-plus me-1"></i> Agregar Producto
                        </button>
                    </div>

                    <div class="card-body p-4">
                        <div v-if="details.length === 0" class="text-center py-5 border border-dashed rounded-3 bg-light">
                            <i class="bx bx-package fs-1 text-muted mb-2"></i>
                            <h6 class="fw-bold text-secondary mb-1">No hay productos agregados al paquete</h6>
                            <p class="text-muted small mb-3">Haga clic en el botón "Agregar Producto" para añadir detalles a esta venta.</p>
                            <button type="button" class="btn btn-outline-primary btn-sm px-3" @click="addDetail">
                                <i class="bx bx-plus me-1"></i> Agregar primer producto
                            </button>
                        </div>
                        <div class="repeater-list" v-else>
                            <template v-for="(detail, index) in details" :key="index">
                                <Detail
                                    :detail="detail"
                                    :newProducts="newProducts"
                                    :index="index"
                                    @removeSuggestedCart="removeSuggestedCart"
                                />
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Deliveries Section (Contract Only) -->
                <div class="card invoice-preview-card mt-3 border shadow-none bg-body" v-if="documentType == 3">
                    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-time-five text-primary me-2 fs-4"></i>
                            <h5 class="fw-bold mb-0 text-dark">Entregas del Proyecto</h5>
                        </div>
                        <button
                            type="button"
                            class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center"
                            @click="addDelivery"
                        >
                            <i class="bx bx-plus me-1"></i> Agregar Entrega
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div v-if="deliveries.length === 0" class="text-center py-4 border border-dashed rounded-3 bg-light">
                            <p class="text-muted small mb-0">No hay entregas programadas. Haga clic en "Agregar Entrega".</p>
                        </div>
                        <div class="table-responsive" v-else>
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha Estimada</th>
                                        <th>Avance / Entregable</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(delivery, index) in deliveries" :key="index">
                                        <Delivery
                                            :delivery="delivery"
                                            :index="index"
                                            @deleteDelivery="deleteDelivery"
                                        />
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Document Actions & Summary -->
            <div class="col-lg-3 col-12 invoice-actions">
                <!-- Customer Needs Note (Quotation Mode) -->
                <div class="card bg-primary text-white mb-3 shadow-sm" v-if="documentType == 1 && customer && customer.needs">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-white mb-2 d-flex align-items-center">
                            <i class="bx bx-notepad me-1"></i> Necesidades del Cliente
                        </h6>
                        <p class="mb-0 small text-white-50">{{ customer.needs }}</p>
                    </div>
                </div>

                <!-- Document Form & Summary Card -->
                <div class="card border shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3 px-3">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                            <i class="bx bx-slider-alt me-2 text-primary"></i> Configuración del Documento
                        </h6>
                    </div>

                    <div class="card-body p-3">
                        <!-- Quotations Fields -->
                        <div v-if="documentType == 1">
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Fecha Emisión <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" v-model="quotation.date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Fecha de Validez <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" v-model="quotation.expiration_date" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Tiempo de Ejecución <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Ej. 15 días hábiles" v-model="quotation.term" />
                            </div>
                        </div>

                        <!-- Orders Fields -->
                        <div v-else-if="documentType == 2">
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Entrega Final <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Ej. Fecha límite de entrega" v-model="order.final_delivery" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Observaciones</label>
                                <textarea class="form-control" rows="2" placeholder="Observaciones adicionales..." v-model="order.observations"></textarea>
                            </div>
                        </div>

                        <!-- Contracts Fields -->
                        <div v-else-if="documentType == 3">
                            <div class="mb-3">
                                <label class="form-label fw-medium mb-1">Fecha de Contrato <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" v-model="contract.date" />
                            </div>
                            <div class="card bg-light p-2 mb-3 border">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="chk3rd" v-model="thirdArticle" />
                                    <label class="form-check-label small" for="chk3rd">3er art. (Instrumentos)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="chk3rdPlace" v-model="thirdArticlePlace" />
                                    <label class="form-check-label small" for="chk3rdPlace">3er art. (Lugar)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="chk5th" v-model="fifthArticle" />
                                    <label class="form-check-label small" for="chk5th">5to art. (Considerar Entrega)</label>
                                </div>
                                <div class="form-check mb-0">
                                    <input type="checkbox" class="form-check-input" id="chkFrag" v-model="fragmented" />
                                    <label class="form-check-label small" for="chkFrag">Fragmentado</label>
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Input -->
                        <div class="mb-3">
                            <label class="form-label fw-medium mb-1">Cupón de Descuento</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Código de cupón"
                                    v-model="coupon"
                                    @keyup.enter="autoDiscount"
                                />
                                <button class="btn btn-outline-secondary btn-sm" type="button" @click="autoDiscount">Aplicar</button>
                            </div>
                        </div>

                        <hr class="my-3" />

                        <!-- Price Breakdown -->
                        <div class="bg-light rounded-3 p-3 mb-3 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal Paquetes:</span>
                                <span class="fw-medium">S/ {{ totalProductsWithoutDiscount }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-danger" v-if="discount > 0 || quotation.discount > 0">
                                <span class="small">Descuento aplicado:</span>
                                <span class="fw-bold">- S/ {{ (documentType == 1 ? quotation.discount : discount) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="fw-bold text-dark">TOTAL FINAL:</span>
                                <span class="fw-bold fs-5 text-primary">S/ {{ finalPrice }}</span>
                            </div>
                        </div>

                        <!-- Main Action Buttons -->
                        <div class="d-grid gap-2">
                            <!-- Quotation Button -->
                            <button
                                v-if="documentType == 1"
                                @click="createQuotation"
                                class="btn btn-primary shadow-sm"
                            >
                                <i class="bx bx-paper-plane me-1"></i> Generar Cotización
                            </button>

                            <!-- Order Button -->
                            <button
                                v-if="documentType == 2"
                                @click="createOrder"
                                class="btn btn-primary shadow-sm"
                            >
                                <i class="bx bx-paper-plane me-1"></i> Generar Orden
                            </button>

                            <!-- Contract Button -->
                            <button
                                v-if="documentType == 3"
                                @click="createContract"
                                class="btn btn-primary shadow-sm"
                            >
                                <i class="bx bx-paper-plane me-1"></i> {{ contractExistent.length > 0 ? "Actualizar Contrato" : "Generar Contrato" }}
                            </button>

                            <!-- Generated Document Links -->
                            <router-link
                                v-if="quotationIdGenerated != 0"
                                :to="{ name: 'quotation-img', params: { id: quotationIdGenerated } }"
                                target="_blank"
                                class="btn btn-outline-primary"
                            >
                                <i class="bx bx-image me-1"></i> Ver Cotización
                            </router-link>

                            <router-link
                                v-if="orderId != 0 && documentType == 2"
                                :to="{ name: 'order-file', params: { id: orderId } }"
                                target="_blank"
                                class="btn btn-outline-info"
                            >
                                <i class="bx bx-cart me-1"></i> Ver Orden
                            </router-link>

                            <a
                                v-if="contractId != 0 && documentType == 3"
                                :href="`${appUrl}api/generateContract/${contractId}`"
                                target="_blank"
                                class="btn btn-outline-success"
                            >
                                <i class="bx bx-task me-1"></i> Ver Contrato PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <customerModal :action="action" :customer="customerSelected" />
</template>

<script>
import moment from "moment";
import conversor from "conversor-numero-a-letras-es-ar";
import CustomersCard from "./CustomersCard.vue";
import Customer from "./Customer.vue";
import Detail from "./Detail.vue";
import Delivery from "./Delivery.vue";
import customerModal from "../customers/customerModal.vue";
import { userStore } from "../../../stores/UserStore";
import axios from "axios";

export default {
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    components: {
        Customer,
        Detail,
        Delivery,
        customerModal,
        CustomersCard,
    },
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
            documentType: 1,
            titleByType: {
                1: "Nueva Cotización",
                2: "Nueva Orden",
                3: "Nuevo Contrato",
            },
            customer: {},
            customers: [],
            customerSelected: {},
            search: "",
            customersFound: [],
            details: [],
            newProducts: [],
            quotation: {
                id: 0,
                customer_id: 0,
                date: "",
                amount: 0,
                term: "",
                expiration_date: "",
                discount: 0,
                note: "",
            },
            order: {
                observations: "",
                final_delivery: "",
            },
            contract: {
                date: "",
            },
            quotationIdGenerated: 0,
            payments: [], // Arreglo vacío para compatibilidad con API
            quotationExistent: {},
            coupon: "",
            discount: 0,
            deliveries: [],
            thirdArticle: false,
            thirdArticlePlace: false,
            fifthArticle: false,
            fragmented: false,
            contractId: 0,
            orderId: 0,
            quotationsExistent: [],
            contractExistent: [],
            action: 1,
            ordersExistent: [],
        };
    },
    methods: {
        formatTime(time) {
            return moment(time).format("DD/MM/YYYY hh:mma");
        },
        addNewCustomer() {
            this.action = 1;
            $("#customerModal").modal("show");
        },
        deleteQuotaion(quotationId) {
            this.$swal
                .fire({
                    title: "¿Deseas eliminar esta cotización?",
                    showDenyButton: true,
                    confirmButtonText: "Sí",
                    denyButtonText: "No",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete("/api/quotations/" + quotationId)
                            .then(() => {
                                this.getCustomer();
                                this.documentType = 1;
                            })
                            .catch((err) => {
                                console.error(err);
                            });
                    }
                });
        },
        openModalCustomerEdit(customer) {
            this.action = 2;
            this.customerSelected = customer;
            $("#customerModal").modal("show");
        },
        pickContract(contract) {
            if (contract.projects && contract.projects[0]) {
                this.deliveries = contract.projects[0].deliveries || [];
            }
            this.thirdArticle = this.numberToBoolean(contract.third_article);
            this.fifthArticle = this.numberToBoolean(contract.fifth_article);
            this.thirdArticlePlace = this.numberToBoolean(contract.third_article_place);
            this.contract.date = contract.date;
        },
        pickQuotation(quotation) {
            this.quotation = quotation;
            this.quotationIdGenerated = quotation.id;
            this.details = quotation.details || [];
        },
        pickOrder(order) {
            this.order = order;
            this.orderId = order.id;
        },
        addDelivery() {
            var delivery = {
                date: null,
                advance: "",
            };
            this.deliveries.push({ ...delivery });
        },
        deleteDelivery(index) {
            this.deliveries.splice(index, 1);
        },
        getCustomer() {
            this.contractExistent = [];
            this.quotationExistent = [];

            axios
                .get("/api/getCustomer/" + this.$route.params.customerId)
                .then((res) => {
                    this.customer = res.data;
                    if (this.customer.quotations && this.customer.quotations[0]) {
                        this.quotationsExistent = this.customer.quotations;
                        this.quotationExistent = this.customer.quotations[0];

                        this.customer.quotations.forEach((quotation) => {
                            if (quotation.contract) {
                                this.contractExistent.push(quotation.contract);
                            } else if (quotation.order) {
                                this.ordersExistent.push(quotation.order);
                            }
                        });

                        this.customers = this.customer.quotations[0].customers || [];
                        this.details = this.quotationExistent.details || [];
                    } else {
                        this.customers.push(this.customer);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        searchCustomer() {
            axios
                .get(`/api/customers/search/${this.search}`)
                .then((res) => {
                    this.customersFound = res.data.customers;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        addCustomer(customer) {
            this.customers.push(customer);
            this.customersFound = [];
            this.search = "";
        },
        booleanToNumber(value) {
            return value ? 1 : 0;
        },
        numberToBoolean(value) {
            return value == 1 ? true : false;
        },
        deleteCustomer(customerId) {
            var customerSelected = this.customers.findIndex(
                (customer) => customer.id == customerId
            );
            if (customerSelected !== -1) {
                this.customers.splice(customerSelected, 1);
            }
        },
        dateFormatted(date) {
            return moment(date).fromNow();
        },
        addDetail() {
            this.details.push({
                type: 1,
                level: "",
                title: "",
                mode: "2", // Paquete siempre por defecto
                price: 0,
                extra_price: 0,
                product: { name: "" },
                product_id: "",
            });
        },
        removeSuggestedCart(index) {
            this.details.splice(index, 1);
        },
        getAllNewProducts() {
            axios
                .get("/api/getAllNewProducts")
                .then((res) => {
                    this.newProducts = res.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        createQuotation() {
            const fd = new FormData();

            fd.append("user_id", this.store.authUser.id);
            fd.append("customers", JSON.stringify(this.customers));
            fd.append("customer_id", this.customer.id);
            fd.append("date", this.quotation.date);
            fd.append("expiration_date", this.quotation.expiration_date);
            fd.append("amount", this.totalProductsWithoutDiscount);
            fd.append("discount", this.quotation.discount);
            fd.append("term", this.quotation.term);
            fd.append("products", JSON.stringify(this.details));
            fd.append("emisor_id", this.store.authUser.id);
            fd.append("coupon", this.coupon);
            fd.append("payments", JSON.stringify([]));

            axios
                .post("/api/quotations", fd)
                .then((res) => {
                    this.$swal("Cotización generada exitosamente");
                    this.quotationIdGenerated = res.data.id;
                    this.quotationExistent.id = res.data.id;

                    // Abrir automáticamente una nueva pestaña con la cotización en formato quotation-img
                    const routeData = this.$router.resolve({
                        name: 'quotation-img',
                        params: { id: res.data.id }
                    });
                    window.open(routeData.href, '_blank');
                })
                .catch((err) => {
                    if (err.response && err.response.data) {
                        this.$swal(err.response.data.message);
                    }
                    console.error(err);
                });
        },
        createOrder() {
            const fd = new FormData();

            fd.append("quotation_id", this.quotationExistent.id || 0);
            fd.append("final_delivery", this.order.final_delivery);
            fd.append("observations", this.order.observations);
            fd.append("suggested", 1);
            fd.append("payments", JSON.stringify([]));
            fd.append("discount", this.discount);
            fd.append("customers", JSON.stringify(this.customers));
            fd.append("customer_id", this.customer.id);
            fd.append("products", JSON.stringify(this.details));
            fd.append("user_id", this.store.authUser.id);

            axios
                .post("/api/orders", fd)
                .then((res) => {
                    this.orderId = res.data;
                    this.$swal("Orden registrada correctamente");
                })
                .catch((err) => {
                    if (err.response && err.response.data) {
                        this.$swal(err.response.data.message);
                    }
                });
        },
        createContract() {
            var thirdArticleValue = this.booleanToNumber(this.thirdArticle);
            var fifthArticleValue = this.booleanToNumber(this.fifthArticle);
            var thirdArticlePlaceValue = this.booleanToNumber(this.thirdArticlePlace);

            let conversorClass = conversor.conversorNumerosALetras;
            let myConverter = new conversorClass();

            const fd = new FormData();

            fd.append("quotation_id", this.quotationExistent.id || 0);
            fd.append("amount", this.finalPrice);
            fd.append(
                "amount_text",
                myConverter.convertToText(parseInt(this.finalPrice))
            );
            var decimal = Math.round((this.finalPrice % 1) * 100);
            fd.append("cent_text", myConverter.convertToText(decimal));
            fd.append("date", this.contract.date);
            fd.append("payments", JSON.stringify([]));
            fd.append("deliveries", JSON.stringify(this.deliveries));
            fd.append("customers", JSON.stringify(this.customers));
            fd.append("user_id", this.store.authUser.id);
            fd.append("products", JSON.stringify(this.details));
            fd.append("emisor_id", this.store.authUser.id);
            fd.append("third_article", thirdArticleValue);
            fd.append("fifth_article", fifthArticleValue);
            fd.append("third_article_place", thirdArticlePlaceValue);

            axios
                .post("/api/contracts", fd)
                .then((res) => {
                    this.contractId = res.data;
                    this.$swal("Contrato generado correctamente");
                })
                .catch((err) => {
                    if (err.response && err.response.data) {
                        this.$swal(err.response.data.message);
                    }
                    console.error(err);
                });
        },
        autoDiscount() {
            if (!this.coupon || !this.coupon.trim()) return;

            axios
                .get("/api/promotions/" + this.coupon)
                .then((result) => {
                    if (!result.data || Object.keys(result.data).length == 0) {
                        this.$swal("Código de cupón incorrecto");
                    } else if (result.data.percent == 0) {
                        this.$swal("Se ha aplicado el descuento por monto fijo");
                        this.discount = result.data.quantity;
                        this.quotation.discount = result.data.quantity;
                    } else {
                        this.$swal("Se ha aplicado el descuento por porcentaje (" + result.data.percent + "%)");
                        this.discount = (
                            (this.totalProductsWithoutDiscount * result.data.percent) /
                            100
                        ).toFixed(2);
                        this.quotation.discount = this.discount;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    computed: {
        totalProductsWithoutDiscount() {
            let total = 0;
            this.details.forEach((product) => {
                const basePrice = parseFloat(product.price) || 0;
                const extraPrice = parseFloat(product.extra_price) || 0;
                total += basePrice + extraPrice;
            });
            return total.toFixed(2);
        },
        finalPrice() {
            const rawTotal = parseFloat(this.totalProductsWithoutDiscount) || 0;
            const currentDiscount = parseFloat(this.documentType == 1 ? this.quotation.discount : this.discount) || 0;
            const net = Math.max(0, rawTotal - currentDiscount);
            return net.toFixed(2);
        },
    },
    mounted() {
        this.getCustomer();
        this.getAllNewProducts();
    },
};
</script>

<style scoped>
.list-group {
    position: absolute;
    z-index: 9999 !important;
}

.form-label,
label {
    color: #1e293b !important;
    font-weight: 600 !important;
}

.text-dark {
    color: #0f172a !important;
}

.form-control,
.form-select {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
}

.input-group-text {
    background-color: #f1f5f9 !important;
    color: #334155 !important;
    border-color: #cbd5e1 !important;
    font-weight: 600;
}

/* Dark Mode Overrides */
body.dark-mode .form-label,
body.dark-mode label,
[data-bs-theme="dark"] .form-label,
[data-bs-theme="dark"] label {
    color: #e2e8f0 !important;
}

body.dark-mode .text-dark,
[data-bs-theme="dark"] .text-dark {
    color: #ffffff !important;
}

body.dark-mode .form-control,
body.dark-mode .form-select,
[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #1b1b29 !important;
    color: #ffffff !important;
    border-color: #3a3b54 !important;
}

body.dark-mode .input-group-text,
[data-bs-theme="dark"] .input-group-text {
    background-color: #2b2c40 !important;
    color: #a1a5b7 !important;
    border-color: #3a3b54 !important;
}
</style>
