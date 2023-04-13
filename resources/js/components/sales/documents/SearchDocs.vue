<template>
    <div class="row">
        <div class="col-6">
            <div class="input-group ps-3">
        <input type="text" class="form-control" placeholder="Nombre de cliente" aria-label="Recipient's username" v-model="searchWord" aria-describedby="button-addon2">
        <button class="btn btn-outline-primary" @click="searchDoc" type="button" id="button-addon2">Buscar</button>
        </div>
        </div>
        <div class="col-3">
            <input type="date" v-model="date" @change="searchByDate" class="form-control">
        </div>
        <div class="col-3">
            <button class="btn btn-danger" @click="cleanSearch">Limpiar</button>
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            group: String
        },
        data(){
            return{
                searchWord:'',
                date: null
            }
        },
        methods:{
            searchDoc(){
                if(this.searchWord != ''){
                    axios.get(`/api/search${this.group}/${this.searchWord}`)
                    .then(res =>{
                        console.log(res)
                        this.$emit('updateRows', res.data)
                    })
                    .catch(err =>{
                        console.error(err)
                    })
                }
            },
            searchByDate(){
                axios.get(`/api/search${this.group}ByDate/${this.date}`)
                .then(res =>{
                    console.log(res)
                    this.$emit('updateRows', res.data)
                })
                .catch(err =>{
                    console.error(err)
                })
            },
            cleanSearch(){
                this.$emit('getAllQuotations')
            }
        }
    }
</script>