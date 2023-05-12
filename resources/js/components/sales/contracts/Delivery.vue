<template>
    <div class="col-4" v-for="(delivery, index) in deliveries">
        <div class="card bg-success text-white">
            <div class="card-header d-flex justify-content-between">
                Entrega {{ index+1 }}
                <i @click="deleteDelivery(index)" class="bx bx-trash cursor-pointer"></i>
            </div>
            <div class="card-body">
            Fecha
            <input type="date" class="form-control" v-model="delivery.date">
            <br>
            Avance
            <input type="text" class="form-control" v-model="delivery.advance">
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            deliveries: Array
        },
        methods:{
            deleteDelivery(index){
                this.$emit('removeDelivery', index)
            }
        }
    }
</script>