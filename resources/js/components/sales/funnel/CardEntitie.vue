<template>
    <div class="cardSpace" draggable="true" @dragover.prevent @drop.stop.prevent @dragstart="drag"
        :id="`${entitie.id}`">
        <div :class="`card p-2 cursor-pointer bg-${bgByStatus[entitieStatus]} text-white`" :id="`card${entitie.id}`">
            <div class="d-flex">
                <div class="me-2">
                    <span :class="`badge bg-label-${bgByStatus[entitieStatus]} p-3`"><i
                            :class="`bx bx-${iconByStatus[entitieStatus]} text-${bgByStatus[entitieStatus]}`"></i></span>
                </div>
                <div class="d-flex flex-column ps-2">
                    <template v-if="entitie && status == 1">
                        <h6 class="mb-0 py-2 text-white"> {{ entitie.name }}</h6>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-primary" @click="showModalUpdateData(entitie)"><i
                                    class="bx bx-edit"></i></button>
                            <button class="btn btn-icon btn-danger ms-1" v-if="entitieStatus == 1"
                                @click="noConnect(entitie)"><i class='bx bx-user-x'></i></button>
                            <button class="btn btn-icon btn-success ms-1" @click="toQuotation(entitie)"><i
                                    class='bx bx-file'></i></button>
                        </div>
                    </template>
                    <template v-if="entitie.customers">
                        <h6 class="mb-0 py-2 text-white" v-for="customer in entitie.customers" :title="customer.name">{{
                            customer.name.length > 20 ? customer.name.substring(0, 20) + '...' : customer.name
                        }}
                        </h6>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-primary" @click="editQuotation(entitie)"><i
                                    class="bx bx-edit"></i></button>
                            <button class="btn btn-icon btn-danger ms-1" @click="deleteQuotation(entitie)"><i
                                    class='bx bx-trash'></i></button>
                            <button class="btn btn-icon btn-success ms-1" @click="toOrder(entitie)"><i
                                    class='bx bx-file'></i></button>
                        </div>
                    </template>
                    <template v-if="entitie.quotation">
                        <h6 class="mb-0 py-2 text-white" v-for="customer in entitie.quotation.customers"
                            :title="customer.name">{{
                                customer.name.length > 20 ? customer.name.substring(0, 20) + '...' : customer.name
                            }}
                        </h6>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-info" @click="toOrder(entitie.quotation)"><i
                                    class="bx bx-edit"></i></button>
                            <button class="btn btn-icon btn-danger ms-1" @click="deleteContract(entitie)"><i
                                    class='bx bx-trash'></i></button>
                        </div>
                    </template>
                    <!-- <p class="mb-0">S/.{{ formatCant(entitie.amount) }}</p> -->
                </div>
            </div>
        </div>
        <div class="space py-1" :id="'space' + entitie.id" @dragover="changeColor(entitie.id)"
            @dragleave="removeColor(entitie.id)" @drop="dropSpace">
        </div>
    </div>
</template>
<script>
export default {
    props: {
        entitie: Object,
        status: Number
    },
    data() {
        return {
            bgByStatus: {
                0: 'danger',
                1: 'warning',
                2: 'info',
                3: 'primary',
                4: 'success'
            },
            iconByStatus: {
                0: 'user',
                1: 'user',
                2: 'file',
                3: 'pen',
                4: 'money'
            },
            entitieStatus: this.status
        }
    },
    methods: {
        dropSpace(e) {
            var customerId = e.dataTransfer.getData('customerId')
            e.dataTransfer.setData('quotationId', this.entitie.id)
            if (this.status == 1) {
                this.$router.push({ name: 'home-docs', params: { customerId: customerId } })
            } else {
                this.$router.push({ name: 'contract-orders', params: { quotationId: customerId } })
            }
        },
        noConnect(customer) {
            this.entitieStatus = 0
        },
        showModalUpdateData(customer) {
            console.log('cardentitie', customer);
            this.$emit('showModalUpdateData', customer)
        },
        editQuotation(quotation) {
            this.$router.push({ name: 'home-docs', params: { customerId: quotation.customer_id } })
        },
        deleteQuotation(quotation) {
            if (confirm('Tienes la seguridad de eliminar esta cotización?')) {
                axios.delete('/api/quotations/' + quotation.id)
                    .then((result) => {
                        this.$swal('Cotización eliminada correctamente')
                        this.$parent.getCustomers()
                    }).catch((err) => {
                        this.$swal('Hubo un error')
                    });
            }

        },
        deleteContract(contract) {
            if (confirm('Tienes la seguridad de eliminar este contrato?')) {
                axios.delete('/api/contracts/' + contract.id)
                    .then((result) => {
                        this.$swal('Contrato eliminado correctamente')
                        this.$parent.getCustomers()
                    }).catch((err) => {
                        this.$swal('Hubo un error')
                    });
            }

        },
        changeColor(index) {
            console.log(index)
            var spaceSelected = document.getElementById('space' + index)
            spaceSelected.classList.add('space-show')
        },
        removeColor(index) {
            document.getElementById('space' + index).classList.remove('space-show')
        },
        drag(e) {
            if (this.quotation) {
                e.dataTransfer.setData('quotationId', this.entitie.id)
                e.dataTransfer.setData('type', 2)
            } else {
                e.dataTransfer.setData('customerId', this.entitie.id)
                e.dataTransfer.setData('type', 1)
            }
        },
        toOrder(quotation) {
            console.log(quotation);
            $('#funnelModal').modal('hide')
            if (quotation.amount <= 1500) {
                this.$router.push({ name: 'contract-orders', params: { quotationId: quotation.id } })
            } else {
                this.$router.push({ name: 'contract-orders', params: { quotationId: quotation.id } })
            }

            /* $('#funnelModal').modal('hide')
            this.$router.push({ name: 'edit-quotation', params: { idQuotation: quotationId } }) */
        },
        toQuotation(customer) {
            this.$router.push({ name: 'home-docs', params: { customerId: customer.id } })
        }
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