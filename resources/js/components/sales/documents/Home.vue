<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl-12">
                <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                        Cotizaciones
                    </button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                        Ordenes
                    </button>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">
                        Contratos
                    </button>
                    </li>
                </ul>
                <div class="tab-content">
                        <Quotations/>
                        <Orders/>
                        <Contracts/>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Quotations from './Quotations.vue';
import Orders from './Orders.vue';
import Contracts from './Contracts.vue'
export default {
    components:{Quotations, Orders, Contracts}
}
</script>
<style scoped>
    .tab-content{
        background: none;
        border: none;
        box-shadow: none;
        padding: 0;
    }
</style>