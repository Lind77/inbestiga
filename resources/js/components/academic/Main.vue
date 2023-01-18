<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Departamento Académico /</span> Inicio</h4>
        <h3>Te damos la bienvenida, {{ store.authUser? store.authUser[0].name : '' }}</h3>
    </div>
</template>
<script>
import { useCounterStore } from '../../stores/UserStore';

export default{
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    mounted(){
      this.store.getUser()
    }
}
</script>