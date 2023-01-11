<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Departamento de Ventas /</span> Inicio</h4>
        <h3>{{ store.authUser[0].name }}, Te damos la bienvenida</h3>
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