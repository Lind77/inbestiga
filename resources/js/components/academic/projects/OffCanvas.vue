<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasEndLabel">
      <div class="offcanvas-header">
        <h3 id="offcanvasEndLabel" class="offcanvas-title">{{ project_selected.title }}<small class="text-primary h5" v-if="project_selected.team"> (Equipo {{ project_selected.team.name }})</small></h3>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      
      <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <a href="javascript:void(0)">{{ sumTasksPercent }} %</a>
        <div class="progress mb-3">
          <div class="progress-bar" role="progressbar" :style="{width: sumTasksPercent + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
          </div>
        </div>
        <h5 class="text-danger">Fecha de Culminación: {{ project_selected.deadline }}</h5>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-6 mb-2">
          <div v-for="progress in progresses">
            <div :class="`card ${progress.percentage == 100 ? 'bg-success' : 'bg-danger'} mb-1`">
              <div class="card-body p-3">
                <div class="card-title d-flex align-items-center justify-content-between mb-0">
                  <h5 class="text-white mb-0">{{ progress.activity.title }}</h5>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" :id="`taskCheck${progress.activity.id}`" data-bs-toggle="modal" data-bs-target="#progressModal" :checked="progress.percentage == 100" @click="addProgress(progress, $event)">
                    </div> 
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
        <h5 class="mt-4">Cliente</h5>
        <CardCustomer v-if="project_selected.customer" :customer="project_selected.customer"/>
      </div>
    </div>
    <ProgressModal :progress="progress_selected" :project_selected="project_selected"/>
</template>
<script>
//import moment from 'moment'
import ProgressModal from './ProgressModal.vue'
import CardTeam from './CardTeam.vue'
import CardCustomer from './CardCustomer.vue'

export default{
    name:'OffCanvas',
    components:{ CardTeam, CardCustomer, ProgressModal },
    props:{
        project_selected: Object,
        progresses: Array
    },
    data(){
      return {
        fecha: new Date(),
        progress_selected: {}
      }
    },
    methods:{
        addProgress(progress, e){
            document.getElementById(e.target.id).indeterminate = true
            this.progress_selected = progress
        }
    },
    computed:{
      sumTasksPercent(){
        if(this.progresses){
          var sumTasks = 0
          var numTasks = 0
          this.progresses.forEach(progress => {
              sumTasks = sumTasks + progress.percentage
              numTasks = numTasks + 1
          });
          return sumTasks / numTasks
        }
      }
      /* sumPercent(){
        if(this.project_selected.tasks){
          return this.project_selected.acttasks.reduce((acc, item) => acc + item.pivot.percent, 0)/this.project_selected.tasks.length;
        }
      } */
    }
} 
</script>