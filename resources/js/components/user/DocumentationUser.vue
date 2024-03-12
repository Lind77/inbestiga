<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <div class="card mb-2 px-0">
                <div class="user-profile-header-banner">
                    <img src="https://inbestiga.com/ficha_proyecto.jpg" alt="Banner image" class="rounded-top w-100">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">

                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <!-- <p>Id de Contrato: {{ quotation.contract.id }}</p> -->
                                <div class="row">
                                    <span class="h5 mt-2 demo text-body fw-bold">1. Información General </span>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="mb-2"><span class="fw-bold">Documento Firmado:</span> {{ signedDoc
                                                }}
                                            </p>

                                            <p class="mb-2" v-if="quotation.contract"><span class="fw-bold">Lugar o
                                                    contexto
                                                    de estudio:</span> {{
                                                quotation.contract.third_article_place == 1 ? 'Tesista' : 'Inbestiga' }}
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <p class="mb-2"><span class="fw-bold">Servicio Contratado </span></p>
                                            <p v-for="detail in quotation.details"> - {{
                                                detail.name }}
                                            </p>
                                        </div>
                                        <div class="col-4">
                                            <p class="mb-2" v-if="quotation.contract"><span class="fw-bold">Aplicación
                                                    de
                                                    instrumentos:</span> {{
                                                quotation.contract.third_article == 1 ? 'Tesista' : 'Inbestiga' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                                <i class="bx bx-user-check me-1"></i>Connected
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="h5 mt-2 demo text-body fw-bold">2. Clientes </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3" v-for="customer in quotation.customers">
                            <div class="card bg-primary p-2 mb-2">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title m-0 me-2 text-white" :title="customer.name">{{
                                                customer.name.substring(0,
                                                    13)
                                            }}</h5>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="employeeList"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded text-white"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList"
                                            style="">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                @click="updateCustomer(customer)">Editar</a>
                                            <a v-if="quotation.customers.length >= 2" class="dropdown-item"
                                                href="javascript:void(0);"
                                                @click="deleteCustomerContract(customer.id, quotation.id)">Eliminar</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2 text-white">
                                        <li class="list-inline-item fw-medium">
                                            <i class="bx bx-id-card"></i> {{ customer.dni }}
                                        </li>
                                        <li class="list-inline-item fw-medium">
                                            <i class="bx bx-pen"></i> {{ customer.career }}
                                        </li>
                                        <li class="list-inline-item fw-medium">
                                            <i class="bx bxs-graduation"></i> {{ customer.university }}
                                        </li>
                                        <li class="list-inline-item fw-medium">
                                            <i class="bx bx-phone"></i> {{ customer.cell }}
                                        </li>
                                        <li class="list-inline-item fw-medium">
                                            <i class='bx bx-street-view'></i> Actitud: {{
                                                customer.attitude ? customer.attitude : '-' }}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card invoice-preview-card mt-2">
                <div class="card-body">
                    <div class="row">
                        <span class="h5 mt-2 demo text-body fw-bold">3. Estado del trámite universitario</span>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <template v-for="newQuestion in newQuestions">
                                            <td v-if="newQuestion.type == 2">{{ newQuestion.question }}</td>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <template v-for="newQuestion in newQuestions">
                                            <td v-if="newQuestion.type == 2">
                                                <input type="checkbox" class="form-check-input"
                                                    v-model="newQuestion.answer">
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-12 mb-lg-0 mb-4">

                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <span class="h5 m-2 demo text-body fw-bold">4. Información Académica
                                    <!-- <button class="btn btn-icon btn-success mx-1" @click="addNewQuestion"
                                        title="Agregar Pregunta">
                                        <i class="bx bx-plus"></i>
                                    </button> -->
                                    <!--  <button class="btn btn-icon btn-warning mx-1" @click="openComunicationsModal"
                                        title="Comunicaciones">
                                        <i class="bx bx-chat"></i>
                                    </button> -->
                                    <!-- <button class="btn btn-icon btn-primary mx-1" title="Link de Google Drive">
                                    <i class='bx bxl-google'></i>
                                </button> -->
                                </span>
                                <span>
                                </span>
                            </div>
                            <div>

                                <span v-if="customer.user" class="bg-info rounded w-auto p-2 text-white fw-bold">
                                    <i class='bx bx-user-pin'></i> {{ customer.user.name }}
                                </span>
                            </div>
                        </div>
                        <div class="row">

                            <template v-for="newQuestion in newQuestions">
                                <template v-if="newQuestion.type == 5">
                                    <div class="col-12 px-1">
                                        <p class="mb-1">{{ newQuestion.question }}</p>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon11"><i
                                                    class='bx bxl-google'></i></span>
                                            <input type="text" class="form-control" v-model="newQuestion.answer"
                                                placeholder="Link de Drive">
                                        </div>
                                    </div>
                                </template>
                                <template v-if="newQuestion.type == 6">
                                    <div class="col-12 px-1">
                                        <p class="mb-1">{{ newQuestion.question }}</p>
                                        <select v-model="newQuestion.answer" class="form-select">
                                            <option :value="`${index + 1}`"
                                                v-for="(option, index) in newQuestion.options">
                                                {{
                                                option }}</option>
                                        </select>
                                    </div>
                                </template>
                            </template>


                            <template v-for="newQuestion in newQuestions">
                                <div class="col-12" v-if="newQuestion.type == 3">
                                    <p class="mb-1">{{ newQuestion.question }}</p>
                                    <textarea v-model="newQuestion.answer" class="form-control"></textarea>
                                </div>
                            </template>
                            <!-- <template v-for="(newQuestion, index) in newQuestions">
                                <div class="col-12 mt-2" v-if="newQuestion.type == 0">
                                    <div class="card p-2 shadow">
                                        <div class="d-flex">
                                            <input type="text" class="form-control form-control-sm w-75"
                                                placeholder="Pregunta o atributo" v-model="newQuestion.question">
                                            <button @click="deleteNewQuestion(index)"
                                                class="btn btn-icon btn-danger btn-sm ms-2"><i class="bx bx-x"></i></button>
                                        </div>

                                        <textarea name="" id="" cols="30" rows="3" class="form-control mt-1"
                                            placeholder="Valor o respuesta" v-model="newQuestion.answer"></textarea>
                                    </div>
                                </div>
                            </template> -->
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <p class="fw-bold">a. Documentación Requerida</p>
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <template v-for="newQuestion in newQuestions">
                                            <template v-if="newQuestion.type == 4 && newQuestion.subtype == 'a'">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="newQuestion.answer" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1"> {{
                                                newQuestion.question }}</label>
                                                </div>
                                            </template>

                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="fw-bold">b. Beneficios Ofrecidos</p>
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <template v-for="newQuestion in newQuestions">
                                            <template v-if="newQuestion.type == 4 && newQuestion.subtype == 'b'">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="newQuestion.answer" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1"> {{
                                                newQuestion.question }}</label>
                                                </div>
                                            </template>

                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="fw-bold">c. ¿Qué reuniones ya se ha tenido con el cliente?</p>
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <template v-for="newQuestion in newQuestions">
                                            <template v-if="newQuestion.type == 4 && newQuestion.subtype == 'c'">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="newQuestion.answer" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1"> {{
                                                newQuestion.question }}</label>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                                <!--  <button class="btn btn-success w-100 mt-2" @click="saveFields">Insertar</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <label for="">Nueva Actualización</label>
                        <input type="text" v-model="newUpdate.question" placeholder="Título..." class="form-control">
                        <textarea placeholder="Cuerpo..." v-model="newUpdate.answer" class="form-control mt-2"
                            rows="5"></textarea>

                        <button class="btn btn-info w-100 mt-2" @click="updateFields">Actualizar</button>
                    </div>
                </div> -->
                <!-- <div class="card mt-2 bg-success">
                    <div class="card-body text-white">
                        <h4 class="text-white">Cotización</h4>
                        <p>{{ formatDate(quotation.created_at) }}</p>
                    </div>
                </div> -->

                <template v-for="(newQuestion, index) in newQuestions.slice().reverse()">
                    <div class="col-12 mt-2" v-if="newQuestion.type == 0">
                        <div class="card bg-warning p-2 shadow">
                            <div class="card-body text-white">
                                <h4 class="text-white">{{ newQuestion.question }}</h4>
                                <p>{{ newQuestion.answer }}</p>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="card mt-2 bg-success" v-for="comunication in  customer.comunications">
                    <div class="card-body text-white">
                        <h4 class="text-white">Comunicación con ventas</h4>
                        <p>{{ comunication.comment }}</p>
                        {{ formatDate(comunication.created_at) }}
                    </div>
                </div>
                <div class="card mt-2 bg-info text-white">
                    <div class="card-body">
                        <h4 class="text-white">Registro inicial</h4>
                        {{ formatDate(customer.created_at) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <ComunicationsModal :comunications="customer.comunications" />
    <customerModal :action="action" :customer="customerSelected" /> -->
</template>
<script>
import moment from 'moment';
import axios from 'axios';

export default {
    data() {
        return {
            quotation: {},
            customer: {},
            selectedDoc: {
                propertiable_id: 0,
                propertiable_type: ''
            },
            newFields: [],
            doc: {},
            newQuestions: [
                {
                    question: 'Tema',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Plan de Tesis',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Observaciones del Plan de Tesis',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Aprobación del Plan de Tesis',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Aplicación de instrumentos',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Elaboración de Informe Final',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Observaciones del informe final',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Revisión de jurados',
                    answer: false,
                    type: 2
                },
                {
                    question: 'Sustentación Final',
                    answer: false,
                    type: 2
                },
                {
                    question: '¿Sobre que desea investigar?',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Lugar de investigación',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Propuesta de población',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Levantamiento de observaciones:',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Si cuenta con un avance, ¿Cúal es?',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Otros',
                    answer: '',
                    type: 3
                },
                {
                    question: 'Reglamento / lineamientos de investigación',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Estructura del plan de tesis',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Estructura del informe final',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Plantilla',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Manual de estilo de redacción (APA, ISO, Vancouver) (opcional)',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Línea de investigación',
                    answer: false,
                    type: 4,
                    subtype: 'a'
                },
                {
                    question: 'Diapositivas',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Plantilla de diapositivas',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Balotario de preguntas',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Guía de sustentación',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Reporte de turnitin',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Otro',
                    answer: false,
                    type: 4,
                    subtype: 'b'
                },
                {
                    question: 'Reunión de bienvenida',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Reunión de apertura académica',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Reunión de explicación de plan de tesis',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Reunión explciativa de informe final',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Asesoría para sustentación',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Otra reunión',
                    answer: false,
                    type: 4,
                    subtype: 'c'
                },
                {
                    question: 'Link de Drive',
                    answer: '',
                    type: 5
                },
                {
                    question: 'Rama de investigación',
                    answer: 0,
                    type: 6,
                    options: ['Ingeniería', 'Ciencias médicas', 'Derecho', 'Ciencias contables', 'Ciencias sociales']
                },
                {
                    question: 'Modalidad de titulación',
                    answer: 0,
                    type: 6,
                    options: ['Curso de universidad', 'Curso de Maestría', 'Curso de titulación', 'Regular(Sustentación)', 'Por Publicación(Artículo)']
                },
                {
                    question: 'VIP',
                    answer: 0,
                    type: 6,
                    options: ['Maestría', 'Doctorado', 'Referido', 'Ninguno']
                }
            ],
            comunications: [],
            comunicationOptions: {
                1: 'Llamar',
                2: 'Escribir',
                3: 'Meet'
            },
            properties: [],
            docType: 1,
            newUpdate: {
                question: '',
                answer: '',
                type: 0
            },
            customerSelected: {},
            action: 0
        }
    },
    methods: {
        deleteCustomerContract(customerId, quotationId) {
            if (confirm('Tienes la seguridad de eliminar este usuario? Recuerda que modificará el contrato y cotización')) {
                axios.get(`/api/customer-contract/${customerId}/${quotationId}`)
                    .then((result) => {
                        console.log(result.data)
                        this.getQuotation()
                    }).catch((err) => {
                        console.log(err)
                    });
            }

        },
        updateCustomer(customer) {
            this.customerSelected = customer
            this.action = 2
            $('#customerModal').modal('show')
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        deleteNewQuestion(index) {
            console.log(index);
            this.newQuestions.splice(index, 1);
        },
        openComunicationsModal() {
            $('#ComunicationsModal').modal('show')
        },
        addNewQuestion() {
            console.log('new question')
            var newQuestion = {
                question: '',
                answer: '',
                type: 0
            }

            this.newQuestions.push({ ...newQuestion })
        },
        getQuotation() {
            this.$swal.fire({
                title: 'Cargando...',
                allowOutsideClick: false,
                showConfirmButton: false
            })
            axios.get('/api/quotations/' + this.$route.params.quotationId)
                .then((result) => {
                    this.quotation = result.data
                    console.log(this.quotation)
                    this.customer = this.quotation.customers[0]
                    this.comunications = this.customer.comunications
                    if (this.quotation.contract && this.quotation.contract.properties[0]) {
                        this.newQuestions = JSON.parse(this.quotation.contract.properties[0].properties)
                        this.docType = 2
                        var findDriveField = this.newQuestions.find(question => question.type == 5)
                        var findBranchInvestigation = this.newQuestions.find(question => question.type == 6)

                        if (!findDriveField) {
                            this.newQuestions.push({
                                question: 'Link de Drive',
                                answer: '',
                                type: 5
                            })
                        }

                        if (!findBranchInvestigation) {
                            this.newQuestions.push({
                                question: 'Rama de investigación',
                                answer: 0,
                                type: 6
                            })
                        }
                    } else if (this.quotation.order) {
                        if (this.quotation.order.properties[0]) {
                            this.newQuestions = JSON.parse(this.quotation.order.properties[0].properties)
                        }

                    }
                    this.$swal.close()
                    console.log(this.properties)
                }).catch((err) => {
                    console.error(err)
                });
        },
        updateFields() {
            const fd = new FormData()
            this.newQuestions.push({ ...this.newUpdate })
            fd.append('propertiable_id', this.selectedDoc.propertiable_id)
            fd.append('propertiable_type', this.selectedDoc.propertiable_type)
            fd.append('properties', JSON.stringify(this.newQuestions))
            fd.append('_method', 'put')

            axios.post('/api/properties', fd)
                .then((result) => {
                    this.newUpdate = {
                        question: '',
                        answer: '',
                        type: 0
                    }
                    this.$swal('Documentación de proyecto actualizada correctamente')
                }).catch((err) => {
                    this.$swal('Hubo un error')
                });
        },
        saveFields() {
            const fd = new FormData()

            fd.append('propertiable_id', this.selectedDoc.propertiable_id)
            fd.append('propertiable_type', this.selectedDoc.propertiable_type)
            fd.append('properties', JSON.stringify(this.newQuestions))

            axios.post('/api/properties', fd)
                .then((result) => {
                    this.$swal('Documentación de proyecto almacenada correctamente')
                }).catch((err) => {
                    this.$swal('Hubo un error')
                });
        },
        addNewField() {
            var newField = {
                name: '',
                val: ''
            }
            this.newFields.push({ ...newField })
        },
    },
    computed: {
        signedDoc() {
            if (this.quotation) {
                if (this.quotation.contract != null) {
                    this.selectedDoc.propertiable_id = this.quotation.contract.id
                    this.selectedDoc.propertiable_type = 'App\\Models\\Contract'
                    this.doc = this.quotation.contract
                    return 'Contrato'
                } else if (this.quotation.order != null) {
                    this.selectedDoc.propertiable_id = this.quotation.order.id
                    this.selectedDoc.propertiable_type = 'App\\Models\\Order'
                    this.doc = this.quotation.order
                    return 'Orden'
                }
            }

        }
        /* slugify(string) {
            console.log(typeof string)
            return     // Replace spaces with hyphen (-)
        } */
    },
    mounted() {
        this.getQuotation()
    }
}
</script>
<style lang="">

</style>