<template>
     <p v-show="showSelect"> Equipo {{ owner.memoir.team.name }}</p>
    <select v-show="!showSelect" name="" id="" class="form-control">
        <option v-for="team in teams" :value="team.id" v-bind:selected="team.id == owner.memoir.team.id">Equipo {{ team.name }}</option>
    </select>
</template>
<script>
import { directive as onClickOutside } from 'vue-click-outside'
    export default{
        directives:{
            onClickOutside
        },
        data(){
            return{
                owners:[],
                showSelect: true
            }
        },
        props:{
            owner: Object,
            teams: Array
        },
        methods:{
            out(){
                alert('nani')
            },
            doubleClick(){
                this.showSelect = false
            }
        }
    }
</script>