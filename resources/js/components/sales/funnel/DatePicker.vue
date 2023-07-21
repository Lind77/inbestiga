<template>
    <div class="row mb-3">
        <input type="text" class="form-control w-50" placeholder="Buscar por nombre ..." @keyup="cleanLeads"
            v-on:keyup.enter="searchByName" v-model="search">
        <input type="date" @change="filterDate" class="form-control w-25 ms-2">
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            search: ''
        }
    },
    methods: {
        filterDate(e) {
            this.$emit('filterDate', e.target.value)
        },
        searchByName() {
            axios.get('/api/quotations/search/' + this.search)
                .then((res) => {
                    console.log('respuesta de busqueda', res);
                    this.$emit('distributeQuotations', res.data)
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        cleanLeads() {
            if (this.search == '') {
                this.$emit('getAllQuotations')
            }
        }
    }
}
</script>