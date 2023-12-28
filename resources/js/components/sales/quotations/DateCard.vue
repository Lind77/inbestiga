<template>
    <!-- <div class="card shadow-none bg-transparent border border-info mb-3">
        <div class="card-body">
            <div class="mb-3">
            <label class="form-label" for="basic-default-company">Fecha <span class="text-danger">*</span></label>
            <input type="date" v-model="date" class="form-control" id="basic-default-company" />
            </div>
            <div class="mb-0">
            <label class="form-label" for="basic-default-company">Validez</label>
            <input type="date" v-model="dateValidate" class="form-control" id="basic-default-company" />
            </div>
        </div>
    </div> -->
</template>
<script>
import moment from 'moment'
export default {
    props: {
        date: Date,
        dateValidate: Date
    },
    computed: {
        finalDayMonth() {
            return moment().endOf('month').format('DD/MM/YYYY')
        }
    }
}
</script>