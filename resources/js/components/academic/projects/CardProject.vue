<template>        
    <div :class="`card mb-3 bg-light cursor-move`" draggable="true" @dragstart="drag" :id="`${project.id}`">
    <!-- <div class="card-header">
        <p class="mb-0">{{ project.textStatus }}</p>
    </div> -->
    <div class="card-body">
        <div class="badge rounded-pill bg-label-success"> {{ project.product.title }}</div>
        <!-- <div class="h6 text-white" v-if="project.team">Equipo {{ project.team.name }}</div> -->
        <h4 class="card-title h5 mt-3">{{ project.title }}</h4>
            <router-link v-if="this.project.status == 1" class="btn btn-primary btn-sm mt-2" :to="{name:'kanban', params:{ idProject: project.id }}">Ver Kanban</router-link>
        <div v-if="tasksPercent == 100" class="btn btn-primary btn-sm mt-2 ms-1" @click="updateQuality">Listo</div>
        <div v-if="this.project.status == 2" class="btn btn-info btn-sm mt-2 ms-1" @click="pointsQual">Indicadores de Calidad</div>
        <router-link v-if="project.customer" target="_blank" :to="{name:'ecard', params:{ id: project.customer.id}}"><i class='bx bx-credit-card-alt'></i></router-link>
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
        pointsQual(){
            $('#qualityModal').modal('show')
        },   
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
            },
            tasksPercent(){
                var activities_filtered = []
                var tasks_filtered = []
                var totalPercent = 0
                this.project.activities.forEach(activity => {
                    if(activity.type != 0){
                        activities_filtered.push(activity)
                        activity.tasks.forEach(task =>{
                        tasks_filtered.push(task)
                    })
                    }
                });

                tasks_filtered.forEach(task =>{
                    totalPercent = totalPercent + task.progress.percentage
                })

                return totalPercent / tasks_filtered.length
            }        
        }
    }
</script>