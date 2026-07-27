<template>
    <div class="repeater-wrapper pt-0 pt-md-2" data-repeater-item="">
        <div class="card border mb-3 shadow-none bg-body rounded-3">
            <div class="card-body p-3">
                <!-- Top Row: Badge & Action Switches -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge" :class="detail.type == 1 ? 'bg-label-primary' : 'bg-label-warning'">
                        <i class="bx me-1" :class="detail.type == 1 ? 'bx-package' : 'bx-star'"></i>
                        {{ detail.type == 1 ? 'Detalle Paquete' : 'Sugerido' }}
                    </span>
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch mb-0" title="Marcar como sugerido">
                            <input
                                class="form-check-input cursor-pointer"
                                type="checkbox"
                                :id="`switch-type-${index}`"
                                :checked="detail.type == 2"
                                @change="changeType"
                            />
                            <label class="form-check-label small cursor-pointer" :for="`switch-type-${index}`">
                                Sugerido
                            </label>
                        </div>
                        <button
                            type="button"
                            class="btn btn-sm btn-icon btn-outline-danger border-0"
                            @click="removeSuggestedCart(index)"
                            title="Eliminar detalle"
                        >
                            <i class="bx bx-trash fs-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Controls Row (Grid fits on 1 single row) -->
                <div class="row align-items-center g-2">
                    <!-- Detalle / Producto -->
                    <div :class="detail.modeProduct == 1 ? 'col-12 col-md-4' : 'col-12 col-md-5'">
                        <label class="form-label fw-medium mb-1 small text-uppercase">Producto / Servicio</label>
                        <div class="position-relative">
                            <input
                                v-if="detail.product != null"
                                type="text"
                                class="form-control"
                                placeholder="Buscar producto o servicio..."
                                @keyup="searchNewProduct"
                                v-model="detail.product.name"
                            />
                            <input
                                v-else
                                type="text"
                                class="form-control"
                                placeholder="Buscar producto o servicio..."
                                @keyup="searchNewProduct"
                            />
                            <ul class="list-group shadow position-absolute w-100 mt-1 z-3" v-if="newProductsByName.length">
                                <li
                                    @click="addPrice(newProductByName)"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center cursor-pointer p-2"
                                    v-for="newProductByName in newProductsByName"
                                    :key="newProductByName.id"
                                >
                                    <span><i class="bx bx-package me-1 text-primary"></i> {{ newProductByName.name }}</span>
                                    <small class="text-muted">Seleccionar</small>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Nivel Académico -->
                    <div :class="detail.modeProduct == 1 ? 'col-12 col-md-3' : 'col-12 col-md-3'">
                        <label class="form-label fw-medium mb-1 small text-uppercase">Nivel Académico</label>
                        <select v-model="detail.level" @change="selectLevel" class="form-select">
                            <option value="" disabled selected>Seleccione nivel...</option>
                            <option :value="level.id" v-for="level in levelsByProduct" :key="level.id">
                                {{ level.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Cantidad (Si aplica) -->
                    <div class="col-6 col-md-1" v-if="detail.modeProduct == 1">
                        <label class="form-label fw-medium mb-1 small text-uppercase">Cant.</label>
                        <input
                            type="number"
                            @keyup="changeCant"
                            @change="changeCant"
                            class="form-control text-center px-1"
                            v-model="cantProduct"
                            min="1"
                        />
                    </div>

                    <!-- Extra / Adicional -->
                    <div :class="detail.modeProduct == 1 ? 'col-6 col-md-2' : 'col-6 col-md-2'">
                        <label class="form-label fw-medium mb-1 small text-uppercase">Monto Extra</label>
                        <div class="input-group">
                            <span class="input-group-text px-2">S/</span>
                            <input
                                type="number"
                                min="0"
                                step="0.50"
                                @change="addExtraToPrice"
                                v-model="detail.extra_price"
                                class="form-control"
                                placeholder="0.00"
                            />
                        </div>
                    </div>

                    <!-- Subtotal / Precio -->
                    <div :class="detail.modeProduct == 1 ? 'col-12 col-md-2 text-md-end' : 'col-12 col-md-2 text-md-end'">
                        <label class="form-label fw-medium mb-1 small text-uppercase d-block text-md-end">Subtotal</label>
                        <span class="fw-bold fs-6 text-primary d-inline-block pt-1">
                            S/ {{ (parseFloat(detail.price || 0) + parseFloat(detail.extra_price || 0)).toFixed(2) }}
                        </span>
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
                mode: '2',
                level: '',
                product: {
                    name: ''
                },
                price: 0
            },
            newProductsByType: [],
            newProductsByName: [],
            cantProduct: 1,
            initialPrice: null,
            levelsByProduct: []
        }
    },
    props: {
        detail: Object,
        newProducts: Array,
        index: Number
    },
    methods: {
        changeType() {
            this.detail.type = this.detail.type == 1 ? 2 : 1;
        },
        removeSuggestedCart() {
            this.$emit('removeSuggestedCart', this.index);
        },
        selectLevel() {
            var levelSelected = this.levelsByProduct.find(product => product.id == this.detail.level);
            if (levelSelected) {
                this.detail.price = levelSelected.pivot.price;
                this.initialPrice = this.detail.price;
            }
        },
        searchNewProduct(e) {
            // Se asume siempre Paquete (tipo 2)
            this.detail.mode = '2';
            this.newProductsByType = this.newProducts.filter(product => product.type == 2 || product.type == '2');
            
            if (e.target.value && e.target.value.trim() !== '') {
                const searchVal = e.target.value.toLowerCase().trim();
                this.newProductsByName = this.newProductsByType.filter(product =>
                    product.name.toLowerCase().includes(searchVal)
                );
                this.newProductsByName.forEach((product) => {
                    if (product.levels) {
                        product.newPriceSelected = product.levels.find(level => level.name == this.detail.level);
                    }
                });
            } else {
                this.newProductsByName = [];
            }
        },
        addPrice(newProductByName) {
            if (!this.detail.product) {
                this.detail.product = {};
            }
            this.detail.product.name = newProductByName.name;
            this.detail.product_id = newProductByName.id;
            this.newProductsByName = [];
            this.levelsByProduct = newProductByName.levels || [];
            this.detail.modeProduct = newProductByName.mode;
        },
        addExtraToPrice() {
            this.$emit('calcPayments');
        },
        changeCant() {
            if (this.initialPrice) {
                this.detail.price = this.initialPrice * this.cantProduct;
            }
        }
    },
    watch: {
        cantProduct: function (newCant) {
            if (this.initialPrice) {
                this.detail.price = this.initialPrice * newCant;
            }
        }
    },
    mounted() {
        this.detail.mode = '2'; // Forzar modo Paquete por defecto
    }
}
</script>

<style scoped>
.z-3 {
    z-index: 1055 !important;
}

.form-label,
label,
.repeater-title {
    color: #1e293b !important;
    font-weight: 600 !important;
}

.form-control,
.form-select {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
}

.form-control::placeholder {
    color: #94a3b8 !important;
}

.input-group-text {
    background-color: #f1f5f9 !important;
    color: #334155 !important;
    border-color: #cbd5e1 !important;
    font-weight: 600;
}

/* Autocomplete Search Dropdown List */
ul.list-group {
    background-color: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 0.5rem !important;
    overflow: hidden;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15) !important;
}

ul.list-group .list-group-item {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-bottom: 1px solid #f1f5f9 !important;
    transition: background-color 0.15s ease;
}

ul.list-group .list-group-item span {
    color: #0f172a !important;
    font-weight: 500 !important;
}

ul.list-group .list-group-item small {
    color: #64748b !important;
}

ul.list-group .list-group-item:hover,
ul.list-group .list-group-item:focus {
    background-color: #f1f5f9 !important;
}

ul.list-group .list-group-item:hover span {
    color: #4f46e5 !important;
}

/* Native Select Options */
select option {
    background-color: #ffffff !important;
    color: #0f172a !important;
    padding: 8px 12px;
}

select option:hover,
select option:focus,
select option:checked {
    background-color: #e0e7ff !important;
    color: #4338ca !important;
}

/* Dark Mode Overrides */
body.dark-mode .form-label,
body.dark-mode label,
body.dark-mode .repeater-title,
[data-bs-theme="dark"] .form-label,
[data-bs-theme="dark"] label,
[data-bs-theme="dark"] .repeater-title {
    color: #e2e8f0 !important;
}

body.dark-mode .form-control,
body.dark-mode .form-select,
[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #1b1b29 !important;
    color: #ffffff !important;
    border-color: #3a3b54 !important;
}

body.dark-mode .input-group-text,
[data-bs-theme="dark"] .input-group-text {
    background-color: #2b2c40 !important;
    color: #a1a5b7 !important;
    border-color: #3a3b54 !important;
}

body.dark-mode ul.list-group,
[data-bs-theme="dark"] ul.list-group {
    background-color: #1b1b29 !important;
    border-color: #3a3b54 !important;
}

body.dark-mode ul.list-group .list-group-item,
[data-bs-theme="dark"] ul.list-group .list-group-item {
    background-color: #1b1b29 !important;
    color: #ffffff !important;
    border-bottom-color: #2b2c40 !important;
}

body.dark-mode ul.list-group .list-group-item span,
[data-bs-theme="dark"] ul.list-group .list-group-item span {
    color: #ffffff !important;
}

body.dark-mode select option,
[data-bs-theme="dark"] select option {
    background-color: #1b1b29 !important;
    color: #ffffff !important;
}
</style>