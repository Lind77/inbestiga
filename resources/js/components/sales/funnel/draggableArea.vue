<template>
   <div :class="`col vh-100`" id="3" @drop="drop" @dragover="allowDrop">
    <h5 class="fw-600">{{ title }}</h5>
        <div class="container-cards overflow-auto h-75">
            <template v-for="customer in customers">
                    <template v-if="customer.status == status">
                        <CardCustomer :customer="customer" @getAllCustomers="getAllCustomers"/>
                    </template>
            </template>
        </div>
    </div>
</template>
<script>
import CardCustomer from '../prelead/CardCustomer.vue'
    export default{
        components:{CardCustomer},
        props:{
            title: String,
            bg: String,
            customers: Array,
            status: Number
        },
        methods:{
            allowDrop(e){
                e.preventDefault()
                console.log('allow drop')
                e.dataTransfer.dropEffect = 'move'
                e.dataTransfer.effectAllowed = 'move'
            },
            drop(e){
                e.preventDefault()
                var data = e.dataTransfer.getData("id_card");
                e.target.appendChild(document.getElementById(data));
                console.log(e.target)

                if(e.target.id != 7){
                    this.updateStatus(data)
                }else{
                    this.setProject(data)
                }

               /*  if(e.target.id != status && e.target.id != ''){
                   
                }
                 */
            },
            updateStatus(id){
                axios.get(`/api/updateCustomerGrade/${id}/${this.status}`)
                .then(res =>{
                    this.getAllCustomers()
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
                    this.getAllCustomers()
                })
                .catch(err =>{
                    this.$swal(err.response.data.msg)
                })
            }
        }
    }
</script>
<style scoped>
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