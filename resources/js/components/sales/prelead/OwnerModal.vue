<template>
    <div class="modal fade" id="ownerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Asignar dueño del Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-1">
                            <label for="nameSmall" class="form-label">¿Qué necesita el cliente?</label>
                            <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="needs"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameSmall" class="form-label">Dueño del Lead</label>
                            <select v-model="seller_selected" class="form-select">
                                <option :value="seller.id" v-for="seller in sellers">
                                    {{ seller.name }}
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
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    props: {
        customerId: Number
    },
    data() {
        return {
            level: 0,
            seller_selected: '',
            sellers: [],
            search: '',
            products: [],
            filteredProducts: [],
            selectedProducts: [],
            needs: ''
        }
    },
    methods: {
        pickProduct(product) {
            var prodLevel = { id: product.id, name: product.name, level: this.level }
            this.selectedProducts.push(prodLevel)
            this.filteredProducts = []
            this.search = ''
        },
        removeProduct(product) {
            let index = this.selectedProducts.indexOf(product.id == product.id)
            this.selectedProducts.splice(index, 1)
        },
        searchProduct() {
            if (this.search != '') {
                this.filteredProducts = this.products.filter(product => product.name.toLowerCase().includes(this.search))
            } else {
                this.filteredProducts = []
            }

        },
        assignSeller() {
            if (this.needs != '') {
                const fd = new FormData()
                fd.append('needs', this.needs)
                fd.append('customer_id', this.customerId)
                fd.append('seller_selected', this.seller_selected)
                fd.append('user_id', this.store.authUser.id)
                axios.post('/api/assignOwner', fd)
                    .then(res => {
                        $('#ownerModal').modal('hide')
                        this.selectedProducts = []
                        this.$emit('cleanLead', this.customerId)
                    })
                    .catch(err => {
                        console.error(err)
                    })
            } else {
                $('#ownerModal').modal('hide')
                this.$swal('Para ascender a un cliente es requerido saber lo que necesita')
            }


        },
        getAllSellers() {
            axios.get('/api/sellers')
                .then(res => {
                    this.sellers = res.data
                })
                .catch(err => {
                    console.error(err)
                })
        },
        getAllProducts() {
            axios.get('/api/getAllNewProducts')
                .then(res => {
                    this.products = res.data
                })
                .catch(err => {
                    console.error(err)
                })
        }
    },
    mounted() {
        this.getAllSellers()
    }

}
</script>