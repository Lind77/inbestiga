<template>
    <div class="d-flex align-items-center gap-2 flex-grow-1">
        <!-- Search bar -->
        <div class="flex-grow-1">
            <div class="input-group custom-input-group shadow-xs mb-0">
                <span class="input-group-text custom-addon"><i class="bx bx-search fs-5"></i></span>
                <input
                    type="text"
                    class="form-control custom-input"
                    placeholder="Buscar por nombre de cliente..."
                    @keyup="cleanLeads"
                    v-on:keyup.enter="searchByName"
                    v-model="search"
                />
            </div>
        </div>
        <!-- Date Filter -->
        <div style="min-width: 200px;">
            <div class="input-group custom-input-group shadow-xs mb-0">
                <span class="input-group-text custom-addon"><i class="bx bx-calendar fs-5"></i></span>
                <input
                    type="date"
                    @change="filterDate"
                    class="form-control custom-input"
                />
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

<style scoped>
.custom-input-group {
    border-radius: 8px;
    overflow: hidden;
    height: 42px;
}

.custom-addon {
    border-right: none !important;
    padding-right: 0.5rem;
    padding-left: 0.85rem;
    display: flex;
    align-items: center;
}

.custom-input {
    border-left: none !important;
    font-size: 0.9rem;
    height: 42px;
}

/* Light Mode Input Overrides */
:deep(body.light-mode) .custom-addon,
body.light-mode .custom-addon {
    background-color: #FFFFFF !important;
    border: 1px solid #D1D5DB !important;
    border-right: none !important;
    color: #64748B !important;
}

:deep(body.light-mode) .custom-input,
body.light-mode .custom-input {
    background-color: #FFFFFF !important;
    border: 1px solid #D1D5DB !important;
    border-left: none !important;
    color: #0F172A !important;
}

:deep(body.light-mode) .custom-input::placeholder,
body.light-mode .custom-input::placeholder {
    color: #94A3B8 !important;
}

/* Dark Mode Input Overrides */
body.dark-mode .custom-addon,
.custom-addon {
    background-color: #222222 !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-right: none !important;
    color: #94A3B8 !important;
}

body.dark-mode .custom-input,
.custom-input {
    background-color: #222222 !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-left: none !important;
    color: #FFFFFF !important;
}
</style>