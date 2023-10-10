<template lang="">
    <div class="modal fade" id="areaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4>Nueva área</h4>
                    <div class="mb-3">
                        <label for="form-label">Nombre</label>
                        <input type="text" v-model="name" class="form-control">
                    </div>
                    <div class="col-12 text-center">
                        <button @click="addArea" class="btn btn-primary me-sm-3 me-1">Agregar</button>
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
            name: ''
        }
    },
    methods: {
        addArea() {
            const fd = new FormData()
            fd.append('name', this.name)

            axios.post('/api/areas', fd)
                .then((result) => {
                    $('#areaModal').modal('hide');
                    this.$emit('getAreas')
                }).catch((err) => {
                    console.error(err);
                });
        }
    }
}
</script>
<style lang="">
    
</style>