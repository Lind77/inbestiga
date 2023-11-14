<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row">
                            <span class="h5 mt-2 demo text-body fw-bold">1. Información General </span>
                            <div class="col-6">
                                <div class="card p-2 shadow-none bg-info text-white mb-3">

                                    <div class="card-body">
                                        <h5 class="card-title text-white">{{ customer.name }}
                                        </h5>
                                        <p class="card-text">DNI: {{ customer.dni }}</p>
                                        <p class="card-text">Carrera: {{ customer.career }}</p>
                                        <p class="card-text">Universidad: {{ customer.university }}</p>
                                        <p class="card-text">Celular: {{ customer.cell }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card p-2 shadow-none bg-success text-white mb-3">
                                    <div class="card-body">
                                        <p class="mb-2">Documento Firmado: {{ signedDoc }}</p>
                                        <p class="mb-2" v-if="quotation.contract">Aplicación de instrumentos: {{
                                            quotation.contract.third_article == 1 ? 'Si' : 'No' }}</p>
                                        <p class="mb-2">Servicio Contratado: </p>
                                        <template v-for="detail in quotation.details">
                                            <p v-if="detail.product"> - {{
                                                detail.name }}
                                            </p>
                                        </template>

                                        <p class="mb-2">Tipo de cliente: {{ customer.attitude }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <span class="h5 mt-2 demo text-body fw-bold">2. Estado del trámite universitario</span>
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
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="h5 mt-2 demo text-body fw-bold">3. Información Académica
                                    <button class="btn btn-icon btn-success mx-1" @click="addNewQuestion"
                                        title="Agregar Pregunta">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                    <button class="btn btn-icon btn-warning mx-1" @click="openComunicationsModal"
                                        title="Comunicaciones">
                                        <i class="bx bx-chat"></i>
                                    </button>
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
                            <div class="d-flex mb-3">
                                <template v-for="newQuestion in newQuestions">
                                    <template v-if="newQuestion.type == 5">
                                        <div class="col-6 px-1">
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
                                        <div class="col-6 px-1">
                                            <p class="mb-1">{{ newQuestion.question }}</p>
                                            <select v-model="newQuestion.answer" class="form-select">
                                                <option value="1">Ingeniería</option>
                                                <option value="2">Ciencias Médicas</option>
                                                <option value="3">Derecho</option>
                                                <option value="4">Ciencias Contables</option>
                                            </select>
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <template v-for="newQuestion in newQuestions">
                                <div class="col-4" v-if="newQuestion.type == 3">
                                    <p class="mb-1">{{ newQuestion.question }}</p>
                                    <textarea v-model="newQuestion.answer" class="form-control"></textarea>
                                </div>
                            </template>
                            <template v-for="(newQuestion, index) in newQuestions">
                                <div class="col-4 mt-2" v-if="newQuestion.type == 0">
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
                            </template>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
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
                            <div class="col-4">
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
                            <div class="col-4">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- <span class="h5 mt-2 demo text-body fw-bold">4. Información Adicional</span>
                        <template v-if="doc.properties">
                            <template v-for="property in doc.properties">
                                <template v-if="property.properties">
                                    <p v-for="prop in  JSON.parse(property.properties)" class="text-capitalize">
                                        {{
                                            prop.name }}:{{ prop.val }}</p>
                                </template>
                            </template>
                        </template>
                        <button class="btn btn-icon btn-success" @click="addNewField"><i class="bx bx-plus"></i></button> -->

                        <br>
                        <button class="btn btn-success w-100 mt-2" v-if="docType == 1"
                            @click="saveFields">Almacenar</button>
                        <button class="btn btn-info w-100 mt-2" v-else @click="updateFields">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ComunicationsModal :comunications="customer.comunications" />
</template>
<script>
import axios from 'axios';
import Attrib from './Attrib.vue';
import ComunicationsModal from './ComunicationsModal.vue';

export default {
    components: {
        Attrib, ComunicationsModal
    },
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
                    type: 6
                }
            ],
            comunications: [],
            comunicationOptions: {
                1: 'Llamar',
                2: 'Escribir',
                3: 'Meet'
            },
            properties: [],
            docType: 1
        }
    },
    methods: {
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
            axios.get('/api/quotations/' + this.$route.params.quotationId)
                .then((result) => {
                    console.log(result)
                    this.quotation = result.data
                    this.customer = this.quotation.customers[0]
                    this.comunications = this.customer.comunications
                    if (this.quotation.contract.properties[0]) {
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
                    }
                    console.log(this.properties)
                }).catch((err) => {
                    console.error(err)
                });
        },
        updateFields() {
            const fd = new FormData()
            fd.append('propertiable_id', this.selectedDoc.propertiable_id)
            fd.append('propertiable_type', this.selectedDoc.propertiable_type)
            fd.append('properties', JSON.stringify(this.newQuestions))
            fd.append('_method', 'put')

            axios.post('/api/properties', fd)
                .then((result) => {
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