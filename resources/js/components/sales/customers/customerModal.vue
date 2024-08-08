<template>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        v-if="action == 1"
                        id="exampleModalLabel1"
                    >
                        Insertar Prospecto
                    </h5>
                    <h5 class="modal-title" v-else id="exampleModalLabel1">
                        Actualizar Cliente {{ customer.name || customer.cell }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="col">
                                <label for="nameBasic" class="form-label"
                                    >Nombre</label
                                >
                                <input
                                    type="text"
                                    v-if="action == 2"
                                    v-model="customer.name"
                                    class="form-control"
                                />
                                <input
                                    type="text"
                                    v-else
                                    v-model="name"
                                    class="form-control"
                                />
                            </div>

                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="nameBasic" class="form-label"
                                        >Celular</label
                                    >
                                    <input
                                        type="text"
                                        v-if="action == 2"
                                        v-model="customer.cell"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="cell"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0" v-if="action == 2">
                                    <label for="nameBasic" class="form-label"
                                        >Email</label
                                    >
                                    <input
                                        type="email"
                                        v-if="action == 2"
                                        v-model="customer.email"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="email"
                                        class="form-control"
                                    />
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col mb-0" v-if="action == 2">
                                    <label for="dobBasic" class="form-label"
                                        >DNI</label
                                    >
                                    <input
                                        type="text"
                                        v-if="action == 2"
                                        v-model="customer.dni"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="dni"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0" v-if="action == 2">
                                    <label for="dobBasic" class="form-label"
                                        >Dirección</label
                                    >
                                    <input
                                        type="text"
                                        v-if="action == 2"
                                        v-model="customer.address"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="address"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0" v-if="action == 2">
                                    <label for="dobBasic" class="form-label"
                                        >Fecha de nacimiento</label
                                    >
                                    <input
                                        type="date"
                                        v-if="action == 2"
                                        v-model="customer.birth_date"
                                        class="form-control"
                                    />
                                    <input
                                        type="date"
                                        v-else
                                        v-model="birth_date"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="row g-2 mt-0">
                                <div class="col mb-0 mt-0">
                                    <label for="dobBasic" class="form-label"
                                        >Universidad</label
                                    >
                                    <input
                                        type="text"
                                        v-if="action == 2"
                                        v-model="customer.university"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="university"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailBasic" class="form-label"
                                        >Carrera o mención</label
                                    >
                                    <input
                                        type="text"
                                        v-if="action == 2"
                                        v-model="customer.career"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        v-else
                                        v-model="career"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row g-2" v-if="action == 2">
                                <div class="col mb-0">
                                    <label class="form-label">Situación</label>
                                    <select
                                        class="form-select"
                                        v-model="customer.type"
                                    >
                                        <option value="1" default>
                                            Tesis sin avance
                                        </option>
                                        <option value="2">
                                            Tesis con avance
                                        </option>
                                        <option value="3">
                                            Artículo Científico
                                        </option>
                                        <option value="4">
                                            Otra Modalidad de Titulación
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="emailBasic" class="form-label"
                                >Departamento</label
                            >

                            <select
                                v-if="
                                    action == 2 && customer && customer.province
                                "
                                class="form-control"
                                @change="selectProvinces"
                                v-model="customer.province.department_id"
                            >
                                <option
                                    :value="department.id"
                                    v-for="department in departments"
                                >
                                    {{ department.name }}
                                </option>
                            </select>
                            <select
                                v-else
                                class="form-control"
                                @change="selectProvinces"
                                v-model="departmentSelectedId"
                            >
                                <option
                                    :value="department.id"
                                    v-for="department in departments"
                                >
                                    {{ department.name }}
                                </option>
                            </select>
                            <label for="emailBasic" class="form-label"
                                >Provincia</label
                            >
                            <select
                                v-if="
                                    action == 2 && customer && customer.province
                                "
                                class="form-control"
                                v-model="customer.province_id"
                            >
                                <option
                                    :value="province.id"
                                    v-for="province in customer.province
                                        .department.provinces"
                                >
                                    {{ province.name }}
                                </option>
                            </select>
                            <select
                                v-else
                                class="form-control"
                                v-model="provinceSelectedId"
                            >
                                <option
                                    :value="province.id"
                                    v-for="province in provinces"
                                >
                                    {{ province.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div v-show="origin == 1" class="row g-2">
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label"
                                >Canal</label
                            >
                            <select class="form-select" v-model="channel">
                                <option value="1">Messenger</option>
                                <option value="2">Whatsapp</option>
                                <option value="3">Página web</option>
                                <option value="4">Instagram</option>
                                <option value="5">Campo</option>
                            </select>
                        </div>
                    </div>
                    <div v-show="origin == 2" class="row g-2">
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label"
                                >Referido por</label
                            >
                            <select class="form-select" v-model="referedFrom">
                                <option :value="user.id" v-for="user in users">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        id="close-insert-customer"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cerrar
                    </button>
                    <button
                        type="button"
                        v-if="action == 1"
                        @click="insertCustomer"
                        class="btn btn-primary"
                    >
                        Registrar
                    </button>
                    <button
                        type="button"
                        v-else
                        @click="updateCustomer"
                        class="btn btn-primary"
                    >
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { userStore } from "../../../stores/UserStore";

export default {
    setup() {
        const store = userStore();
        return { store };
    },
    props: {
        action: Number,
        customer: Object,
    },
    data() {
        return {
            name: "",
            cell: "",
            university: "",
            career: "",
            email: "",
            dni: "",
            address: "",
            first_management: null,
            last_management: null,
            next_management: null,
            comment: "",
            product_tentative: "",
            type: 0,
            origin: 0,
            users: [],
            referedFrom: 0,
            channel: 0,
            status: 1,
            attitude: "",
            departments: [],
            departmentSelectedId: 0,
            provinces: [],
            provinceSelectedId: 0,
            birth_date: null,
        };
    },
    methods: {
        selectProvinces() {
            var provinces = this.departments.find(
                (d) => d.id == this.departmentSelectedId
            ).provinces;
            console.log(provinces);

            this.provinces = provinces;
        },
        updateCustomer() {
            const fd = new FormData();
            fd.append("_method", "put");
            fd.append("id", this.customer.id);
            fd.append("name", this.customer.name);
            fd.append("cell", this.customer.cell);
            fd.append("university", this.customer.university);
            fd.append("career", this.customer.career);
            fd.append("email", this.customer.email);
            fd.append("dni", this.customer.dni);
            fd.append("address", this.customer.address);
            fd.append("attitude", this.customer.attitude);
            fd.append("birth_date", this.customer.birth_date);
            fd.append("province_id", this.provinceSelectedId);
            fd.append("type", this.customer.type);
            axios
                .post(`/api/customers/${this.customer.id}`, fd)
                .then((res) => {
                    console.log(res);
                    this.$emit("getAllCustomers");
                    $("#customerModal").modal("hide");
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        verifyExistence() {
            const fd = new FormData();

            fd.append("name", this.name);
            fd.append("cell", this.cell);
            axios
                .post("/api/customers/verify", fd)
                .then((res) => {
                    if (res.data) {
                        this.insertCustomer();
                    }

                    var coincidences = [];
                    res.data.coincidences.forEach((coincidence) => {
                        coincidences.push(
                            `${coincidence.name}(${coincidence.cell})<br>`
                        );
                    });
                    if (res.data.msg) {
                        $("#customerModal").modal("hide");

                        //$('#customerModal').modal('hide')
                        //this.$swal('Se ha encontrado un usuario con el mismo nombre')
                    } else {
                        this.insertCustomer();
                    }
                })
                .catch((err) => {});
        },
        insertCustomer() {
            const fd = new FormData();
            fd.append("name", this.name);
            fd.append("cell", this.cell);
            fd.append("university", this.university);
            fd.append("career", this.career);
            fd.append("email", this.email);
            fd.append("origin", this.origin);
            fd.append("status", 9);
            fd.append("dni", this.dni);
            fd.append("attitude", this.attitude);
            fd.append("address", this.address);
            fd.append("referedFrom", this.referedFrom);
            fd.append("channel", this.channel);
            fd.append("user_id", 12);
            fd.append("userregister_id", this.store.authUser.id);
            /* fd.append("birth_date", this.birth_date); */
            fd.append("province_id", this.provinceSelectedId);
            fd.append("type", this.type);

            axios
                .post("/api/customers", fd)
                .then((res) => {
                    console.log(res);
                    this.$emit("getAllCustomers");
                    $("#customerModal").modal("hide");
                })
                .catch((err) => {
                    $("#customerModal").modal("hide");

                    if (err.response.status == 422) {
                        this.$swal.fire(err.response.data.message);
                    } else if (err.response.status == 400) {
                        console.log(err.response.data);
                        this.$swal
                            .fire({
                                icon: "error",
                                title: "Se han encontrado usuarios con el mismo nombre",
                                html:
                                    err.response.data.map(
                                        (customer) => `${customer.name} `
                                    ) +
                                    "<br>Tienes la seguridad de continuar con el registro?",
                                showDenyButton: true,
                                confirmButtonText: "Registrar",
                            })
                            .then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    this.insertCustomer();
                                } else if (result.isDenied) {
                                    this.$swal.close();
                                }
                            });
                    }
                });
        },
        getAllUsers() {
            axios
                .get("/api/users")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        getDataAddress() {
            axios
                .get("/api/addressData")
                .then((result) => {
                    this.departments = result.data.departments;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getAllUsers();
        this.getDataAddress();
    },
};
</script>
