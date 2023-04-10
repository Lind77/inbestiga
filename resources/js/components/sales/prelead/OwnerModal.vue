<template>
    <div class="modal fade" id="ownerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Asignar dueño del Lead {{ customerId }}</h5>
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
                    <label for="nameSmall" class="form-label">Dueño del Lead</label>
                    <select v-model="seller_selected" class="form-select">
                        <option :value="seller.user.id" v-for="seller in sellers">
                            {{ seller.user.name }}
                        </option>
                    </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Salir
                </button>
                <button type="button" class="btn btn-primary" @click="assignSeller">Asignar</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import axios from 'axios'

export default {
    props:{
        customerId: Number
    },
    data(){
        return{
            seller_selected: '',
            sellers:[]
        }
    },
    methods:{
        assignSeller(){
            const fd =  new FormData()
            fd.append('customer_id', this.customerId)
            fd.append('seller_selected', this.seller_selected)
            axios.post('/api/assignOwner', fd)
            .then(res =>{
                $('#ownerModal').modal('hide')
                this.$emit('cleanLead', this.customerId)
            })
            .catch(err =>{
                console.error(err)
            })

        },
        getAllSellers(){
            axios.get('/api/getAllSellers')
            .then(res =>{
                this.sellers = res.data
            })
            .catch(err =>{
                console.error(err)
            })
        }
    },
    mounted(){
        this.getAllSellers()
    }

}
</script>