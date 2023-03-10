<template>
   <div class="col vh-100">
    <h5 class="fw-600">{{ title }}</h5>
        <div id="draggableArea" class="container-cards overflow-auto h-90" @drop="drop" @dragover="allowDrop" @dragleave="hide">
            <template v-for="(customer, index) in customers" :key="customer.id">
                    <template v-if="customer.status == status">
                        <CardCustomer :customer="customer"/>
                    </template>
                    <div v-if="visible">
                        <br>
                    </div>
            </template>
        </div>
    </div>
</template>
<script>
import CardCustomer from '../prelead/CardCustomer.vue'
    export default{
        components:{CardCustomer},
        data(){
            return{
                visible: false
            }
        },
        props:{
            title: String,
            bg: String,
            customers: Array,
            status: Number
        },
        methods:{
            hide(e){
                e.preventDefault()
                e.target.classList.remove('pt-20')
            },
            allowDrop(e){
                e.preventDefault()
                e.target.classList.add('pt-20')
            },
            drop(e){
                e.preventDefault()
                var data = e.dataTransfer.getData("id_card");
                document.getElementById(data).classList.remove('pt-10')
                e.target.prepend(document.getElementById(data));
                
                e.target.classList.remove('pt-20')
                this.visible = false
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