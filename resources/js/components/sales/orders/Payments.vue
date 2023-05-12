<template>
    <div class="col-md-12 mb-md-0 mb-3">
        <button class="btn btn-primary" @click="addPayment">Agregar Pago</button>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-xl-4" v-for="(payment, index) in payments">
        <div class="card bg-primary text-white mb-3">
        <div class="card-header d-flex justify-content-between">Pago {{ index+1 }} <i @click="deletePayment(index)" class="bx bx-x cursor-pointer"></i></div>
        <div class="card-body">
            <p class="card-text">
                Fecha:
                <input type="date" class="form-control" v-model="payment.date">
            </p>
            <p class="card-text">
                Monto: 
                <input type="number" class="form-control" v-model="payment.amount">
            </p>
        </div>
        </div>
  </div>
    </div>
</template>
<script>
import moment from "moment"

export default {
    emits:['addFee'],
    props:{
        totalFinal: Number,
        fees: Array,
        payments: Array
    },
    data(){
        return{
            numFees: 0,
            newFees:[]
        }
    },
    methods:{
        addPayment(){

            var newPayment = {
                'date' : 0,
                'amount' : 0
            }

            this.payments.push(newPayment)
        },
        deletePayment(index){
            this.payments.splice(index,1)
        }
        
    
    }
}
</script>
<style lang="">
    
</style>