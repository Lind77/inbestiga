<template>
    <div class="col-md-12 mb-md-0 mb-3">
        <label for="">Porfavor inserte el número de cuotas a generarse</label>
        <input @change="calcFees" @keyup="calcFees" type="number" min="1" max="24" v-model="numFees" class="form-control">
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-xl-4" v-for="(fee, index) in fees">
        <div class="card bg-primary text-white mb-3">
        <div class="card-header">Pago {{ index+1 }}</div>
        <div class="card-body">
            <p class="card-text">
                Fecha:
                <input type="date" class="form-control" v-model="fee.date">
            </p>
            <p class="card-text">
                Monto: S./ {{ fee.amount }}
            </p>
            <p class="card-text">
                Porcentaje: {{ fee.percentage }} %
            </p>
            <!-- <p class="card-text">
                Avance:
                <input type="text" class="form-control" v-model="fee.advance">
            </p> -->
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
        payments: Array,
        fees: Array
    },
    data(){
        return{
            numFees: 0,
            newFees:[]
        }
    },
    methods:{
        calcFees(){
            this.newFees = []
            if(this.numFees == 1){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*.9),
                    percentage: 100,
                    advance: '-'
                }
                this.newFees.push({...fee})
                this.$emit('addFee', this.newFees)
                
            }else if(this.numFees == 2){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*.95)/this.numFees,
                    percentage: 50,
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
               
                }
                this.$emit('addFee', this.newFees)
            }else if(this.numFees == 3){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal)/this.numFees,
                    percentage: 30,
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    
                    if(index == 1){
                        fee.percentage = 40
                        fee.amount = parseInt(this.totalFinal*.4)
                    }else{
                        fee.percentage = 30
                        fee.amount = parseInt(this.totalFinal*.3)
                    }
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }
            else if(this.numFees == 4){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.05)/this.numFees,
                    percentage: 25,
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }
            else if(this.numFees == 5){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.1)/this.numFees,
                    percentage: 20,
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }else if(this.numFees >= 6 && this.numFees < 12){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.2)/this.numFees,
                    percentage: parseFloat(100/this.numFees).toFixed(1),
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
            }
            this.$emit('addFee', this.newFees)
            }else if(this.numFees >= 12 && this.numFees < 18){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.3)/this.numFees,
                    percentage: parseFloat(100/this.numFees).toFixed(1),
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }else if(this.numFees >= 18 && this.numFees < 24){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.4)/this.numFees,
                    percentage: parseFloat(100/this.numFees).toFixed(1),
                    advance: '-'
                }
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }
            else if(this.numFees == 24){
                
                var fee = {
                    date: moment().format('YYYY-MM-DD'),
                    amount: parseInt(this.totalFinal*1.5)/this.numFees,
                    percentage: parseFloat(100/this.numFees).toFixed(1),
                    advance: '-'
                }
                console.log(fee)
                for (let index = 0; index < this.numFees; index++) {
                    fee.date = moment().add(index, 'months').format('YYYY-MM-DD')
                    this.newFees.push({...fee})
                
                }
                this.$emit('addFee', this.newFees)
            }
        }
        
    
    }
}
</script>
<style lang="">
    
</style>