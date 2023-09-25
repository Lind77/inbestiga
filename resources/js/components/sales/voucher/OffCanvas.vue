<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h3 id="offcanvasEndLabel" class="offcanvas-title">Lista de Comprobantes</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <button class="btn btn-info m-1" v-for="voucher in vouchers">
            {{ voucher.customer.name }} - {{ voucher.date }}
        </button>

        <!-- <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <p class="text-primary h5" v-if="project_selected.team"> (Equipo {{ project_selected.team.name }})</p>
        <a href="javascript:void(0)">{{ sumTasksPercent }} %</a>
        <div class="progress mb-3">
          <div class="progress-bar" role="progressbar" :style="{width: sumTasksPercent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
          </div>
        </div>
        <h5 @dblclick="pickDeadline" class="text-danger cursor-pointer">Fecha de Culminación: {{ project_selected.deadline }}</h5>
        <div v-if="project_selected.activities == []">No hay actividades asignadas</div>
        <div v-else>
          <div v-for="activity in project_selected.activities">
              <ActivityCard :project_selected="project_selected" :activity="activity" @selectActivity="selectActivity" @uncheckActivity="uncheckActivity" @checkActivity="checkActivity"/>
          </div>
        </div>        
        <div class="row">
          <div class="col-lg-12 col-md-12 mt-2">
            <button class="btn btn-success w-100 p-3" @click="changeStatus" v-bind:disabled="sumTasksPercent != 100">Enviar a Dirección Académica</button>
          </div>
        </div>
        <h5 class="mt-4">Cliente</h5>
        <CardCustomer v-if="project_selected.customer" :customer="project_selected.customer"/>
      </div> -->
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            vouchers: []
        }
    },
    methods: {
        getAllVouchers() {
            axios.get('/api/vouchers')
                .then((result) => {
                    this.vouchers = result.data
                }).catch((err) => {

                });
        }
    },
    mounted() {
        this.getAllVouchers()
    }
}
</script>
<style lang="">
    
</style>