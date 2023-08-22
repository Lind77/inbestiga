<template>
    <div class="cardSpace" draggable="true" @dragover.prevent @drop.stop.prevent @dragstart="drag" :id="`${quotation.id}`"
        @click="showModalFunnel(quotation)">
        <div :class="`card bg-${bgColor} p-2 cursor-pointer`">
            <template v-if="quotation">
                <p class="text-white mb-0">S/.{{ quotation.amount }}</p>
                <h6 class="mb-0 py-2 text-white" v-for="customer in quotation.customers">{{ customer.name || customer.cell
                }}
                </h6>
            </template>
        </div>
        <div class="space" :id="'space' + quotation.id" @dragover="changeColor(quotation.id)"
            @dragleave="removeColor(quotation.id)" @drop="dropSpace($event, quotation.id)">
        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    data() {
        return {
            customer_selected: {},
            comunication: {
                1: 'Llamar',
                2: 'Escribir',
                3: 'Meet'
            },
            statusCard: 0,
            orders: [],
            customers: []
        }
    },
    props: {
        customer: Object,
        status: Number,
        visible: Boolean,
        quotation: Object
    },
    methods: {
        showModalFunnel(quotation) {
            console.log(quotation);
            this.$emit('showModalQuotationFunnel', quotation)
        },
        removeColor(index) {
            document.getElementById('space' + index).classList.remove('space-show')
        },
        changeColor(index) {
            document.getElementById('space' + index).classList.add('space-show')
        },
        dropSpace(e, index) {
            if (this.status <= 4) {
                var customerId = e.dataTransfer.getData('customerId')
                this.$emit('updateStatusPrelead', customerId)
            }
            var typeCard = e.dataTransfer.getData('type')
            console.log(typeCard);
            if (typeCard == 1) {
                console.log('tipo 1');
                var customerId = e.dataTransfer.getData('customerId')
                this.$emit('transformLead', customerId)
            } else {
                console.log('tipo 2');
                var quotationId = e.dataTransfer.getData('quotationId')
                console.log(quotationId);
                this.$emit('updateStatusSpace', quotationId)
            }
            console.log('dropeando en el espacio');

            document.getElementById('space' + index).classList.remove('space-show')
        },
        showModalUpdateCom() {
            this.$emit('showModalUpdateCom', this.customer.comunication)
        },
        showModalUpdateData() {
            this.$emit('showModalUpdateData', this.customer)
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
        customerStandBy(id) {
            this.$swal.fire('Tienes la seguridad de enviar a este usuario a stand by?')
                .then((res) => {
                    if (res.isConfirmed) {
                        axios.get('/api/standByCustomer/' + id)
                            .then(res => {
                                console.log(res)
                            })
                            .catch(err => {

                            })
                    }
                })
        },
        allowDrop(e) {
            return
        },
        drag(e) {
            console.log(this.quotation);
            if (this.quotation.customers) {
                e.dataTransfer.setData('quotationId', this.quotation.id)
                e.dataTransfer.setData('type', 2)
            } else {
                e.dataTransfer.setData('customerId', this.customer.id)
                e.dataTransfer.setData('type', 1)
            }
        },
        rejectDrop(id) {
            e.preventDefault()
        },
        convertLead(id) {
            this.$emit('convertLead', id)
        },
        openProductModal(customer) {
            console.log('asignando customer')
            this.$emit('selectCustomer', customer)
            $('#productModal').modal('show')
        }
    },
    computed: {
        bgColor() {
            if (this.customer.status == 0) {
                return 'dark'
            } else if (this.customer.status == 1 || this.customer.attitude == 1) {
                return 'warning'
            } else if (this.customer.status == 2 || this.customer.attitude == 2) {
                return 'info'
            } else if (this.customer.status == 3 || this.customer.attitude == 3) {
                return 'success'
            }
            else if (this.quotation.status > 4 && this.quotation.status < 11) {
                if (this.quotation.interest == 1) {
                    return 'danger'
                } else if (this.quotation.interest == 2) {
                    return 'info'
                } else if (this.quotation.interest == 3) {
                    return 'success'
                } else {
                    return 'secondary'
                }
            } else if (this.customer.status == 11) {
                return 'warning'
            }
        },
        verifyOrders() {
            return this.customer.quotations.some(quotation => {
                return quotation.orders?.length > 0
            })
        }
    },
    mounted() {
        this.statusCard = this.customer.status
    }
}
</script>
<style scoped>
.space {
    height: 10px;
    border-radius: 5px;
}

.space-show {
    background-color: #696cff;
}

.bg-hover {
    background-color: #696cff;
}

.pt-10 {
    margin-top: 100px;
}
</style>