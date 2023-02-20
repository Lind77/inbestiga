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
                <!-- <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Equipo</label>
                    <select v-model="team_id" class="form-select">
                        <option>Selecciona un equipo</option>
                        <option :value="team.id" v-for="team in teams">{{ team.name }}</option>
                    </select>
                </div> -->
                <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Cliente</label>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="emailBasic" class="form-label">Indicaciones Adicionales</label>
                        <textarea v-model="indication" class="form-control">
                        </textarea>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Producto</label>
                   
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Nivel</label>
                    <select v-model="level" class="form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
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
            teams: Array,
            customers: Array
        },
        data(){
            return{
                title: '',
                team_id: 0,
                customer_id:0,
                deadline: null,
                level:0,
                amount: 0,
                term:'',
                product: '',
                product_id:'',
                products: [],
                products_filtered:[],
                hover: false,
                indication: ''
            }
        },
        methods:{
            selectProduct(product){
                this.product = product.title
                this.products_filtered = []
                this.product_id = product.id
            },
            search(e){
                if(e.target.value != ''){
                    this.products_filtered = this.products.filter((product) => {
                    return  product.title.toLowerCase().includes(e.target.value)
                    })
                }else{
                    this.products_filtered = []
                }
            },  
            insertProject(){
                const fd = new FormData()
                fd.append('title',this.title)
                fd.append('team_id',this.team_id)
                fd.append('product_id',this.product_id)
                fd.append('customer_id',this.customer_id)
                fd.append('deadline',this.deadline)
                fd.append('level',this.level)

                axios.post('/api/insertProject', fd)
                .then(res =>{
                    this.$emit('getAllProjects')
                    document.getElementById('close-insert-project').click()
                    /* this.title = ''
                    this.team_id = ''
                    this.product_id = ''
                    this.customer_id = ''
                    this.deadline = ''
                    this.products_filtered = [],
                    this.product = '' */
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
            },
            getAllProducts(){
                axios.get('https://jairpl.com/autoDeploy/public/api/getAllProducts')
                .then(res => {
                    this.products = res.data
                })
                .catch(err =>{
                    console.log(err.response.data)
                }) 
            }
        },
        mounted(){
            this.getAllProducts()
        }

    }
</script>