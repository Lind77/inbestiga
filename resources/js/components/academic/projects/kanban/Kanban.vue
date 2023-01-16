<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Kanban - {{ project.title }}</h4>
        <div class="row">
                        <div class="col-md-4 border border-danger rounded vh-100" id="todoArea" @drop="drop" @dragover="allowDrop">
                          <div class="kanban-header fw-bold text-center">
                            <h4>TO DO</h4>
                          </div>
                          <div class="container-cards">
                            <div v-for="task in tasks">
                              <div v-if="task.status == 0">
                                <CardTask :task="task"/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 border border-warning rounded vh-100" id="doingArea" @drop="drop" @dragover="allowDrop">
                          <div class="kanban-header fw-bold text-center">
                            <h4>DOING</h4>
                          </div>
                          <div class="container-cards">
                            <div v-for="task in tasks">
                              <div v-if="task.status == 1">
                                <CardTask :task="task"/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 border border-success rounded vh-100" id="doneArea" @drop="drop" @dragover="allowDrop">
                          <div class="kanban-header fw-bold text-center">
                            <h4>DONE</h4>
                          </div>
                          <div class="container-cards">
                            <div v-for="task in tasks">
                              <div v-if="task.status == 2">
                                <CardTask :task="task"/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
    </div>
</template>
<script>
import CardActivity from './CardActivity.vue'
import CardTask from './CardTask.vue'
import {useCounterStore} from '../../../../stores/UserStore'

export default {
    components: { CardActivity, CardTask },
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
        return{
            project: [],
            activities: [],
            tasks:[],
            localTime: " ",
            seconds: " "
        }
    },
    methods:{
        getProjectById(){
            axios.get(`/api/getProjectById/${this.$route.params.idProject}`)
            .then(res =>{
                this.project = res.data[0]
                this.activities = this.project.activities
                this.activities.forEach((activity) =>{
                  activity.tasks.forEach((task) =>{
                    this.tasks.push(task)
                  })
                })
            })
        },
        allowDrop(e){
          e.preventDefault()
        },
        drop(e){
          e.preventDefault()
          if(this.store.rol == 'Acad'){ 
          var data = e.dataTransfer.getData('text')
          e.target.appendChild(document.getElementById(data))
          }else{
            alert('Usted no puede modificar las tareas')
          }
        }
    },
    mounted(){
        this.getProjectById()
    }
}
</script>