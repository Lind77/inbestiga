<template>
    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Agregar Proyecto</h5>
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
                    <label for="nameBasic" class="form-label">Título</label>
                    <input type="text" v-model="title" class="form-control" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Grupo</label>
                    <select v-model="owner_id" id="" class="form-control">
                        <option :value="owner.id" v-for="owner in owners">{{ owner.name }}</option>
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Cliente</label>
                    <select v-model="customer_id" id="" class="form-control">
                        <option :value="customer.id" v-for="customer in customers">{{ customer.name }}</option>
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Producto</label>
                    <input type="text" v-model="product" class="form-control" @keyup="search"/>
                    <table class="table table-bordered mb-3">
                        <tr v-for="product in products_filtered">
                            {{ product.title }}
                        </tr>
                    </table>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Deadline</label>
                    <input type="date" v-model="deadline" class="form-control" />
                    </div>
                </div>
            </div>
            </div>      
            </div>    
            <div class="modal-footer">
                <button type="button" id="close-insert-project" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" @click="insertProject" class="btn btn-primary">Registrar</button>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:{
            progress: Array,
            owners: Array,
            customers: Array,
            products: Array
        },
        data(){
            return{
                title: '',
                owner_id: 0,
                customer_id:0,
                deadline: null,
                amount: 0,
                term:'',
                product: '',
                products_filtered:[]
            }
        },
        methods:{
            search(e){
                console.log(e.target.value)
                this.products_filtered = this.products.some((product) => {
                    return  product.title.toLowerCase().includes(e.target.value)
                })
                console.log(this.products)
            },  
            insertProject(){
                const fd = new FormData()
                fd.append('title',this.title)
                fd.append('owner_id',this.owner_id)
                fd.append('customer_id',this.customer_id)
                fd.append('deadline',this.deadline)

                axios.post('/api/insertProject', fd)
                .then(res =>{
                    console.log(res)
                    this.$emit('getAllProjects')
                    document.getElementById('close-insert-project').click()
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
            }
        }
    }
</script>