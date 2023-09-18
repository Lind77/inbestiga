<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row">
                            <span class="h5 mt-2 demo text-body fw-bold">1. Información General </span>
                            <div class="col-4">
                                <div class="card p-2 shadow-none bg-transparent border border-primary mb-3">
                                    <h5 class="card-title">{{ customer.name }}
                                    </h5>
                                    <p class="card-text">DNI: {{ customer.dni }}</p>
                                    <p class="card-text">Carrera: {{ customer.career }}</p>
                                    <p class="card-text">Universidad: {{ customer.university }}</p>
                                    <p class="card-text">Celular: {{ customer.cell }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card p-2 shadow-none bg-transparent border border-success mb-3">
                                    <p class="mb-1">Documento Firmado: {{ signedDoc }}</p>
                                    <p class="mb-1" v-if="quotation.contract">Aplicación de instrumentos: {{
                                        quotation.contract.third_article == 1 ? 'Si' : 'No' }}</p>
                                    <p class="mb-1">Servicio Contratado: </p>
                                    <p v-for="detail in quotation.details">- {{
                                        detail.product.name }}
                                    </p>
                                    <p class="mb-1">Tipo de cliente: {{ customer.attitude }}</p>

                                </div>
                            </div>
                            <div class="col-4">

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
                                            <td>Tema</td>
                                            <td>Plan de Tesis</td>
                                            <td>Observaciones del Plan de Tesis</td>
                                            <td>Aprobación del plan de tesis</td>
                                            <td>Aplicación de instrumentos</td>
                                            <td>Elaboración del Informe final</td>
                                            <td>Observaciones del informe final</td>
                                            <td>Revisión de jurados</td>
                                            <td>Sustentación final</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon btn-success">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card invoice-preview-card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <span class="h5 mt-2 demo text-body fw-bold">3. Información Académica <button
                                    class="btn btn-icon btn-success" @click="addNewQuestion"><i
                                        class="bx bx-plus"></i></button> </span>
                            <p class="mb-1" v-if="customer.user">Asesor Comercial: {{ customer.user.name }}
                            </p>
                            <div v-for="newQuestion in newQuestions" class="card bg-success p-2 col-6 ms-2">
                                <input type="text" class="form-control form-control-sm w-75"
                                    placeholder="Pregunta o atributo" v-model="question">
                                <textarea name="" id="" cols="30" rows="3" class="form-control mt-1"
                                    placeholder="Valor o respuesta" v-model="answer"></textarea>
                            </div>
                            <Attrib />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <span class="h5 mt-2 demo text-body fw-bold">4. Información Adicional</span>
                        <template v-if="doc.properties">
                            <template v-for="property in doc.properties">
                                <template v-if="property.properties">
                                    <p v-for="prop in  JSON.parse(property.properties)" class="text-capitalize">
                                        {{
                                            prop.name }}:{{ prop.val }}</p>
                                </template>
                            </template>
                        </template>
                        <button class="btn btn-icon btn-success" @click="addNewField"><i class="bx bx-plus"></i></button>
                        <template v-for="newField in newFields">
                            <div class="d-flex">
                                <input type="text" class="form-control" v-model="newField.name">
                                :
                                <input type="text" class="form-control" v-model="newField.val">
                            </div>
                        </template>
                        <br>
                        <button class="btn btn-success mt-2" @click="saveFields">Almacenar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Attrib from './Attrib.vue';

export default {
    components: {
        Attrib
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
            newQuestions: []
        }
    },
    methods: {
        addNewQuestion() {
            var newQuestion = {
                question: '',
                answer: ''
            }

            this.newQuestions.push({ ...newQuestion })
        },
        getQuotation() {
            axios.get('/api/quotations/' + this.$route.params.quotationId)
                .then((result) => {
                    this.quotation = result.data
                    this.customer = this.quotation.customers[0]
                }).catch((err) => {
                    console.error(err)
                });
        },
        saveFields() {

            this.newFields.forEach(newField => {
                var slug = newField.name
                    .toString()    // Convert input to string (optional)
                    .toLowerCase()    // Convert the string to lowercase letters
                    .trim()    // Remove whitespace from both sides of the string
                    .replace(/\s+/g, '-')

                newField.slug = slug
            })

            const fd = new FormData()

            fd.append('propertiable_id', this.selectedDoc.propertiable_id)
            fd.append('propertiable_type', this.selectedDoc.propertiable_type)
            fd.append('properties', JSON.stringify(this.newFields))

            axios.post('/api/properties', fd)
                .then((result) => {
                    this.getQuotation()
                    this.newFields = []
                    this.$swal('Json insertado')
                }).catch((err) => {
                    console.error(err)
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