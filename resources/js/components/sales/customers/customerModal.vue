<template>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" v-if="action == 1" id="exampleModalLabel1">Insertar Cliente</h5>
            <h5 class="modal-title" v-else id="exampleModalLabel1">Actualizar Cliente {{ customer.name || customer.cell }}</h5>
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
                <input type="text" v-if="action==2" v-model="customer.name" class="form-control" />
                <input type="text" v-else v-model="name" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Celular</label>
                <input type="text" v-if="action==2" v-model="customer.cell" class="form-control" />
                <input type="text" v-else v-model="cell" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Email</label>
                <input type="email" v-if="action==2" v-model="customer.email" class="form-control" />
                <input type="text" v-else v-model="email" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="dobBasic" class="form-label">Universidad</label>
                <input type="text" v-if="action==2" v-model="customer.university" class="form-control" />
                <input type="text" v-else v-model="university" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Carrera</label>
                <input type="text" v-if="action==2" v-model="customer.career" class="form-control" />
                <input type="text" v-else v-model="career" class="form-control" />
                </div>
            </div>
            <div class="row g-2">
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Origen</label>
                    <select class="form-select" v-model="origin">
                        <option value="1">Messenger</option>
                        <option value="2">Whatsapp</option>
                        <option value="3">Página web</option>
                        <option value="4">Instagram</option>
                        <option value="5">Referido</option>
                    </select>
                </div>
            </div>
            <div class="row g-2">
                <h5 class="mt-3">Comunicación</h5>
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Primera Gestión</label>
                <input type="date" v-model="first_management" class="form-control">
                </div>
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Última Gestión</label>
                <input type="date" v-model="last_management" class="form-control">
                </div>
                
            </div>
            <div class="row g-2 mt-2">
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Próxima Gestión</label>
                <input type="datetime-local" v-model="next_management" class="form-control">
                </div>
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Comentario</label>
                <input type="text" v-model="comment" class="form-control"/>
                </div>
                
            </div>
            <div class="row g-2 mt-2">
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Producto Tentativo</label>
                <input type="text" v-model="product_tentative" class="form-control"/>
                </div>
                <div class="col mb-0">
                <label for="emailBasic" class="form-label">Tipo</label>
                <select v-model="type" class="form-select">
                    <option value="1">Llamar</option>
                    <option value="2">Escribir</option>
                    <option value="3">Meet</option>
                </select>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" id="close-insert-customer" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" v-if="action == 1" @click="insertCustomer" class="btn btn-primary">Registrar</button>
            <button type="button" v-else @click="updateCustomer" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
import {userStore} from '../../../stores/UserStore'

export default {
    setup(){
      const store = userStore()
      return { store }
    },
    props:{
        action: Number,
        customer: Object
    },
    data(){
        return{
            name: '',
            cell: '',
            university: '',
            career: '',
            email: '',
            first_management: null,
            last_management: null,
            next_management: null,
            comment: '',
            product_tentative: '',
            type: 0,
            origin: 0
        }
    },
    methods:{
        updateCustomer(){
            const fd = new FormData()
            fd.append('id', this.customer.id)
            fd.append('name',this.customer.name)
            fd.append('cell',this.customer.cell)
            fd.append('university',this.customer.university)
            fd.append('career',this.customer.career)
            fd.append('email',this.customer.email)

            axios.post('/api/updateCustomer', fd)
            .then(res =>{
                console.log(res)
                this.$emit('getAllCustomers')
                $('#customerModal').modal('hide')
            })
            .catch(err =>{
                console.log(err.response.data)
            })
        },  
        insertCustomer(){
            const fd = new FormData()
            fd.append('name',this.name)
            fd.append('cell',this.cell)
            fd.append('university',this.university)
            fd.append('career',this.career)
            fd.append('email',this.email)
            fd.append('origin', this.origin)
            fd.append('status',1)
            fd.append('user_id',this.store.authUser.id)
            fd.append('first_management',this.first_management)
            fd.append('last_management', this.last_management)
            fd.append('next_management', this.next_management)
            fd.append('comment', this.comment)
            fd.append('product_tentative', this.product_tentative)
            fd.append('type', this.type)

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
