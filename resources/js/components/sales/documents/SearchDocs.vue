<template>
    <div class="input-group w-50 ms-2">
        <input type="text" class="form-control" placeholder="Nombre de cliente" aria-label="Recipient's username" v-model="searchWord" aria-describedby="button-addon2">
        <button class="btn btn-outline-primary" @click="searchDoc" type="button" id="button-addon2">Buscar</button>
    </div>
</template>
<script>
    export default{
        props:{
            group: String
        },
        data(){
            return{
                searchWord:''
            }
        },
        methods:{
            searchDoc(){
                axios.get(`/api/search${this.group}/${this.searchWord}`)
                .then(res =>{
                    console.log(res)
                })
                .catch(err =>{
                    console.error(err)
                })
            }
        }
    }
</script>