<template>
    <div class="cardSpace" draggable="true" @dragover.prevent @drop.stop.prevent @dragstart="drag"
        :id="`${entitie.id}`">
        <div :class="`card p-2 cursor-pointer bg-${bgByStatus[status]} text-white`">
            <div class="d-flex">
                <div class="me-2">
                    <span :class="`badge bg-label-${bgByStatus[status]} p-3`"><i
                            :class="`bx bx-${iconByStatus[status]} text-${bgByStatus[status]}`"></i></span>
                </div>
                <div class="d-flex flex-column ps-2">
                    <template v-if="entitie && status == 1">
                        <h6 class="mb-0 py-2 text-white"> {{ entitie.name }}</h6>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-primary" @click="showModalUpdateData(entitie)"><i
                                    class="bx bx-edit"></i></button>
                            <button class="btn btn-icon btn-danger ms-1"><i class='bx bx-user-x'></i></button>
                        </div>
                    </template>
                    <template v-if="entitie.customers">
                        <h6 class="mb-0 py-2 text-white" v-for="customer in entitie.customers" :title="customer.name">{{
                            customer.name.length > 20 ? customer.name.substring(0, 20) + '...' : customer.name ||
                                customer.cell
                        }}
                        </h6>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-primary" @click="editQuotation(entitie)"><i
                                    class="bx bx-edit"></i></button>
                            <button class="btn btn-icon btn-danger ms-1"><i class='bx bx-trash'></i></button>
                        </div>
                    </template>
                    <template v-if="entitie.quotation">
                        <h6 class="mb-0 py-2 text-white" v-for="customer in entitie.quotation.customers"
                            :title="customer.name">{{
                                customer.name.length > 20 ? customer.name.substring(0, 20) + '...' : customer.name ||
                                    customer.cell
                            }}
                        </h6>
                    </template>
                    <!-- <p class="mb-0">S/.{{ formatCant(entitie.amount) }}</p> -->
                </div>
            </div>
        </div>
        <div class="space py-1" :id="'space' + entitie.id" @dragover="changeColor(entitie.id)"
            @dragleave="removeColor(entitie.id)" @drop="dropSpace($event, entitie.id)">
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
                1: 'warning',
                2: 'info',
                3: 'primary',
                4: 'success'
            },
            iconByStatus: {
                1: 'user',
                2: 'file',
                3: 'pen',
                4: 'money'
            }
        }
    },
    methods: {
        showModalUpdateData(customer) {
            console.log('cardentitie', customer);
            this.$emit('showModalUpdateData', customer)
        },
        editQuotation(quotation) {
            this.$router.push({ name: 'home-docs', params: { customerId: quotation.customer_id } })
        }
    }
}
</script>