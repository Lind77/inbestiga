<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Roles <span class="badge bg-label-primary me-1 cursor-pointer" @click="addUser">+</span></h4>
        <div class="row">
            <div class="col-md-4" v-for="rol in roles">
                <div class="card bg-primary text-white mb-3">   
                    <div class="card-body">
                        <h5 class="card-title text-white">{{ rol }}</h5>
                        <!-- <div v-if="user.roles[0]">
                            <p>{{ user.roles[0].name }}</p>
                        </div>
                        <button v-if="user.id != 1" @click="deleteUser(user.id)" class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></button> -->
                    </div>
                </div>
            </div>
        </div>
        <InsertRole @getAllRoles="getAllRoles"/>
    </div>
</template>
<script>
import InsertRole from './InsertRole.vue'

export default {
    components:{InsertRole},
    data(){
        return{
            roles: []
        }
    },
    methods:{
        getAllRoles(){
            axios.get('/api/getRoles')
            .then(res =>{
                this.roles = res.data
            })
            .catch(err =>{
                console.log(err)
            })
        },
        addUser(){
            $('#roleModal').modal('show')
        },
        deleteUser(id){
            this.$swal({
                  title: '¿Deseas eliminar a este usuario?',
                  icon: 'question',
                  confirmButtonText: 'Si',
                  showCancelButton: true,
                  cancelButtonText: 'No'
            })
            .then((result)=>{
                if(result.isConfirmed){
                    axios.get(`/api/deleteUser/${id}`)
                    .then(res =>{
                        this.getAllUsers()
                    })
                    .catch(err =>{
                        console.log(err)
                    })
                }else{
                    this.$swal.close()
                }
            })
            
        }
    },
    mounted(){
        this.getAllRoles()
    }
}
</script>