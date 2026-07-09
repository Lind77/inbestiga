<template>
    <div class="card-body pb-3 px-0">
        <div class="row g-3">
            <!-- Search bar -->
            <div class="col-12 col-md-7">
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar por nombre de cliente..."
                        @keyup="cleanLeads"
                        v-on:keyup.enter="searchByName"
                        v-model="search"
                    />
                </div>
            </div>
            <!-- Date Filter -->
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                    <input
                        type="date"
                        @change="filterDate"
                        class="form-control"
                    />
                </div>
            </div>
        </div>
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
                    this.$emit('distributeEntities', res.data)
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