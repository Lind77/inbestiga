<template>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2" v-if="!ableFormDelivery">Agregar Reunión</h5>
                    <h5 class="modal-title" id="exampleModalLabel2" v-else>Agregar Entrega</h5>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                            v-model="ableFormDelivery">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Entrega</label>
                    </div>
                </div>
                <div class="modal-body" v-if="!ableFormDelivery">
                    <div class="row">
                        <div class="col mb-1">
                            <label for="nameSmall" class="form-label">Fecha:</label>
                            <input type="date" :value="info.dateStr" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Título</label>
                            <input type="text" v-model="title" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Comentario</label>
                            <textarea v-model="comment" cols="3" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Link de Meet (Opcional)</label>
                            <input type="text" v-model="link" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-body" v-else>
                    <div class="row">
                        <div class="input-group">
                            <input v-model="name" type="text" class="form-control" placeholder="Nombre del cliente"
                                aria-label="Recipient's username" aria-describedby="button-addon2"
                                @keyup.enter="searchContract">
                            <button class="btn btn-outline-primary" type="button" id="button-addon2"
                                @click="searchContract"><i class='bx bx-search'></i></button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="alert alert-warning" role="alert" v-show="noResults">No se han encontrado contratos ni
                            ordenes que
                            coincidan con el nombre de este usuario.</div>
                        <div class="col-6 mb-2" v-for="result in results">
                            <button :class="`btn btn-sm ${result.type == 1 ? 'btn-success' : 'btn-info'}  w-100`"
                                @click="selectDocument(result)">{{ result.name }} - {{
                                    result.date }}</button>
                        </div>
                    </div>
                    <div class="row" v-show="showFields">
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Fecha</label>
                            <input type="date" v-model="date" class="form-control" />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Avance</label>
                            <input type="text" v-model="advance" class="form-control" />
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nameBasic" class="form-label">Fecha Académica</label>
                            <input type="date" v-model="dateAcad" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Salir
                    </button>
                    <button v-if="!ableFormDelivery" type="button" class="btn btn-primary"
                        @click="addEvent">Asignar</button>
                    <button v-else type="button" class="btn btn-primary" @click="insertDelivery">Asignar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';

export default {
    data() {
        return {
            title: '',
            comment: '',
            link: '',
            ableFormDelivery: false,
            results: [],
            noResults: false,
            contracts: [],
            orders: [],
            showFields: false,
            resultId: 0,
            resultType: 0,
            date: '',
            advance: '',
            dateAcad: ''
        }
    },
    props: {
        info: Object
    },
    methods: {
        selectDocument(result) {
            this.showFields = true
            this.resultId = result.id
            this.resultType = result.type
        },
        formatOrderDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        addEvent() {
            var newEvt = {
                title: this.title,
                date: this.info.dateStr,
                comment: this.comment,
                link: this.link,
                backgroundColor: '#e7e7ff',
                borderColor: '#e7e7ff',
                textColor: '#696cff'
            }

            this.$emit('addEvent', newEvt)

            this.title = ''
            this.link = ''
            this.comment = ''
        },
        insertDelivery() {

            const fd = new FormData()
            fd.append('deliverable_id', this.resultId)
            fd.append('type', this.resultType)
            fd.append('date', this.date)
            fd.append('advance', this.advance)
            fd.append('dateAcad', this.dateAcad)

            axios.post('/api/delivery', fd)
                .then((result) => {
                    $('#eventModal').modal('hide')
                    this.$emit('getDeliveries')
                    this.$emit('getEvents')
                }).catch((err) => {
                    console.error(err)
                });
        },
        searchContract() {
            this.results = []
            this.noResults = false
            axios.get('/api/contract/' + this.name)
                .then((result) => {
                    this.contracts = result.data.contracts;
                    this.orders = result.data.orders;
                    if (this.contracts.length == 0 && this.orders.length == 0) {
                        this.noResults = true
                    }
                    var result = {
                        id: 0,
                        name: '',
                        date: '',
                        type: 0
                    }

                    this.contracts.forEach((contract) => {
                        result.id = contract.id
                        result.name = contract.quotation.customers[0].name
                        result.date = this.formatOrderDate(contract.date)
                        result.type = 1
                        this.results.push({ ...result })
                    })

                    this.orders.forEach((order) => {
                        result.id = order.id
                        result.name = order.quotation.customers[0].name
                        result.date = this.formatOrderDate(order.created_at)
                        result.type = 2
                        this.results.push({ ...result })
                    })


                }).catch((err) => {
                    console.error(err);
                });
        },
    }
}
</script>
<style lang="">
    
</style>