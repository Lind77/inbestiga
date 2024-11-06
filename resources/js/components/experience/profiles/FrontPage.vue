<template>
    <div class="card mb-2 p-2">
        <div class="user-profile-header-banner">
            <img
                src="https://inbestiga.com/ficha_proyecto.jpg"
                alt="Banner image"
                class="rounded w-100"
            />
        </div>
        <div
            class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4"
        >
            <div class="px-4 pt-4 w-100">
                <div class="row">
                    <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                        <span class="h5 mt-2 demo text-body fw-bold"
                            >Información General
                        </span>
                        <div class="mt-2">
                            <p class="mb-2">
                                <span class="fw-bold"
                                    >Servicio Contratado
                                </span>
                            </p>
                            <div class="list-group">
                                <a
                                    v-for="detail in quotation.details"
                                    href="javascript:void(0);"
                                    class="list-group-item list-group-item-action"
                                >
                                    {{ detail.name }}</a
                                >
                            </div>
                        </div>
                        <div class="mt-3" v-if="quotation.contract">
                            <button
                                :class="`btn btn-md btn-${
                                    quotation.contract.third_article_place == 0
                                        ? 'success'
                                        : 'secondary'
                                } btn-icon`"
                                title="Lugar o contexto de estudio"
                            >
                                <i class="bx bx-landscape"></i>
                            </button>
                            <button
                                :class="`btn btn-md btn-${
                                    quotation.contract.third_article == 0
                                        ? 'info'
                                        : 'secondary'
                                } btn-icon ms-1`"
                                title="Aplicación de instrumentos"
                            >
                                <i class="bx bxs-vial"></i>
                            </button>
                            <button
                                :class="`btn btn-md btn-${
                                    quotation.contract.third_article == 0
                                        ? 'warning'
                                        : 'secondary'
                                } btn-icon ms-1`"
                                title="Diapositivas"
                            >
                                <i class="bx bxs-collection"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-12">
                        <span class="h5 mt-2 demo text-body fw-bold"
                            >Clientes
                        </span>

                        <div
                            class="card bg-primary p-2 mb-2 mt-2"
                            v-if="customerSelected"
                        >
                            <div
                                class="card-header d-flex align-items-center justify-content-between"
                            >
                                <h5
                                    class="card-title m-0 me-2 text-white"
                                    :title="customerSelected.name"
                                >
                                    {{
                                        customerSelected.name
                                            ? customerSelected.name.substring(
                                                  0,
                                                  20
                                              ) + "..."
                                            : ""
                                    }}
                                </h5>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="employeeList"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i
                                            class="bx bx-dots-vertical-rounded text-white"
                                        ></i>
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="employeeList"
                                        style=""
                                    >
                                        <a
                                            class="dropdown-item"
                                            href="javascript:void(0);"
                                            @click="
                                                updateCustomer(customerSelected)
                                            "
                                            >Editar</a
                                        >
                                        <!--   <a
                                                    v-if="
                                                        quotation.customers
                                                            .length >= 2
                                                    "
                                                    class="dropdown-item"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        deleteCustomerContract(
                                                            customer.id,
                                                            quotation.id
                                                        )
                                                    "
                                                    >Eliminar</a
                                                > -->
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2 text-white"
                                >
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-id-card"></i>
                                        {{ customerSelected.dni }}
                                    </li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-pen"></i>
                                        {{ customerSelected.career }}
                                    </li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bxs-graduation"></i>
                                        {{ customerSelected.university }}
                                    </li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-phone"></i>
                                        {{ customerSelected.cell }}
                                    </li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-street-view"></i>
                                        Actitud:
                                        {{
                                            customerSelected.attitude
                                                ? customerSelected.attitude
                                                : "-"
                                        }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                            class="d-flex align-items-center avatar-group my-3"
                        >
                            <div
                                class="avatar avatar-sm me-2"
                                v-for="customer in quotation.customers"
                                :title="customer.name"
                            >
                                <span
                                    @click="selectCustomer(customer)"
                                    class="avatar-initial rounded-circle bg-primary"
                                    >{{ customer.name[0] }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                        <span class="h5 mt-2 demo text-body fw-bold">
                            Estado de Trámite
                        </span>
                        <Chart />
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Chart from "./Chart.vue";

export default {
    components: { Chart },
    data() {
        return {
            customerSelected: {},
        };
    },
    props: {
        quotation: Object,
    },
    methods: {
        updateCustomer(customer) {
            this.$emit("updateCustomer", customer);
        },
        selectCustomer(customer) {
            this.customerSelected = customer;
        },
    },
    watch: {
        quotation(val) {
            this.customerSelected = this.quotation.customers[0];
        },
    },
};
</script>
<style lang=""></style>
