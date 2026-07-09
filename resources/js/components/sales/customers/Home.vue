<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">Base de Datos de Clientes</h4>
            <div>
                <button
                    @click="openCustomerModal(1)"
                    class="btn btn-primary"
                    type="button"
                >
                    <i class="bx bx-plus me-1"></i>
                    <span>Nuevo prospecto</span>
                </button>
                <button class="btn btn-outline-primary ms-2" @click="filterOwn">
                    <i class="bx bx-filter-alt me-1"></i>Mis Leads
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card pt-2">
                    <!-- Filters Grid -->
                    <div class="card-body pb-3">
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                                    <input
                                        type="text"
                                        placeholder="Buscar por nombre o teléfono..."
                                        class="form-control"
                                        @keyup.enter="searchCustomer"
                                        @keyup="cleanSearch"
                                        v-model="search"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input
                                        type="date"
                                        @change="searchCustomersByDate"
                                        class="form-control"
                                        v-model="searchDate"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Table -->
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre / Teléfono</th>
                                    <th>Asignado A</th>
                                    <th>Fecha de Registro</th>
                                    <th class="text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr v-for="customer in customers" :key="customer.id">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <strong
                                                class="cursor-pointer text-primary text-hover-underline me-2"
                                                @click="redirectFunnel(customer)"
                                                title="Ver detalles"
                                            >
                                                {{ customer.name }}
                                            </strong>
                                            <i
                                                @click="openOwnerModal(customer.id)"
                                                v-show="customer.user_id == null"
                                                class="bx bxs-user-x text-danger cursor-pointer"
                                                title="Sin dueño - Asignar"
                                            ></i>
                                        </div>
                                        <small class="text-muted">{{ customer.cell || 'Sin celular' }}</small>
                                    </td>
                                    <td>
                                        <span :class="customer.user ? 'text-white' : 'text-warning small'">
                                            {{ customer.user ? customer.user.name : 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ formatDate(customer.created_at) }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button
                                                v-if="customer.status == 0"
                                                @click="reactivateCustomer(customer.id)"
                                                class="btn btn-warning btn-sm"
                                                title="Reactivar"
                                            >
                                                <i class="bx bx-recycle"></i>
                                            </button>
                                            <button
                                                @click="openCustomerModal(2, customer)"
                                                class="btn btn-primary btn-sm"
                                                title="Editar"
                                            >
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button
                                                @click="makeDocs(customer.id)"
                                                class="btn btn-info btn-sm"
                                                title="Generar Fichas/Documentos"
                                            >
                                                <i class="bx bx-file"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="customers.length === 0">
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No se encontraron prospectos o clientes.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Card Footer -->
                    <div class="card-footer d-flex align-items-center justify-content-between py-3">
                        <div class="text-muted small">
                            Base de datos • Mostrando {{ customers.length }} registros
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-outline-primary btn-sm"
                                @click="prevPage"
                                :disabled="prevPageUrl == null"
                            >
                                <i class="bx bx-chevron-left me-1"></i> Anterior
                            </button>
                            <button
                                class="btn btn-outline-primary btn-sm"
                                @click="nextPage"
                                :disabled="nextPageUrl == null"
                            >
                                Siguiente <i class="bx bx-chevron-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <customerModal
            :customer="customer_selected"
            :action="action"
            :allUsers="allUsers"
            @getAllCustomers="getAllCustomers"
        />
        <OwnerModal
            :customerId="customerId"
            @cleanLead="cleanLead"
            @getAllCustomers="getAllCustomers"
        />
    </div>
</template>

<script>
import moment from "moment";
import customerModal from "./customerModal.vue";
import OwnerModal from "./OwnerModal.vue";
import { userStore } from "../../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    components: { customerModal, OwnerModal },
    data() {
        return {
            searchDate: "",
            customerId: 0,
            customers: [],
            customersPag: [],
            customersChunked: [],
            customer_selected: {},
            allUsers: [],
            action: 1,
            search: "",
            status: {
                0: "Stand by",
                1: "No atendido",
                2: "Atendido",
                3: "Comunicación establecida",
                4: "Obtención de necesidades específicas",
                5: "Con Cotización",
                6: "Explicación de Cotización",
                7: "Explicación de la Experiencia",
                8: "Seguimientos",
                9: "Cierre no pagado",
                10: "Seguimiento de cierre",
                11: "Cliente",
            },
            nextPageUrl: null,
            prevPageUrl: null,
            currentPage: 1,
            pageSize: 10,
        };
    },
    methods: {
        nextPage() {
            if (this.nextPageUrl) {
                axios
                    .get(this.nextPageUrl)
                    .then((result) => {
                        this.nextPageUrl = result.data.next_page_url;
                        this.prevPageUrl = result.data.prev_page_url;
                        this.customers = result.data.data;
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
        },
        prevPage() {
            if (this.prevPageUrl) {
                axios
                    .get(this.prevPageUrl)
                    .then((result) => {
                        this.nextPageUrl = result.data.next_page_url;
                        this.prevPageUrl = result.data.prev_page_url;
                        this.customers = result.data.data;
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
        },
        openOwnerModal(customerId) {
            this.customerId = customerId;
            $("#ownerModal").modal("show");
        },
        makeDocs(customerId) {
            this.$router.push({
                name: "home-docs",
                params: { customerId: customerId },
            });
        },
        redirectFunnel(customer) {
            if (customer.status > 3) {
                this.$router.push({
                    name: "home-funnel",
                    params: { userId: customer.id },
                });
            } else {
                this.$router.push({
                    name: "home-pre-lead",
                    params: { userId: customer.id },
                });
            }
        },
        cleanSearch() {
            if (this.search == "") {
                this.getAllCustomers();
            }
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
        cleanLead(customerId, seller) {
            var customerSelected = this.customers.find(
                (customer) => customer.id == customerId
            );
            if (customerSelected) {
                customerSelected.user_id = seller;
                this.getAllCustomers();
            }
        },
        openAsignOwner(id) {
            this.customerId = id;
            $("#ownerModal").modal("show");
        },
        searchCustomersByDate() {
            if (this.searchDate == "") {
                this.getAllCustomers();
                return;
            }
            axios
                .get("/api/customers/search-by-date/" + this.searchDate)
                .then((res) => {
                    this.customers = res.data;
                    this.nextPageUrl = null;
                    this.prevPageUrl = null;
                })
                .catch((err) => {
                    console.error(err.response);
                });
        },
        searchCustomer() {
            if (this.search == "") {
                this.getAllCustomers();
                return;
            }
            axios
                .get("/api/customers/search/" + this.search)
                .then((res) => {
                    this.customers = res.data.customers;
                    this.nextPageUrl = null;
                    this.prevPageUrl = null;
                })
                .catch((err) => {
                    console.error(err.response);
                });
        },
        stepPag(i) {
            this.customersPag = this.customersChunked[i];
            document.querySelectorAll(".paginate_button").forEach((el) => {
                el.classList.remove("active");
            });
            document.getElementById("li" + i).classList.add("active");
        },
        openCustomerModal(action, customer) {
            this.action = action;
            this.customer_selected = customer || {};
            $("#customerModal").modal("show");
        },
        reactivateCustomer(id) {
            this.$swal({
                title: "¿Deseas sacar este cliente a StandBy?",
                icon: "question",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .get("/api/reactivateCustomer/" + id)
                        .then((res) => {
                            this.getAllCustomers();
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                } else {
                    this.$swal.close();
                }
            });
        },
        getAllCustomers() {
            axios.get("/api/customers").then((res) => {
                this.customers = res.data.data;
                this.prevPageUrl = res.data.prev_page_url;
                this.nextPageUrl = res.data.next_page_url;
            });
        },
        getAllUsers() {
            axios
                .get("/api/users")
                .then((res) => {
                    this.allUsers = res.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        filterOwn() {
            axios
                .get("/api/customers-filter/" + this.store.authUser.id)
                .then((res) => {
                    this.customers = res.data;
                    this.nextPageUrl = null;
                    this.prevPageUrl = null;
                });
        },
    },
    mounted() {
        this.getAllCustomers();
        this.getAllUsers();
    },
};
</script>

<style scoped>
.text-hover-underline:hover {
    text-decoration: underline !important;
}
</style>
