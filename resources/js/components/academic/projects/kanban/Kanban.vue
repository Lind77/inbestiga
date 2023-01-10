<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Kanban</h4>
        <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center" v-if="project">
                      <h5 class="mb-0">{{ project.title }}</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4" id="todoArea" @drop="drop" @dragover="allowDrop">
                          TO DO
                        <div class="container-cards" v-for="activity in activities">
                          <div v-if="activity.type != 0">
                            <CardActivity :activity="activity"/>
                          </div>
                        </div>
                        
                        </div>
                        <div class="col-md-4" id="doingArea" @drop="drop" @dragover="allowDrop">
                          DOING
                          <div class="container-cards" v-for="activity in activities">
                            <div v-for="task in activity.tasks">
                              <div v-if="task.status == 1">
                                <CardTask :task="task"/>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4" id="doneArea" @drop="drop" @dragover="allowDrop">
                          DONE
                          <div class="container-cards" v-for="activity in activities">
                            <div v-for="task in activity.tasks">
                              <div v-if="task.status == 2">
                                <CardTask :task="task"/>
                              </div>
                            </div>
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

export default {
    components: { CardActivity, CardTask },
    data(){
        return{
            project: [],
            activities: [],
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
            })
        },
        allowDrop(e){
          e.preventDefault()
        },
        drop(e){
          e.preventDefault()
          var data = e.dataTransfer.getData('text')
          console.log(data)
          e.target.appendChild(document.getElementById(data))

          console.log(data)
          if(e.target.id == 'doingArea'){
            
          }
        }
    },
    mounted(){
        this.getProjectById()
    }
}
</script>