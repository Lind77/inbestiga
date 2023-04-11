<template>
    <div class="card shadow-none bg-transparent border border-info mb-3"  v-if="customerSelected.id">
        <div class="card-body">
        <h5 class="card-title">Cliente: {{ customerSelected.name }} <!-- <i @click="deleteCustomerSelected" class='bx bx-trash text-danger cursor-pointer'></i> --></h5>
        <p class="card-text">
            Teléfono: {{ customerSelected.cell }}
        </p>
        <p class="card-text">
            Carrera: {{ customerSelected.career }}
        </p>
        <p class="card-text">
            Universidad: {{ customerSelected.university }}
        </p>
        <p class="card-text">
            <div v-if="customerSelected.dni == null">
            <label for="">DNI  <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="dni">
            </div>
            <div v-else>
            DNI: {{ customerSelected.dni }}
            </div>
            
        </p>
        <p class="card-text">
            <div v-if="customerSelected.address == null">
            <label for="">Dirección <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="address">
            </div>
            <div v-else>
            Dirección: {{ customerSelected.address }}   
            </div>
        </p>
        <button v-if="customerSelected.address == null || customerSelected.dni == null" class="btn btn-success btn-sm mt-2" @click="saveDni"> Guardar Datos</button>
        <!-- <p class="card-text">
            Estado: {{ status[customerSelected.status] }}
        </p> -->
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                dni:'',
                address: ''
            }
        },
        props:{
            customerSelected: Object,
        },
        methods:{
            saveDni(){
            const fd = new FormData()
            fd.append('id_customer', this.$route.params.idUser)
            fd.append('dni', this.dni)
            fd.append('address', this.address)  
            axios.post('/api/updateDniCustomer', fd)
            .then((res) =>{
                this.$emit('updateCustomer')  
            })
            .catch((err)=>{
                console.error(err)
            })
          },
        }
    }
</script>