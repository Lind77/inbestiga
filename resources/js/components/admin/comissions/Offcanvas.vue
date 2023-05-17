<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComission" aria-labelledby="offcanvasEndLabel">
      <div class="offcanvas-header">
        <h3 id="offcanvasEndLabel" class="offcanvas-title"></h3>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <div class="card bg-info my-2 text-white" v-for="comission in comissions">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <p>{{ comission.concept }} - {{ comission.percent }}%</p>
                <i class="bx bx-x cursor-pointer" @click="deleteComission(comission.id)"></i>
              </div>
            </div>
            <div class="card-body">
              <p class="mb-0">{{ comission.user.name }}</p>
            </div>
        </div>
       
      </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props:{
        comissions: Array
    },
    methods:{
      deleteComission(comissionId){
        axios.get('/api/deleteComission/'+comissionId)
        .then((res)=>{
          
        })
        .catch((err)=>{

        })
      }
    }
}
</script>
<style>
    
</style>