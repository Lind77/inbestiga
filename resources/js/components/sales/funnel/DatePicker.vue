<template>
    <div class="row mb-3">
        <label for="">Seleccionar fecha de Siguiente Gestión</label>
        <input type="date" @change="filterDate" class="form-control w-25 ms-2">
      </div>
</template>
<script>
export default {
    methods:{
        filterDate(e){
            this.$emit('filterDate', e.target.value)
        }
    }
}
</script>