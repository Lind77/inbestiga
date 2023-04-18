<template>
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Escribir Observaciones</h5>
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
                    
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Salir
                </button>
                <button type="button" class="btn btn-primary">Asignar</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
    export default{
        data(){
            return{
                detail: ''
            }
        },
        props:{
            activity: Object
        },
        methods:{
            insertDetailsFirstMeeting(){
                const fd = new FormData()
                fd.append('activityId', this.activity.id)
                fd.append('detail', this.detail)

                axios.post('/api/insertDetailsFirstMeeting', fd)
                .then((res)=>{
                    this.detail = ''
                    $('#firstMeetModal').modal('hide')
                    this.$emit('colorActivity', this.activity)
                })
                .catch((err)=>{
                    console.error(err)
                })
            }
        }
    }
</script>