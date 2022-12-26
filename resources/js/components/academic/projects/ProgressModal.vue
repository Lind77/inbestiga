<template>
    <div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Avance del Proyecto</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <form @submit="insertProgress">
                    <div class="row">
                        <p>¿Tienes la seguridad de cambiar de estado el proyecto?</p>
                        <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Comentario <span class="text-danger text-capitalize">Obligatorio</span></label>
                        <input type="text" v-model="title" class="form-control" required/>
                        </div>
                        <p>Porcentaje proyectado: 1%</p>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Confirmar"/>
                </form>
            </div>    
            <div class="modal-footer">
            </div>
        </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:{
            progress: Array
        },
        data(){
            return{
                title: '',
                description: '',
                amount: 0,
                term:'',
                products:[]
            }
        },
        methods:{  
            insertProgress(){
                alert('insertando progreso wey')
            },
            insertProduct(){
                const fd = new FormData()
                fd.append('title',this.title)
                fd.append('description',this.description)
                fd.append('amount',this.amount)
                fd.append('term',this.term)

                axios.post('/api/insertProduct', fd)
                .then(res =>{
                    console.log(res)
                    this.$emit('getAllProducts')
                    document.getElementById('close-insert-product').click()
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
            }
        }
    }
</script>