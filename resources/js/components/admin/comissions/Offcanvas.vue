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
            <div class="card-header">{{ comission.concept }} - {{ comission.percent }}%</div>
            <div class="card-body">
              <p>{{ comission.user.name }}</p>
            </div>
        </div>
       
      </div>
    </div>
</template>
<script>
export default {
    props:{
        comissions: Array
    }
}
</script>
<style>
    
</style>