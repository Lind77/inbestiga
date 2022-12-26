<template>
    <div class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Grupo a cargo</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Rol
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(activity, key) in progress">
                            <td>
                                {{ key+1 }}.  {{ activity.title }}
                            </td>
                            <td>
                                {{ activity.percentage }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
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