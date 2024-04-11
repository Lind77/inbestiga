<template>
    <div class="modal fade" id="indicatorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Indicadores de calidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <class class="mb-2">
                        <template v-for="(indicator, index) in indicators" :key="index">
                            <label for="firstMeetingDetails" class="form-label">Criterio {{ index + 1 }}</label> <i
                                class="bx bx-trash text-danger" @click="deleteIndicator(index)"></i>
                            <input type="text" class="form-control" v-model="indicator.name">
                        </template>
                    </class>

                    <button class="btn btn-icon btn-primary" @click="newIndicator">+</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Salir
                    </button>
                    <button type="button" class="btn btn-primary" @click="syncIndicators">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        indicators: Object,
        assignedActivityId: Number
    },
    methods: {
        deleteIndicator(index) {
            this.indicators.splice(index, 1)
        },
        deleteQualityIndicator(indicatorId) {
            axios.delete('/api/delete-indicator/' + indicatorId)
                .then((result) => {
                    var indexFinded = this.indicators.indexFinded();
                }).catch((err) => {
                    this.$emit('getProject')
                    $('#newTaskModal').modal('hide')
                });
        },
        newIndicator() {
            var indicator = {
                value: ''
            }
            this.indicators.push({ ...indicator })
        },
        syncIndicators() {
            const fd = new FormData();

            fd.append('indicators', JSON.stringify(this.indicators))
            fd.append('assignedActivityId', this.assignedActivityId)
            fd.append('_method', 'put')
            axios.post('/api/assigned-activity/' + this.assignedActivityId, fd)
                .then((res) => {
                    $('#indicatorsModal').modal('hide')
                })
                .catch((err) => {
                    console.error(err)
                })
        }
    }
}
</script>
<style lang="">

</style>