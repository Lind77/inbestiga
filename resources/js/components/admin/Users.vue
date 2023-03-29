<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
        <h5 class="card-header d-flex align-items-center justify-content-between">Usuarios 
            <button @click="addUser" class="btn btn-secondary add-new btn-primary w-25" type="button"><span><i class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Nuevo Usuario</span></span></button>
        </h5>
       
            <div class="table-responsive text-nowrap">
                <table class="table">
                <thead>
                    <tr>
                    <th>Usuario</th>
                    <th>Área</th>
                    <th>Rol</th>
                    <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="user in users">
                    <td>{{ user.name }}</td>
                    <td>{{ area[user.memoir.area] }}</td>
                    <td>{{ user.roles[0].name }}</td>
                    <td><span v-if="user.id != 1" @click="deleteUser(user.id)" class="badge bg-label-danger me-1 cursor-pointer"><i class='bx bx-trash'></i></span></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <InsertUser @getAllUsers="getAllUsers"/>
    </div>
</template>
<script>
import InsertUser from './InsertUser.vue'

export default {
    components:{InsertUser},
    data(){
        return{
            users: [],
            area:{
                'admin': 'Administración',
                'sales': 'Ventas',
                'acad': 'Académico',
                'experience': 'Experiencia del Inbestigador'
            }
        }
    },
    methods:{
        getAllUsers(){
            axios.get('/api/getAllUsers')
            .then(res =>{
                this.users = res.data
            })
            .catch(err =>{
                console.log(err)
            })
        },
        addUser(){
            $('#userModal').modal('show')
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
        this.getAllUsers()
    }
}
</script>