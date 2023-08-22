<template>
    <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
        <div class="d-flex border rounded position-relative pe-0">
            <div class="row w-100 m-0 p-3">
                <h6>Tipo: {{ detail.type == 1 ? 'Normal' : 'Sugerido' }}</h6>
                <div class="col-md-2 col-12 mb-md-0 mb-3 ps-md-0">
                    <p class="mb-2 repeater-title">Modo</p>
                    <div class="col-md">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="radio" v-model="detail.mode" @click="selectMode" value="1"
                                :id="`type1-${index}`">
                            <label class="form-check-label" :for="`type1-${index}`"> Fragmentado </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" v-model="detail.mode" @click="selectMode" value="2"
                                :id="`type-${index}`">
                            <label class="form-check-label" :for="`type-${index}`"> Paquete </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-md-0 mb-3 ps-md-0">
                    <p class="mb-2 repeater-title">Nivel</p>
                    <select v-model="detail.level" @change="selectLevel" class="form-select item-details mb-2">
                        <option selected="" disabled="">Selecciona el Nivel</option>
                        <template v-if="detail.mode == 2">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </template>
                        <template v-else>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </template>
                    </select>
                </div>
                <div class="col-md-4 col-12 mb-md-0 mb-3">
                    <p class="mb-2 repeater-title">Detalle</p>
                    <input v-if="detail.product != null" type="text" class="form-control" @keyup="searchNewProduct"
                        v-model="detail.product.name">

                    <input v-else type="text" class="form-control" @keyup="searchNewProduct">
                    <ul class="list-group">
                        <li @click="addPrice(newProductByName)"
                            class="list-group-item d-flex justify-content-between align-items-center cursor-pointer"
                            v-for="newProductByName in newProductsByName">
                            {{ newProductByName.name }}
                            <span class="badge bg-primary">S./ {{ newProductByName.newPriceSelected.pivot.price }}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 col-12 mb-md-0 mb-3" v-if="detail.modeProduct == 1">
                    <p class="mb-2 repeater-title">Cantidad</p>
                    <input type="number" @keyup="changeCant" @change="changeCant" class="form-control" v-model="cantProduct"
                        min="1">
                </div>
                <div class="col-md-2 col-12 pe-0">
                    <p class="mb-2 repeater-title">Precio</p>
                    <p class="mb-0">S./{{ detail.price }}</p>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                <i class="bx bx-x fs-4 text-muted cursor-pointer" data-repeater-delete=""
                    @click="removeSuggestedCart(index)"></i>
                <div class="dropdown">
                    <i class="bx bx-cog bx-xs text-muted cursor-pointer more-options-dropdown" role="button"
                        id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                    </i>
                    <div class="dropdown-menu dropdown-menu-end w-px-300 p-3" aria-labelledby="dropdownMenuButton"
                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 23.2px, 0px);"
                        data-popper-placement="bottom-end">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="discountInput" class="form-label">Cambiar tipo</label>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                        @change="changeType">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Sugerido</label>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            carNewProduct: {
                mode: '',
                level: '',
                product: {
                    name: ''
                },
                price: 0
            },
            newProductsByType: [],
            newProductsByName: [],
            cantProduct: 1,
            initialPrice: null
        }
    },
    props: {
        detail: Object,
        newProducts: Array,
        index: Number
    },
    methods: {
        changeType() {
            this.detail.type == 1 ? this.detail.type = 2 : this.detail.type = 1
        },
        removeSuggestedCart() {
            this.$emit('removeSuggestedCart', this.index)
        },
        selectMode(e) {
            this.newProductsByType = this.newProducts.filter(product => product.type == e.target.value)
        },
        searchNewProduct(e) {
            this.newProductsByType = this.newProducts.filter(product => product.type == this.detail.mode)
            if (e.target.value != '') {
                this.newProductsByName = this.newProductsByType.filter(product => product.name.toLowerCase().includes(e.target.value))
                this.newProductsByName.forEach((product) => {
                    product.newPriceSelected = product.levels.find(level => level.name == this.detail.level)
                })
            } else {
                this.newProductsByName = []
            }
        },
        addPrice(newProductByName) {
            console.log(newProductByName)
            console.log(this.detail);
            this.detail.price = newProductByName.newPriceSelected.pivot.price
            this.initialPrice = newProductByName.newPriceSelected.pivot.price
            if (this.detail.new_product == null) {
                this.detail.new_product = {}
            }
            this.detail.product.name = newProductByName.name
            this.detail.product_id = newProductByName.id
            this.detail.modeProduct = newProductByName.mode
            this.detail.type = 1
            this.newProductsByName = []
        }
    },
    watch: {
        cantProduct: function (newCant, oldCant) {
            this.detail.price = this.initialPrice * newCant;
        }
    },
    mounted() {
        console.log(this.detail)
    }
}
</script>
<style></style>