<template>
    <div class="col">
        <div class="kanban-header fw-bold">
              <h4>To Do ({{ tasks.filter(task => task.status === 0).length}})</h4>
        </div>
        <div :id="'draggableKanban'+status" class="container-cards overflow-auto vh-100" @drop="drop" @dragenter.prevent @dragover.prevent>
            <template v-for="(task, index) in tasks" :key="index">
                    <template v-if="task.status == status">
                        <CardTask :task="task"/>
                    </template>
            </template>
        </div>
    </div>
</template>
<script>
    import CardTask from './CardTask.vue'

    export default {
        components:{ CardTask },
        props:{
            title: String,
            tasks: Array,
            status: Number
        },
        methods:{
            drop(e){
                console.log('nani')
            }
        }
    }
</script>
