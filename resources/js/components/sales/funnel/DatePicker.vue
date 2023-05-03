<template>
    <div class="row mb-3">
        <input type="text" class="form-control w-25" @keyup="cleanLeads" v-model="search">
        <button class="btn btn-primary btn-sm w-25" @click="searchByName">Buscar</button>
        <input type="date" @change="filterDate" class="form-control w-25 ms-2">
      </div>
</template>
<script>
import axios from 'axios';

export default {
    data(){
        return{
            search: ''
        }
    },
    methods:{
        filterDate(e){
            this.$emit('filterDate', e.target.value)
        },
        searchByName(){
            axios.get('/api/searchCustomers/'+this.search)
            .then((res) => {
                this.$emit('distributeLeads', res.data)
            })
            .catch((err) =>{
                console.error(err)
            })
        },
        cleanLeads(){
            if(this.search == ''){
                this.$emit('getAllCustomers')
            }
        }
    }
}
</script>