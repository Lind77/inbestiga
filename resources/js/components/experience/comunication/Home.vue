<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Comunicaciones</h4>
        <div class="row">
            <div class="col-4">
                <div class="card bg-info text-white mb-1 cursor-pointer" @click="showTable(comunication)"
                    v-for="(comunication, index) in comunications">
                    <div class="card-header">{{ comunication.customer.name }}</div>
                    <div class="card-body">
                        {{ formatDate(comunication.next_management) }}
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card-info text-white" v-if="comunicationSelected.customer">
                    <div class="card-body">
                        <p>Nombre: {{ comunicationSelected.customer.name }}</p>
                        <p>Carrera: {{ comunicationSelected.customer.career }}</p>
                        <p>Universidad: {{ comunicationSelected.customer.university }}</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card-info text-white mb-1" v-if="comunicationSelected.customer"
                    v-for="comunication in comunicationSelected.customer.comunications">
                    <div class="card-body">
                        <p>{{ comunication.created_at }}</p>
                        <p>{{ comunication.comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            comunications: [],
            comunicationSelected: {}
        }
    },
    methods: {
        showTable(comunication) {
            this.comunicationSelected = comunication
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY');
        },
        getComunications() {
            axios.get('/api/comunications')
                .then((result) => {
                    console.log(result);
                    this.comunications = result.data
                }).catch((err) => {
                    console.error(err);
                });
        }
    },
    mounted() {
        this.getComunications()
    }
}
</script>
<style>
.card-info {
    background: #07E878;
}
</style>