<template>
    <div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true" ref="progressModal">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Registro de Progreso</h5>
            {{ progress }}
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <form @submit="updateProgress">
                    <div class="row">
                        <p>¿Tienes la seguridad de registrar progreso de este proyecto?</p>
                        <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Comentario <span class="text-danger text-capitalize">Obligatorio</span></label>
                        <input type="text" v-model="comment" class="form-control" required/>
                        </div>
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
            progress: Object,
            project_selected: Object
        },
        data(){
            return{
                comment: ''
            }
        },
        methods:{  
            updateProgress(e){
                e.preventDefault()
                const fd = new FormData()
                fd.append('progress_id', this.progress.id)
                fd.append('comment',this.comment)

                axios.post('/api/updateProgress', fd)
                .then(res =>{
                    console.log(res)
                    //this.$emit('getAllProducts')
                    this.$refs.progressModal.display.style = 'none'
                    //document.getElementById('close-insert-product').click()
                })
                .catch(err =>{
                    if(err.response){
                        console.log(err.response.data)
                    }
                })
            }
        }
    }
</script>