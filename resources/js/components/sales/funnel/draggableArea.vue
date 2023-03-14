<template>
   <div class="col">
    <h5 class="fw-600">{{ title }}</h5>
        <div :id="'draggableArea'+status" class="container-cards overflow-auto vh-100" @drop="drop" @dragenter.prevent @dragover.prevent>
            <template v-for="(customer, index) in customers" :key="customer.id">
                    <template v-if="customer.status == status">
                        <CardCustomer :customer="customer" :status="status"  :index="index" @showModalUpdateCom="showModalUpdateCom"/>
                    </template>
            </template>
        </div>
    </div>
</template>
<script>
import UpdateCom from '../prelead/UpdateCom.vue'
import CardCustomer from '../prelead/CardCustomer.vue'
    export default{
        components:{CardCustomer, UpdateCom},
        data(){
            return{
                visible: false,
                comunication: {}
            }
        },
        props:{
            title: String,
            bg: String,
            customers: Array,
            status: Number
        },
        methods:{
            showModalUpdateCom(com){
                this.$emit('callModal', com)
            },
            hide(e){
                e.preventDefault()
                e.target.classList.remove('pt-20')
            },
            allowDrop(e){
                e.preventDefault()
                e.target.classList.add('bg-hover')
            },
            drop(e){
                e.preventDefault()
                
                var quotation = e.dataTransfer.getData("quot")
                var orders = e.dataTransfer.getData("order")
                var data = e.dataTransfer.getData("id_card")

                console.log(quotation, orders, data)

                //Verification Quotation
                if(this.status >= 4){
                    console.log('verif')
                    if(quotation == 'null'){
                        this.$swal.fire('Este usuario no presenta una cotización')
                    }else if(this.status >= 6){
                        if(orders == 'null'){
                            // Verification Order
                            this.$swal.fire('Este usuario no presenta una orden de servicio')
                        }else{
                            e.target.prepend(document.getElementById(data))
                            e.target.classList.remove('bg-hover')
                            if(this.status != 7){
                                this.updateStatus(data)
                            }else{
                                this.setProject(data)
                            }
                        }
                    }else{
                        console.log('verif <4')
                        e.target.prepend(document.getElementById(data))
                        e.target.classList.remove('bg-hover')
                        if(this.status != 7){
                            this.updateStatus(data)
                        }else{
                            this.setProject(data)
                        }
                    }
                }else{
                    e.target.prepend(document.getElementById(data))
                    if(this.status != 7){
                        this.updateStatus(data)
                    }else{
                        this.setProject(data)
                    }
                }
            },
            updateStatus(id){
                axios.get(`/api/updateCustomerGrade/${id}/${this.status}`)
                .then(res =>{
                    console.log(res.data)
                })
                .catch(err =>{
                    console.log(err)
                })
            },
            setProject(id){
                console.log(id)

                const fd = new FormData()
                fd.append('id_customer', id)
                fd.append('emisor_id', this.store.authUser[0].id)
                axios.post(`/api/setProject`, fd)
                .then(res =>{
                    console.log(res)
                })
                .catch(err =>{
                    this.$swal(err.response.data.msg)
                })
            }
        }
    }
</script>
<style scoped>
.pt-20{
    padding-top: 20%;
}
.h-90{
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
  background: rgba(67,89,113,.7);
}
</style>