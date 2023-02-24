<template>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Agregar Pago</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col mb-3">
                <label for="nameBasic" class="form-label">Fecha</label>
                <input type="date" v-model="date" class="form-control">
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Monto</label>
                    <input type="text" v-model="amount" class="form-control">
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button @click="addPayment" type="button" class="btn btn-primary">Registrar</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                date: null,
                amount: ''
            }
        },
        methods:{
            addPayment(){
                let payment = {}
                payment.date = this.date
                payment.amount = this.amount
                this.$emit('addPayment', payment)
                this.date = null
                this.amount = ''
                $('#paymentModal').modal('hide')
            }
        }
    }
</script>