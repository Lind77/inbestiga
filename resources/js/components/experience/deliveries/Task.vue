<template>
    <li class="email-list-item email-marked-read py-3 px-5" data-starred="true" data-bs-toggle="sidebar"
        data-target="#app-email-view">
        <div class="d-flex align-items-center">
            <div class="form-check">
                <input class="email-list-item-input form-check-input" type="checkbox" id="email-1" @click="checkTask"
                    v-model="check">
                <label class="form-check-label" for="email-1"></label>
            </div>

            <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                <span class="email-list-item-username me-2 h6">{{
                    task.customerName
                }}</span>
                <span class="email-list-item-subject d-xl-inline-block d-block"> {{
                    task.advance
                }}</span>
            </div>
            <div class="email-list-item-meta ms-auto d-flex align-items-center">
                <span @click="editDates"
                    class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
                    data-label="private" v-if="!task.deliveryDateAcad"></span>
                <span class="email-list-item-label badge badge-dot bg-primary d-none d-md-inline-block me-2"
                    data-label="private" v-else></span>
                <small class="email-list-item-time text-muted">{{
                    formatDate(task.deliveryDate)
                }}</small>
                <small class="email-list-item-time text-muted" v-if="task.deliveryDateAcad">
                    - {{
                        formatDate(task.deliveryDateAcad)
                    }}</small>
                <input v-if="showDateAcad" type="date" class="form-control form-control-sm" @blur="hideDates(task)"
                    v-model="academicDate">
            </div>
        </div>
    </li>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
export default {
    data() {
        return {
            showDateAcad: false,
            academicDate: '',
            check: false
        }
    },
    props: {
        task: Object
    },
    methods: {
        checkTask() {
            if (this.check == true) {
                alert('uncheck')
            } else {
                if (this.task.type == 1) {
                    axios.get('/api/check-delivery/' + this.task.id)
                        .then((result) => {
                            console.log(result);
                        }).catch((err) => {
                            console.error(err);
                        });
                } else {
                    axios.get('/api/check-payment/' + this.task.id)
                        .then((result) => {
                            console.log(result);
                        }).catch((err) => {
                            console.error(err);
                        });
                }
            }

        },
        hideDates(task) {
            if (this.academicDate != '') {
                const fd = new FormData()
                fd.append('_method', 'put')
                fd.append('deliveryId', task.id)
                fd.append('academicDate', this.academicDate)
                axios.post('/api/delivery/' + task.id, fd)
                    .then((result) => {
                        this.$emit('updateDelivery', result.data.delivery)
                        this.showDateAcad = false
                    }).catch((err) => {
                        console.error(err)
                    });
            } else {
                this.showDateAcad = false
            }
        },
        editDates() {
            this.showDateAcad = true
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY')
        },
    }
}
</script>
<style lang="">
    
</style>