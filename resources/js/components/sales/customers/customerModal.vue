<template>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        {{ action == 1 ? 'Insertar Prospecto' : 'Actualizar Cliente ' + (localCustomer.name || '') }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <!-- Column 1: Personal Information -->
                        <div class="col-12 col-lg-4">
                            <h6 class="fw-bold mb-3 text-primary"><i class="bx bx-user me-1"></i> Datos Personales</h6>
                            <div class="mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.name"
                                    class="form-control"
                                    placeholder="Nombre del cliente"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Número de Celular</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.cell"
                                    class="form-control"
                                    placeholder="Ej. 987654321"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input
                                    type="email"
                                    v-model="localCustomer.email"
                                    class="form-control"
                                    placeholder="correo@ejemplo.com"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">DNI</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.dni"
                                    class="form-control"
                                    placeholder="Documento de Identidad"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Género</label>
                                <select
                                    class="form-select"
                                    v-model="localCustomer.gender"
                                >
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.address"
                                    class="form-control"
                                    placeholder="Dirección residencial"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input
                                    type="date"
                                    v-model="localCustomer.birth_date"
                                    class="form-control"
                                />
                            </div>
                        </div>

                        <!-- Column 2: Academic & Origin -->
                        <div class="col-12 col-lg-4">
                            <h6 class="fw-bold mb-3 text-primary"><i class="bx bx-book-open me-1"></i> Datos Académicos</h6>
                            <div class="mb-3">
                                <label class="form-label">Universidad</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.university"
                                    class="form-control"
                                    placeholder="Universidad de procedencia"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Carrera o Mención</label>
                                <input
                                    type="text"
                                    v-model="localCustomer.career"
                                    class="form-control"
                                    placeholder="Mención académica"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Situación / Tipo de Tesis</label>
                                <select
                                    class="form-select"
                                    v-model="localCustomer.type"
                                >
                                    <option value="1">Tesis sin avance</option>
                                    <option value="2">Tesis con avance</option>
                                    <option value="3">Artículo Científico</option>
                                    <option value="4">Otra Modalidad de Titulación</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 3: Location -->
                        <div class="col-12 col-lg-4">
                            <h6 class="fw-bold mb-3 text-primary"><i class="bx bx-map me-1"></i> Ubicación</h6>
                            <div class="mb-3">
                                <label class="form-label">Departamento</label>
                                <select
                                    class="form-select"
                                    @change="selectProvinces"
                                    v-model="departmentSelectedId"
                                >
                                    <option value="0" disabled>Selecciona Departamento</option>
                                    <option
                                        :value="department.id"
                                        v-for="department in departments"
                                        :key="department.id"
                                    >
                                        {{ department.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Provincia</label>
                                <select
                                    class="form-select"
                                    v-model="provinceSelectedId"
                                >
                                    <option value="0" disabled>Selecciona Provincia</option>
                                    <option
                                        :value="province.id"
                                        v-for="province in provinces"
                                        :key="province.id"
                                    >
                                        {{ province.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Channel / Referral Blocks -->
                    <div class="row mt-3">
                        <div v-show="origin == 1" class="col-12 col-md-6 mb-3">
                            <label class="form-label">Canal de Contacto</label>
                            <select class="form-select" v-model="channel">
                                <option value="1">Messenger</option>
                                <option value="2">Whatsapp</option>
                                <option value="3">Página web</option>
                                <option value="4">Instagram</option>
                                <option value="5">Campo</option>
                            </select>
                        </div>
                        <div v-show="origin == 2" class="col-12 col-md-6 mb-3">
                            <label class="form-label">Referido por</label>
                            <select class="form-select" v-model="referedFrom">
                                <option :value="user.id" v-for="user in users" :key="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button
                        type="button"
                        id="close-insert-customer"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        v-if="action == 1"
                        @click="insertCustomer"
                        class="btn btn-primary"
                    >
                        <i class="bx bx-check me-1"></i> Registrar
                    </button>
                    <button
                        type="button"
                        v-else
                        @click="updateCustomer"
                        class="btn btn-primary"
                    >
                        <i class="bx bx-save me-1"></i> Guardar Cambios
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
        allUsers: Array,
    },
    data() {
        return {
            localCustomer: {
                id: null,
                name: "",
                cell: "",
                email: "",
                dni: "",
                gender: "1",
                address: "",
                birth_date: "",
                university: "",
                career: "",
                type: "1",
                attitude: "",
                province_id: 0,
                channel: 0,
                referedFrom: 0
            },
            users: [],
            origin: 0,
            channel: 0,
            referedFrom: 0,
            departments: [],
            departmentSelectedId: 0,
            provinces: [],
            provinceSelectedId: 0,
        };
    },
    methods: {
        resetLocalCustomer() {
            this.localCustomer = {
                id: null,
                name: "",
                cell: "",
                email: "",
                dni: "",
                gender: "1",
                address: "",
                birth_date: "",
                university: "",
                career: "",
                type: "1",
                attitude: "",
                province_id: 0,
                channel: 0,
                referedFrom: 0
            };
            this.departmentSelectedId = 0;
            this.provinceSelectedId = 0;
            this.provinces = [];
        },
        selectProvinces() {
            var selectedDept = this.departments.find(
                (d) => d.id == this.departmentSelectedId
            );
            this.provinces = selectedDept ? selectedDept.provinces : [];
            this.provinceSelectedId = 0;
        },
        updateCustomer() {
            const fd = new FormData();
            fd.append("_method", "put");
            fd.append("id", this.localCustomer.id);
            fd.append("name", this.localCustomer.name || "");
            fd.append("cell", this.localCustomer.cell || "");
            fd.append("university", this.localCustomer.university || "");
            fd.append("career", this.localCustomer.career || "");
            fd.append("email", this.localCustomer.email || "");
            fd.append("dni", this.localCustomer.dni || "");
            fd.append("address", this.localCustomer.address || "");
            fd.append("attitude", this.localCustomer.attitude || "");
            fd.append("birth_date", this.localCustomer.birth_date || "");
            fd.append("province_id", this.provinceSelectedId);
            fd.append("gender", this.localCustomer.gender || "1");
            fd.append("type", this.localCustomer.type || "1");

            axios
                .post(`/api/customers/${this.localCustomer.id}`, fd)
                .then((res) => {
                    this.$emit("getAllCustomers");
                    $("#customerModal").modal("hide");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        insertCustomer() {
            const fd = new FormData();
            fd.append("name", this.localCustomer.name || "");
            fd.append("cell", this.localCustomer.cell || "");
            fd.append("university", this.localCustomer.university || "");
            fd.append("career", this.localCustomer.career || "");
            fd.append("email", this.localCustomer.email || "");
            fd.append("origin", this.origin);
            fd.append("status", 1); // Default status
            fd.append("dni", this.localCustomer.dni || "");
            fd.append("attitude", this.localCustomer.attitude || "");
            fd.append("address", this.localCustomer.address || "");
            fd.append("referedFrom", this.referedFrom);
            fd.append("channel", this.channel);
            fd.append("user_id", 12);
            fd.append("userregister_id", this.store.authUser.id);
            fd.append("birth_date", this.localCustomer.birth_date || "");
            fd.append("province_id", this.provinceSelectedId);
            fd.append("type", this.localCustomer.type || "1");

            axios
                .post("/api/customers", fd)
                .then((res) => {
                    this.$emit("getAllCustomers");
                    $("#customerModal").modal("hide");
                    this.resetLocalCustomer();
                })
                .catch((err) => {
                    if (err.response && err.response.status == 422) {
                        this.$swal.fire(err.response.data.message);
                    } else if (err.response && err.response.status == 400) {
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
                                if (result.isConfirmed) {
                                    this.insertCustomer();
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
        if (this.allUsers && this.allUsers.length > 0) {
            this.users = this.allUsers;
        }
    },
    watch: {
        customer(val) {
            if (val && Object.keys(val).length > 0) {
                this.localCustomer = JSON.parse(JSON.stringify(val));
                if (val.province_id) {
                    this.departmentSelectedId = val.province.department_id;
                    this.provinces = val.province.department.provinces;
                    this.provinceSelectedId = val.province_id;
                } else {
                    this.departmentSelectedId = 0;
                    this.provinceSelectedId = 0;
                    this.provinces = [];
                }
            } else {
                this.resetLocalCustomer();
            }
        },
        action(val) {
            if (val == 1) {
                this.resetLocalCustomer();
            }
        },
        allUsers(val) {
            if (val && val.length > 0) {
                this.users = val;
            }
        }
    },
};
</script>
