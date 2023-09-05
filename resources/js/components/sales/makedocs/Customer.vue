<template>
    <div class="card shadow-none bg-info text-white mb-3" v-if="customer.id">
        <div class="card-body">
            <h5 class="card-title text-white">Cliente: {{ customer.name }} <i @click="deleteCustomer(customer.id)"
                    class='bx bx-x'></i> <i @click="showEditCustomer(customer)" class='bx bx-edit'></i></h5>
            <p class="card-text mb-0">
                Teléfono: {{ customer.cell }}
            </p>
            <p class="card-text mb-0">
                Carrera: {{ customer.career }}
            </p>
            <p class="card-text mb-0">
                Universidad: {{ customer.university }}
            </p>
            <p class="card-text mb-0">
                <label for="">DNI:</label>
                <span v-if="customer.dni != null">{{ customer.dni }}</span>
                <input v-else type="text" v-model="dni" class="form-control form-control-sm">

            </p>
            <p class="card-text mb-0">
                <label for="">Dirección:</label>
                <span v-if="customer.dni != null">{{ customer.address }}</span>
                <input v-else type="text" v-model="address" class="form-control form-control-sm">
            </p>
            <button v-if="customer.dni == null || customer.address == null" @click="saveDni"
                class="btn btn-success btn-sm mt-2">Actualizar datos</button>
        </div>
    </div>
    <customerModal :action="2" :customer="customer_selected" />
</template>
<script>
import customerModal from '../customers/customerModal.vue'

export default {
    components: { customerModal },
    data() {
        return {
            dni: '',
            address: '',
            customer_selected: {}
        }
    },
    props: {
        customer: Object
    },
    methods: {
        showEditCustomer(customer) {
            this.customer_selected = customer
            $('#customerModal').modal('show')
        },
        deleteCustomer(customerId) {
            this.$emit('deleteCustomer', customerId)
        },
        saveDni() {
            const fd = new FormData()
            fd.append('id_customer', this.customer.id)
            fd.append('dni', this.dni)
            fd.append('address', this.address)
            axios.post('/api/updateDniCustomer', fd)
                .then((res) => {
                    this.$emit('getCustomer')
                })
                .catch((err) => {
                    console.error(err)
                })
        }
    }
}
</script>