<template>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Insertar Cliente</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                <label for="nameBasic" class="form-label">Nombre</label>
                <input type="text" v-model="name" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Celular</label>
                <input type="text" v-model="cell" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Email</label>
                <input type="email" v-model="email" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="dobBasic" class="form-label">Universidad</label>
                <input type="text" v-model="university" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Carrera</label>
                <input type="text" v-model="career" class="form-control" />
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" id="close-insert-customer" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" @click="insertCustomer" class="btn btn-primary">Registrar</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            name: '',
            cell: '',
            university: '',
            career: '',
            email: ''
        }
    },
    methods:{  
        insertCustomer(){
            const fd = new FormData()
            fd.append('name',this.name)
            fd.append('cell',this.cell)
            fd.append('university',this.university)
            fd.append('career',this.career)
            fd.append('email',this.email)
            fd.append('status',0)

            axios.post('/api/insertCustomer', fd)
            .then(res =>{
                console.log(res)
                this.$emit('getAllCustomers')
                document.getElementById('close-insert-customer').click()
            })
            .catch(err =>{
                console.log(err.response.data)
            })
        }
    }
}
</script>
<style lang="">
    
</style>