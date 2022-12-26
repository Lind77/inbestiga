<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasEndLabel">
                          <div class="offcanvas-header">
                            <h3 id="offcanvasEndLabel" class="offcanvas-title">{{ project_selected.title }}</h3>
                            <button
                              type="button"
                              class="btn-close text-reset"
                              data-bs-dismiss="offcanvas"
                              aria-label="Close"
                            ></button>
                          </div>
                          <div class="offcanvas-body my-auto mx-0 flex-grow-0">

                            <h5>Fecha de Culminación: {{ project_selected.deadline }}</h5>
                            
                            <h5>Estado</h5>
                            <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" @click="addProgress()" data-bs-toggle="modal" data-bs-target="#progressModal" id="defaultCheck1"/>   
                            <label class="form-check-label" for="defaultCheck1"> {{ project_selected.textStatus }} </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck2" disabled="" />
                            <label class="form-check-label" for="disabledCheck2">
                              Asignar grupo  
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck2" disabled="" />
                            <label class="form-check-label" for="disabledCheck2">
                              Programar primera reunión con Dirección Académica  
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck2" disabled="" />
                            <label class="form-check-label" for="disabledCheck2">
                              Reunión con Dirección Académica  
                            </label>
                            </div>
                            <h5>Porcentaje</h5>
                            <a href="javascript:void(0)">
                                    {{ project_selected.progress.reduce((acc, item)=> acc+item.percentage, 0) }} %
                                    </a>    
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" :style="{width: project_selected.progress.reduce((acc, item)=> acc+item.percentage, 0) + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                            </div>
                            <h5 class="mt-4">Cliente</h5>
                            <p>Nombre: {{ project_selected.customer.name }}</p>
                            <p>Celular: {{ project_selected.customer.cell }}</p>
                            <p>Universidad: {{ project_selected.customer.university }}</p>
                            <p>Carrera: {{ project_selected.customer.career }}</p>
                           <!--  <button type="button" class="btn btn-primary mb-2 d-grid w-100">Continue</button>
                            <button
                              type="button"
                              class="btn btn-outline-secondary d-grid w-100"
                              data-bs-dismiss="offcanvas"
                            >
                              Cancel
                            </button> -->
                          </div>
                        </div>
</template>
<script>
export default{
    props:{
        project_selected: Object
    },
    methods:{
        addProgress(e){
            e.preventDefault()
        }
    }
} 
</script>