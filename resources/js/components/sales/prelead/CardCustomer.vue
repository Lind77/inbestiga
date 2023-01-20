<template>
    <div :class="`card ${bgColor} mt-2 cursor-pointer`" draggable="true" @dragstart="drag" :id="`customer${customer.id}`">
        <div class="card-header text-white fw-300">
            {{ customer.name }}
            <div v-if="customer.grade == 2">
                <button @click="convertLead(customer.id)" class="btn btn-warning btn-sm">Convertir a Lead</button>
            </div>
            <div v-if="customer.grade == 3">
                <button @click="openProductModal(customer)" class="btn btn-warning btn-sm">Asignar Producto</button>
            </div>
            <div v-if="customer.grade == 4">
                <p>Producto: {{ customer.project.product.title }}</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                customer_selected:{}       
            } 
        },
        props:{
            customer: Object
        },
        methods:{
            drag(e){
                e.dataTransfer.setData('text', e.target.id)
            },
            convertLead(id){
                this.$swal.fire('Estás seguro de convertir a este usuario en un lead?')
                .then((res) => {
                    if(res){
                        axios.get(`/api/updateCustomerGrade/${id}/3`)
                        .then(res =>{
                            console.log(res)
                            this.$emit('getAllCustomers')
                        })
                        .catch(err =>{
                            console.log(err)
                        })
                    }
                })
            },
            openProductModal(customer){
                console.log('asignando customer')
                this.$emit('selectCustomer', customer)
                $('#productModal').modal('show')
            }
        },
        computed:{
            bgColor(){
                if(this.customer.grade == 0){
                    return 'bg-danger'
                }else if(this.customer.grade == 1){
                    return 'bg-warning'
                }else if (this.customer.grade == 2){
                    return 'bg-success'
                }else if (this.customer.grade >= 3){
                    return 'bg-success'
                }
            }
        }
    }
</script>