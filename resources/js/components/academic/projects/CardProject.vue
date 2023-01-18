<template>        
    <div :class="`card text-white mb-3 ${bgColor} cursor-pointer`" draggable="true" @dragstart="drag" :id="`${project.id}`">
    <!-- <div class="card-header">
        <p class="mb-0">{{ project.textStatus }}</p>
    </div> -->
    <div class="card-body">
        <div class="h6 text-white" v-if="project.team">Equipo {{ project.team.name }}</div>
        <h4 class="card-title text-white m-0">{{ project.title }}</h4>
        <router-link v-if="this.project.status == 1" class="btn btn-primary btn-sm mt-2" :to="{name:'kanban', params:{ idProject: project.id }}">Ver Kanban</router-link>
        <div v-if="this.project.status == 1" class="btn btn-primary btn-sm mt-2 ms-1" @click="updateQuality">Listo</div>
    </div>
    </div>
    
</template>
<script>
    export default{
        name:'CardProject',
        data(){
            return{
                project_selected: {}
            }
        },
        props:{
            project: Object
        },
        methods:{         
        drag(e){
          e.dataTransfer.setData('text', e.target.id)
        },
        updateQuality(){
            axios.get(`/api/updateQuality/${this.project.id}`)
            .then(res =>{
                console.log(res)
                this.$emit('getAllProjects')
            })
            .catch(err =>{
                console.log(err)
            })
        }
        },
        computed:{
            bgColor(){
                if(this.project.status == 0){
                    return 'bg-danger'
                }else if(this.project.status == 1){
                    return 'bg-success'
                }else if(this.project.status == 2){
                    return 'bg-warning'
                }
            }        
        }
    }
</script>