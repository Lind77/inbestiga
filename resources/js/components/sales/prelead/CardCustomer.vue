<template>
    <div class="cardSpace" draggable="true" @dragover.prevent @drop.stop.prevent @dragstart="drag" :id="`${customer.id}`" @click="showModalFunnel(customer)">
        <div :class="`card bg-${bgColor} p-2 cursor-pointer`">
            <h6 class="mb-0 py-2 text-white">{{ customer.name || customer.cell }}</h6>
        </div>
        <div class="space" :id="'space'+customer.id" @dragover="changeColor(customer.id)" @dragleave="removeColor(customer.id)" @drop="dropSpace($event, customer.id)">
        </div>
    </div>
</template>
<script>
import moment from 'moment'
    export default{
        data(){
            return{
                customer_selected:{},
                comunication:{
                    1: 'Llamar',
                    2: 'Escribir',
                    3: 'Meet'
                },
                statusCard: 0,
                orders:[]
            } 
        },
        props:{
            customer: Object,
            status: Number,
            visible: Boolean
        },
        methods:{
            showModalFunnel(customer){
                this.$emit('showModalFunnel', customer)
            },
            removeColor(index){
                document.getElementById('space'+index).classList.remove('space-show')
            },
            changeColor(index){
                document.getElementById('space'+index).classList.add('space-show')
            },
            dropSpace(e, index){
                var leadId = e.dataTransfer.getData('leadId')
                this.$emit('updateStatusSpace', leadId)
                document.getElementById('space'+index).classList.remove('space-show')
            },
            showModalUpdateCom(){
                this.$emit('showModalUpdateCom', this.customer.comunication)
            },
            showModalUpdateData(){
                this.$emit('showModalUpdateData', this.customer)
            },
            formatDate(date){
                return moment(date).format('DD/MM/YYYY')
            },
            customerStandBy(id){
                this.$swal.fire('Tienes la seguridad de enviar a este usuario a stand by?')
                .then((res) =>{
                    if(res.isConfirmed){
                        axios.get('/api/standByCustomer/'+id)
                        .then(res =>{
                            console.log(res)
                        })
                        .catch(err =>{

                        })
                    }
                })
            },
            allowDrop(e){
                return
            },
            drag(e){
                e.dataTransfer.setData('leadId', this.customer.id)
                if(this.customer.quotations.length != 0){
                    e.dataTransfer.setData('quot', this.customer.quotations[0].id)
                    if(this.orders != 0){
                        e.dataTransfer.setData('order', this.orders[0].id)
                    }else{
                        e.dataTransfer.setData('order', null)
                    }
                }else{
                    e.dataTransfer.setData('quot', null)
                }
            },
            rejectDrop(id){
                e.preventDefault()
            },
            convertLead(id){

                this.$emit('convertLead', id)
                /*  */
            },
            openProductModal(customer){
                console.log('asignando customer')
                this.$emit('selectCustomer', customer)
                $('#productModal').modal('show')
            }
        },
        computed:{
            bgColor(){
                if(this.customer.status == 0){
                    return 'dark'
                }else if(this.customer.status == 1){
                    return 'warning'
                }else if (this.customer.status == 2){
                    return 'info'
                }else if(this.customer.status == 3){
                    return 'success'
                }
                else if (this.customer.status > 3){
                    if(this.customer.interest == 1){
                        return 'danger'
                    }else if(this.customer.interest == 2){
                        return 'info'
                    }else if(this.customer.interest == 3){
                        return 'success'
                    }else{
                        return 'secondary'
                    }
                }
            },
            verifyOrders(){
                return this.customer.quotations.some(quotation => {
                    return quotation.orders?.length > 0
                })
            }
        },
        mounted(){
            this.statusCard = this.customer.status
        }
    }
</script>
<style scoped>
.space{
    height: 10px;
    border-radius: 5px;
}
.space-show{
    background-color: #696cff;
}
.bg-hover{
    background-color: #696cff;
}
.pt-10{
    margin-top: 100px;
}
</style>