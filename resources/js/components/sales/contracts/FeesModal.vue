<template>
    <div class="modal fade" id="feesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Agregar Pago y Entrega</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col mb-3">
                <label for="nameBasic" class="form-label">Fecha</label>
                <input type="date" v-model="fee.date" class="form-control">
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Porcentaje</label>
                    <input type="number" @keyup="calcAmount" v-model="fee.percentage" class="form-control">
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Monto</label>
                    <input type="text" v-model="fee.amount" class="form-control">
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Avance</label>
                    <input type="text" v-model="fee.advance" class="form-control">
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
        props:{
            totalFinal: Number
        },
        data(){
            return{
                fee:{
                    date: '',
                    amount: '',
                    advance: '',
                    percentage:0
                }
            }
        },
        methods:{
            addPayment(){
                this.$emit('addFee', this.fee)
                this.fee = {
                    date: '',
                    amount: '',
                    advance: '',
                    percentage:0
                }
                $('#feesModal').modal('hide')
            },
            calcAmount(){
               this.fee.amount = this.fee.percentage * this.totalFinal /100
            }
        }
    }
</script>