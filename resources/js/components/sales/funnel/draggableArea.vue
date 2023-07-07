<template>
    <div class="col-12 col-lg">
        <h5 class="fw-600">{{ title }}</h5>
        <div :id="'draggableArea' + status" class="container-cards overflow-auto vh-100" @drop="drop" @dragenter.prevent
            @dragover.prevent>
            <template v-for="(customer, index) in customers" :key="index">
                <CardCustomer :customer="customer" :status="status" @showModalUpdateCom="showModalUpdateCom"
                    @showModalUpdateData="showModalUpdateData" @updateStatusSpace="updateStatusSpace"
                    @convertLead="convertLead" @showModalFunnel="showModalFunnel" />
            </template>
        </div>
    </div>
</template>
<script>
import UpdateCom from '../prelead/UpdateCom.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
export default {
    components: { CardCustomer, UpdateCom },
    data() {
        return {
            visible: false,
            comunication: {},
            customer: {}
        }
    },
    props: {
        title: String,
        bg: String,
        customers: Array,
        status: Number
    },
    methods: {
        showModalFunnel(customer) {
            this.$emit('showModalFunnel', customer)
        },
        cleanLead(id) {
            var leadSelected = this.customers.find(customer => customer.id == id)
            leadSelected.status = 3
        },
        convertLead(id) {
            this.$emit('convertLead', id)
        },
        showModalUpdateCom(com) {
            this.$emit('callModal', com)
        },
        showModalUpdateData(customer) {
            this.$emit('showModalUpdateData', customer)
        },
        hide(e) {
            e.preventDefault()
            e.target.classList.remove('pt-20')
        },
        allowDrop(e) {
            e.preventDefault()
            e.target.classList.add('bg-hover')
        },
        drop(e) {
            e.preventDefault()

            var quotation = e.dataTransfer.getData("quot")
            var order = e.dataTransfer.getData("order")
            var data = e.dataTransfer.getData("leadId")

            console.log('dragarea', data)
            this.$emit('updateStatusSpace', data, this.status)
        },
        updateStatusSpace(leadId) {
            this.$emit('updateStatusSpace', leadId, this.status)
            /* const index = this.customers.findIndex(c => c.id == id)
            this.customers[index].status = status
            axios.get(`/api/updateCustomerGrade/${id}/${status}`)
            .then(res =>{
                console.log(res.data)
            })
            .catch(err =>{
                console.log(err)
            }) */
        },
        updateStatus(id) {
            axios.get(`/api/updateCustomerGrade/${id}/${this.status}`)
                .then(res => {
                    console.log(res.data)
                })
                .catch(err => {
                    console.log(err)
                })
        },
        setProject(id) {
            console.log(id)

            const fd = new FormData()
            fd.append('id_customer', id)
            fd.append('emisor_id', this.store.authUser[0].id)
            axios.post(`/api/setProject`, fd)
                .then(res => {
                    console.log(res)
                })
                .catch(err => {
                    this.$swal(err.response.data.msg)
                })
        }
    }
}
</script>
<style scoped>
.pt-20 {
    padding-top: 20%;
}

.h-90 {
    height: 90%;
}

/* width */
::-webkit-scrollbar {
    width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: rgba(67, 89, 113, 0.075);
    border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: rgba(67, 89, 113, .7);
}</style>