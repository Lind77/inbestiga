<template>
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Agregar tarea a {{ activity.title }}</h5>
            <a @click="deleteTask(activity.id)" class="text-danger mx-2 cursor-pointer">Eliminar</a>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                id="closeActivityModal"
            ></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
            </div>
        </div>
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            activity: Object
        },
        methods:{
            deleteTask(id){
                if(confirm('Estás seguro de eliminar esta actividad?')){
                    axios.get(`/api/deleteActivity/${id}`)
                    .then(res => {
                        this.$emit('getAllProducts')
                        document.getElementById('closeActivityModal').click()
                    })
                    .catch(err =>{
                        console.log(err)
                    })
                }
            }
        }
    }
</script>