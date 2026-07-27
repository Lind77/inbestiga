<template>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <!-- Modal Header -->
                <div class="modal-header bg-light border-bottom py-3 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3 bg-label-primary rounded p-2 d-flex align-items-center justify-content-center">
                            <i class="bx fs-4" :class="action == 1 ? 'bx-user-plus' : 'bx-user-check'"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0 text-dark">
                                {{ action == 1 ? 'Insertar Nuevo Prospecto' : 'Actualizar Cliente: ' + (localCustomer.name || '') }}
                            </h5>
                            <small class="text-muted">
                                {{ action == 1 ? 'Complete los campos para registrar un nuevo prospecto' : 'Modifique la información del cliente' }}
                            </small>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Column 1: Personal Information -->
                        <div class="col-12 col-lg-4">
                            <div class="card h-100 border shadow-none bg-body">
                                <div class="card-header bg-transparent border-bottom py-3 px-3">
                                    <h6 class="fw-bold text-primary mb-0 d-flex align-items-center">
                                        <i class="bx bx-user me-2 fs-5"></i> Datos Personales
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Nombre Completo -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">
                                            Nombre Completo <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input
                                                type="text"
                                                v-model="localCustomer.name"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.name }"
                                                placeholder="Nombre del cliente"
                                                @input="clearError('name')"
                                            />
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.name">
                                            {{ errors.name }}
                                        </div>
                                    </div>

                                    <!-- Celular -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">
                                            Número de Celular <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                            <input
                                                type="text"
                                                v-model="localCustomer.cell"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.cell }"
                                                placeholder="Ej. 987654321"
                                                @input="clearError('cell')"
                                            />
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.cell">
                                            {{ errors.cell }}
                                        </div>
                                    </div>

                                    <!-- Correo Electrónico -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Correo Electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input
                                                type="email"
                                                v-model="localCustomer.email"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.email }"
                                                placeholder="correo@ejemplo.com"
                                                @input="clearError('email')"
                                            />
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.email">
                                            {{ errors.email }}
                                        </div>
                                    </div>

                                    <!-- DNI -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">DNI / Doc. Identidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                            <input
                                                type="text"
                                                v-model="localCustomer.dni"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.dni }"
                                                placeholder="Documento de identidad"
                                                @input="clearError('dni')"
                                            />
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.dni">
                                            {{ errors.dni }}
                                        </div>
                                    </div>

                                    <!-- Género -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Género</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-body"></i></span>
                                            <select
                                                class="form-select"
                                                v-model="localCustomer.gender"
                                            >
                                                <option value="1">Masculino</option>
                                                <option value="2">Femenino</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <!-- Fecha de Nacimiento -->
                                    <div class="mb-0">
                                        <label class="form-label fw-medium mb-1">Fecha de Nacimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input
                                                type="date"
                                                v-model="localCustomer.birth_date"
                                                class="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Academic Data -->
                        <div class="col-12 col-lg-4">
                            <div class="card h-100 border shadow-none bg-body">
                                <div class="card-header bg-transparent border-bottom py-3 px-3">
                                    <h6 class="fw-bold text-primary mb-0 d-flex align-items-center">
                                        <i class="bx bx-book-open me-2 fs-5"></i> Datos Académicos
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Universidad -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">
                                            Universidad
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-building-house"></i></span>
                                            <input
                                                type="text"
                                                list="universities-list"
                                                v-model="localCustomer.university"
                                                class="form-control"
                                                placeholder="Seleccione o escriba universidad (opcional)..."
                                            />
                                            <datalist id="universities-list">
                                                <option
                                                    v-for="(uni, index) in universitiesList"
                                                    :key="index"
                                                    :value="uni"
                                                ></option>
                                            </datalist>
                                        </div>
                                        <small class="text-muted ms-1" style="font-size: 0.75rem;">
                                            Seleccione de la lista desplegable o escriba otra
                                        </small>
                                    </div>

                                    <!-- Carrera -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">
                                            Carrera o Mención
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-book"></i></span>
                                            <input
                                                type="text"
                                                list="careers-list"
                                                v-model="localCustomer.career"
                                                class="form-control"
                                                placeholder="Seleccione o escriba carrera (opcional)..."
                                            />
                                            <datalist id="careers-list">
                                                <option
                                                    v-for="(carr, index) in careersList"
                                                    :key="index"
                                                    :value="carr"
                                                ></option>
                                            </datalist>
                                        </div>
                                        <small class="text-muted ms-1" style="font-size: 0.75rem;">
                                            Seleccione de la lista desplegable o escriba otra
                                        </small>
                                    </div>

                                    <!-- Situación / Tipo de Tesis -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Situación / Tipo de Tesis</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-detail"></i></span>
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
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Location & Origin -->
                        <div class="col-12 col-lg-4">
                            <div class="card h-100 border shadow-none bg-body">
                                <div class="card-header bg-transparent border-bottom py-3 px-3">
                                    <h6 class="fw-bold text-primary mb-0 d-flex align-items-center">
                                        <i class="bx bx-map-pin me-2 fs-5"></i> Ubicación y Origen
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Departamento -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Departamento</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
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
                                    </div>

                                    <!-- Provincia -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Provincia</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-navigation"></i></span>
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

                                    <!-- Dirección -->
                                    <div class="mb-3">
                                        <label class="form-label fw-medium mb-1">Dirección</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-home"></i></span>
                                            <input
                                                type="text"
                                                v-model="localCustomer.address"
                                                class="form-control"
                                                placeholder="Dirección residencial"
                                            />
                                        </div>
                                    </div>


                                    <!-- Canal de Contacto -->
                                    <div v-show="origin == 1" class="mb-3">
                                        <label class="form-label fw-medium mb-1">Canal de Contacto</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-share-alt"></i></span>
                                            <select class="form-select" v-model="channel">
                                                <option value="1">Messenger</option>
                                                <option value="2">Whatsapp</option>
                                                <option value="3">Página web</option>
                                                <option value="4">Instagram</option>
                                                <option value="5">Campo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Referido por -->
                                    <div v-show="origin == 2" class="mb-3">
                                        <label class="form-label fw-medium mb-1">Referido por</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user-voice"></i></span>
                                            <select class="form-select" v-model="referedFrom">
                                                <option :value="user.id" v-for="user in users" :key="user.id">
                                                    {{ user.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top py-3 px-4">
                    <button
                        type="button"
                        id="close-insert-customer"
                        class="btn btn-outline-secondary px-4 me-2"
                        data-bs-dismiss="modal"
                    >
                        <i class="bx bx-x me-1"></i> Cancelar
                    </button>
                    <button
                        type="button"
                        v-if="action == 1"
                        @click="insertCustomer"
                        class="btn btn-primary px-4 shadow-sm"
                    >
                        <i class="bx bx-check me-1"></i> Registrar Prospecto
                    </button>
                    <button
                        type="button"
                        v-else
                        @click="updateCustomer"
                        class="btn btn-success px-4 shadow-sm"
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
            errors: {
                name: "",
                cell: "",
                email: "",
                dni: "",
                university: "",
                career: ""
            },
            users: [],
            origin: 0,
            channel: 0,
            referedFrom: 0,
            departments: [],
            departmentSelectedId: 0,
            provinces: [],
            provinceSelectedId: 0,
            universitiesList: [
                "Universidad Nacional Mayor de San Marcos (UNMSM)",
                "Universidad Nacional de Ingeniería (UNI)",
                "Pontificia Universidad Católica del Perú (PUCP)",
                "Universidad Peruana Cayetano Heredia (UPCH)",
                "Universidad Nacional Agraria La Molina (UNALM)",
                "Universidad de Lima (ULIMA)",
                "Universidad del Pacífico (UP)",
                "Universidad Peruana de Ciencias Aplicadas (UPC)",
                "Universidad San Ignacio de Loyola (USIL)",
                "Universidad de Piura (UDEP)",
                "Universidad Privada del Norte (UPN)",
                "Universidad César Vallejo (UCV)",
                "Universidad Tecnológica del Perú (UTP)",
                "Universidad Continental",
                "Universidad Privada Antenor Orrego (UPAO)",
                "Universidad Nacional de San Agustín (UNSA)",
                "Universidad Nacional de San Antonio Abad del Cusco (UNSAAC)",
                "Universidad Científica del Sur",
                "Universidad San Martín de Porres (USMP)",
                "Universidad Ricardo Palma (URP)",
                "Universidad Nacional de Trujillo (UNT)",
                "Universidad Privada San Juan Bautista (UPSJB)",
                "Universidad Privada Norbert Wiener",
                "Universidad Autónoma del Perú",
                "Universidad Señor de Sipán (USS)",
                "Universidad Católica Santa María (UCSM)",
                "Universidad Católica de Trujillo (UCT)",
                "Universidad de Huánuco",
                "Universidad María Auxiliadora (UMA)",
                "Universidad Peruana Unión (UPeU)",
                "Universidad Nacional del Centro del Perú (UNCP)",
                "Universidad Nacional Hermilio Valdizán (UNHEVAL)",
                "Universidad Nacional Pedro Ruiz Gallo (UNPRG)",
                "Universidad Nacional del Altiplano (UNAP)",
                "Universidad Nacional de San Cristóbal de Huamanga (UNSCH)"
            ],
            careersList: [
                "Administración de Empresas",
                "Administración y Negocios Internacionales",
                "Arquitectura",
                "Ciencias de la Comunicación / Periodismo",
                "Contabilidad y Finanzas",
                "Derecho y Ciencias Políticas",
                "Economía",
                "Educación / Pedagogía",
                "Enfermería",
                "Estomatología / Odontología",
                "Ingeniería Ambiental",
                "Ingeniería Civil",
                "Ingeniería de Sistemas e Informática",
                "Ingeniería Electrónica y Telecomunicaciones",
                "Ingeniería Industrial",
                "Ingeniería Mecánica / Mecatrónica",
                "Ingeniería de Minas / Geológica",
                "Marketing y Publicidad",
                "Medicina Humana",
                "Nutrición y Dietética",
                "Obstetricia",
                "Psicología",
                "Sociología / Trabajo Social",
                "Turismo y Hotelería",
                "Zootecnia / Medicina Veterinaria"
            ]
        };
    },
    methods: {
        resetErrors() {
            this.errors = {
                name: "",
                cell: "",
                email: "",
                dni: "",
                university: "",
                career: ""
            };
        },
        clearError(field) {
            if (this.errors[field]) {
                this.errors[field] = "";
            }
        },
        validateForm() {
            this.resetErrors();
            let isValid = true;

            // Nombre
            if (!this.localCustomer.name || !this.localCustomer.name.trim()) {
                this.errors.name = "El nombre completo es obligatorio.";
                isValid = false;
            } else if (this.localCustomer.name.trim().length < 3) {
                this.errors.name = "El nombre debe tener al menos 3 caracteres.";
                isValid = false;
            }

            // Celular
            if (!this.localCustomer.cell || !String(this.localCustomer.cell).trim()) {
                this.errors.cell = "El número de celular es obligatorio.";
                isValid = false;
            } else if (!/^[0-9+\s-]{7,15}$/.test(String(this.localCustomer.cell).trim())) {
                this.errors.cell = "Ingrese un número de celular válido.";
                isValid = false;
            }

            // Correo
            if (this.localCustomer.email && this.localCustomer.email.trim() !== "") {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.localCustomer.email.trim())) {
                    this.errors.email = "Formato de correo electrónico inválido.";
                    isValid = false;
                }
            }

            // DNI
            if (this.localCustomer.dni && String(this.localCustomer.dni).trim() !== "") {
                if (!/^\d{8,12}$/.test(String(this.localCustomer.dni).trim())) {
                    this.errors.dni = "El DNI/Documento debe contener entre 8 y 12 dígitos.";
                    isValid = false;
                }
            }

            if (!isValid && this.$swal) {
                this.$swal.fire({
                    icon: "warning",
                    title: "Campos requeridos incompletos",
                    text: "Por favor complete los campos obligatorios señalados en rojo.",
                    confirmButtonText: "Entendido"
                });
            }

            return isValid;
        },
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
            this.resetErrors();
        },
        selectProvinces() {
            var selectedDept = this.departments.find(
                (d) => d.id == this.departmentSelectedId
            );
            this.provinces = selectedDept ? selectedDept.provinces : [];
            this.provinceSelectedId = 0;
        },
        updateCustomer() {
            if (!this.validateForm()) return;

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
            if (!this.validateForm()) return;

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
                    console.log(err.response ? err.response.data : err);
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
            this.resetErrors();
            if (val && Object.keys(val).length > 0) {
                this.localCustomer = JSON.parse(JSON.stringify(val));
                if (val.province_id && val.province) {
                    this.departmentSelectedId = val.province.department_id;
                    this.provinces = val.province.department ? val.province.department.provinces : [];
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
            this.resetErrors();
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

<style>
/* ==========================================
   ESTILOS POR DEFECTO - MODO CLARO (WHITE THEME)
   ========================================== */
#customerModal .modal-content {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

#customerModal .modal-header {
    background-color: #ffffff !important;
    border-bottom: 1px solid #e2e8f0 !important;
}

#customerModal .modal-title {
    color: #0f172a !important;
    font-weight: 700 !important;
}

#customerModal .modal-header small,
#customerModal .modal-header .text-muted {
    color: #64748b !important;
}

#customerModal .modal-body {
    background-color: #f8fafc !important;
}

#customerModal .modal-footer {
    background-color: #ffffff !important;
    border-top: 1px solid #e2e8f0 !important;
}

#customerModal .card {
    background-color: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03) !important;
}

#customerModal .card-header {
    background-color: #ffffff !important;
    border-bottom: 1px solid #f1f5f9 !important;
}

#customerModal .card-header h6 {
    color: #4f46e5 !important;
    font-weight: 700 !important;
}

#customerModal .form-label {
    color: #1e293b !important;
    font-weight: 600 !important;
}

#customerModal .form-control,
#customerModal .form-select {
    background-color: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #0f172a !important;
}

#customerModal .form-control:focus,
#customerModal .form-select:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
    background-color: #ffffff !important;
    color: #0f172a !important;
}

#customerModal .input-group-text {
    background-color: #f1f5f9 !important;
    border: 1px solid #cbd5e1 !important;
    color: #4f46e5 !important;
}

#customerModal select option {
    background-color: #ffffff !important;
    color: #0f172a !important;
    padding: 10px 14px;
}

#customerModal select option:hover,
#customerModal select option:focus,
#customerModal select option:checked {
    background-color: #e0e7ff !important;
    color: #4338ca !important;
}

#customerModal select option:disabled {
    color: #94a3b8 !important;
    background-color: #f8fafc !important;
}

#customerModal .btn-outline-secondary {
    background-color: #ffffff !important;
    border-color: #cbd5e1 !important;
    color: #334155 !important;
}

#customerModal .btn-outline-secondary:hover {
    background-color: #f1f5f9 !important;
    color: #0f172a !important;
}

#customerModal .btn-close {
    filter: none !important;
    opacity: 0.7 !important;
}

#customerModal .avatar {
    background-color: #e0e7ff !important;
    color: #4f46e5 !important;
}

/* ==========================================
   MODO OSCURO EXPLICITO (DARK MODE ONLY)
   ========================================== */
body.dark-mode #customerModal .modal-content,
[data-bs-theme="dark"] #customerModal .modal-content {
    background-color: #1e1e2d !important;
    color: #e2e8f0 !important;
    border: 1px solid #2b2c40 !important;
}

body.dark-mode #customerModal .modal-header,
body.dark-mode #customerModal .modal-footer,
[data-bs-theme="dark"] #customerModal .modal-header,
[data-bs-theme="dark"] #customerModal .modal-footer {
    background-color: #252538 !important;
    border-color: #2b2c40 !important;
}

body.dark-mode #customerModal .modal-body,
[data-bs-theme="dark"] #customerModal .modal-body {
    background-color: #1e1e2d !important;
}

body.dark-mode #customerModal .modal-title,
[data-bs-theme="dark"] #customerModal .modal-title {
    color: #ffffff !important;
}

body.dark-mode #customerModal .modal-header .text-muted,
[data-bs-theme="dark"] #customerModal .modal-header .text-muted {
    color: #a1a5b7 !important;
}

body.dark-mode #customerModal .card,
[data-bs-theme="dark"] #customerModal .card {
    background-color: #252538 !important;
    border: 1px solid #3a3b54 !important;
}

body.dark-mode #customerModal .card-header,
[data-bs-theme="dark"] #customerModal .card-header {
    background-color: transparent !important;
    border-bottom: 1px solid #3a3b54 !important;
}

body.dark-mode #customerModal .card-header h6,
[data-bs-theme="dark"] #customerModal .card-header h6 {
    color: #7c4dff !important;
}

body.dark-mode #customerModal .form-label,
[data-bs-theme="dark"] #customerModal .form-label {
    color: #d1d5db !important;
}

body.dark-mode #customerModal .form-control,
body.dark-mode #customerModal .form-select,
[data-bs-theme="dark"] #customerModal .form-control,
[data-bs-theme="dark"] #customerModal .form-select {
    background-color: #1b1b29 !important;
    border: 1px solid #3a3b54 !important;
    color: #ffffff !important;
}

body.dark-mode #customerModal .input-group-text,
[data-bs-theme="dark"] #customerModal .input-group-text {
    background-color: #2b2c40 !important;
    border: 1px solid #3a3b54 !important;
    color: #a1a5b7 !important;
}

body.dark-mode #customerModal select option,
[data-bs-theme="dark"] #customerModal select option {
    background-color: #252538 !important;
    color: #e2e8f0 !important;
}

body.dark-mode #customerModal select option:hover,
body.dark-mode #customerModal select option:focus,
body.dark-mode #customerModal select option:checked,
[data-bs-theme="dark"] #customerModal select option:hover,
[data-bs-theme="dark"] #customerModal select option:focus,
[data-bs-theme="dark"] #customerModal select option:checked {
    background-color: #3b3d5c !important;
    color: #ffffff !important;
}

body.dark-mode #customerModal .btn-close,
[data-bs-theme="dark"] #customerModal .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%) !important;
}
</style>

