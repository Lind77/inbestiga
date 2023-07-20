<template>
    <div class="alert alert-primary d-flex" role="alert"><span
            class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
                class="bx bx-user fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">{{ customer.name }}</h6>
            <span>{{ customer.cell }}</span>
            <span>{{ customer.university }}</span>
            <span>{{ customer.career }}</span>
            <span v-if="customer.dni">{{ customer.dni }}</span>
            <span v-else>DNI: <input type="text" v-model="dni" class="form-control form-control-sm"></span>
            <span v-if="customer.address">{{ customer.address }}</span>
            <span v-else>Dirección: <input type="text" v-model="address" class="form-control form-control-sm"></span>
            <button v-if="customer.address == null || customer.dni == null" class="btn btn-primary btn-sm mt-3"
                @click="saveDni">Actualizar Datos</button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dni: '',
            address: ''
        }
    },
    props: {
        customerSelected: Object,
        customer: Object
    },
    methods: {
        saveDni() {
            const fd = new FormData()
            fd.append('id_customer', this.customer.id)
            fd.append('dni', this.dni)
            fd.append('address', this.address)
            axios.post('/api/updateDniCustomer', fd)
                .then((res) => {
                    this.$emit('getQuotation')
                })
                .catch((err) => {
                    console.error(err)
                })
        },
    }
}
</script>