<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-bold py-3 mb-4">Base de datos</h4>
            <div class="">
                <button
                    @click="openCustomerModal(1)"
                    class="btn btn-primary"
                    tabindex="0"
                    aria-controls="DataTables_Table_0"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasEcommerceCustomerAdd"
                >
                    <span
                        ><i class="bx bx-plus me-0 me-sm-1"></i
                        ><span class="d-none d-sm-inline-block"
                            >Nuevo prospecto</span
                        ></span
                    >
                </button>
                <button class="btn btn-success ms-1" @click="filterOwn">
                    Filtro
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card pt-2">
                    <div class="row ms-2">
                        <input
                            type="text"
                            name=""
                            id=""
                            placeholder="Buscar..."
                            class="form-control w-50 py-2"
                            @keyup.enter="searchCustomer"
                            @keyup="cleanSearch"
                            v-model="search"
                        />
                        <input
                            type="date"
                            @change="searchCustomersByDate"
                            class="form-control w-25 ms-2"
                            v-model="searchDate"
                        />
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dueño</th>
                                    <!--  <th>Celular</th> -->
                                    <th>Fecha de Registro</th>
                                    <!-- <th>Universidad</th>
                  <th>Carrera</th> -->
                                    <!-- <th>Estado</th> -->
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr v-for="customer in customers">
                                    <td>
                                        <strong
                                            class="cursor-pointer placeholder-glow"
                                            >{{ customer.name }}</strong
                                        ><i
                                            @click="openOwnerModal(customer.id)"
                                            v-show="customer.user_id == null"
                                            class="bx bxs-user-x text-danger"
                                        ></i>
                                        <br />
                                        <small>{{ customer.cell }}</small>
                                    </td>
                                    <td>
                                        {{
                                            customer.user
                                                ? customer.user.name
                                                : "Sin asignar"
                                        }}
                                    </td>
                                    <!-- <td>{{ customer.cell }}</td> -->
                                    <td>
                                        {{ formatDate(customer.created_at) }}
                                    </td>
                                    <!-- <td>{{ customer.university ? customer.university.substring(0, 20) + '...' : '-' }}</td>
                  <td>{{ customer.career ? customer.career.substring(0, 20) + '...' : '-' }}</td> -->
                                    <!-- <td>{{ status[customer.status] }}</td> -->
                                    <td>
                                        <!-- <router-link class="btn btn-success btn-sm" :to="{name:'home-quotation', params:{ idUser: customer.id }}">Generar Cotización</router-link> -->
                                        <button
                                            v-if="customer.status == 0"
                                            @click="
                                                reactivateCustomer(customer.id)
                                            "
                                            class="btn btn-success btn-sm me-1"
                                        >
                                            <i class="bx bx-recycle"></i>
                                        </button>
                                        <button
                                            @click="
                                                openCustomerModal(2, customer)
                                            "
                                            class="btn btn-success btn-sm ms-2"
                                        >
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button
                                            @click="makeDocs(customer.id)"
                                            class="btn btn-success btn-sm ms-2"
                                        >
                                            <i class="bx bx-file"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button
            class="btn btn-primary btn-icon"
            @click="prevPage"
            v-if="prevPageUrl != null"
        >
            <i class="bx bx-chevron-left"></i>
        </button>
        <button
            class="btn btn-primary btn-icon"
            v-if="nextPageUrl != null"
            @click="nextPage"
        >
            <i class="bx bx-chevron-right"></i>
        </button>
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
            axios
                .get(this.nextPageUrl)
                .then((result) => {
                    this.nextPageUrl = result.data.next_page_url;
                    this.prevPageUrl = result.data.prev_page_url;
                    this.customers = result.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        prevPage() {
            axios
                .get(this.prevPageUrl)
                .then((result) => {
                    this.nextPageUrl = result.data.next_page_url;
                    this.prevPageUrl = result.data.prev_page_url;
                    this.customers = result.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
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
            customerSelected.user_id = seller;
        },
        openAsignOwner(id) {
            this.customerId = id;
            $("#ownerModal").modal("show");
        },
        searchCustomersByDate() {
            axios
                .get("/api/customers/search-by-date/" + this.searchDate)
                .then((res) => {
                    console.log(res);
                    this.customers = res.data;
                })
                .catch((err) => {
                    console.error(err.response);
                });
        },
        searchCustomer() {
            axios
                .get("/api/customers/search/" + this.search)
                .then((res) => {
                    this.customers = res.data.customers;
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
            this.customer_selected = customer;
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
                            this.customers = res.data;
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
        filterOwn() {
            axios
                .get("/api/customers-filter/" + this.store.authUser.id)
                .then((res) => {
                    this.customers = res.data;
                });
        },
    },
    mounted() {
        this.getAllCustomers();
    },
};
</script>
