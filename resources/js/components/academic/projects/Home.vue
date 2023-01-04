<template>
              <!-- Content -->
  
              <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">Proyectos <span class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#projectModal">+</span></h4>
                <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Buscador de Proyectos en Marcha</h5>
                    </div>
                    <div class="card-body">
                      <form>
                        <input type="text" class="form-control mb-3" />
                        
                        <div class="table-responsive text-nowrap">
                          <!-- <table class="table">
                            <thead class="table-primary">
                              <tr class="text-nowrap">
                                <th>Clientes</th>
                                <th>Dirección Académica</th>
                                <th>Calidad Académica</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr v-for="project in projects">
                                <td><strong>{{project.customer.name}}</strong></td>
                                <td>{{project.customer.career}}</td>
                                <td>{{project.customer.university}}</td>
                                <td><button type="button" class="btn btn-primary">
                                Grupo
                                </button>
                                </td>
                                <td>
                                    <a @click="showProgress(project.progress)" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#progressModal">
                                    {{ project.progress.reduce((acc, item)=> acc+item.percentage, 0) }} %
                                    </a>    
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" :style="{width: project.progress.reduce((acc, item)=> acc+item.percentage, 0) + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <p v-for="percent in project.progress">{{ percent.percentage }}</p>
                                </td>
                                <td>{{ project.deadline }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Agregar tareas" data-bs-original-title="<i class='bx bx-bell bx-xs' ></i> <span>Agregar tareas</span>">
                                    <i class='bx bx-plus bx-xs' ></i>
                                    </button>
                                </td>
                                <td style="white-space: pre-line">{{product.description}}</td>
                                <td>{{product.term}}</td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table> -->
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Seguimiento de Proyectos</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4" id="clientArea" @drop="drop" @dragover="allowDrop">
                          Clientes
                        <div class="container-cards" v-for="project in projects">
                          <div v-if="project.status == 0">
                            <CardProject :project="project" @click="showProject(project)"/>
                          </div>
                        </div>
                        
                        </div>
                        <div class="col-md-4" id="directionArea" @drop="drop" @dragover="allowDrop">
                          Dirección académica
                          <div class="container-cards" v-for="project in projects">
                            <div v-if="project.status == 1">
                              <CardProject :project="project"  @click="showProject(project)"/>
                          </div>
                          </div>
                        </div>
                        <div class="col-md-4" id="qualityArea" @drop="drop" @dragover="allowDrop">
                          Calidad académica
                          <div class="container-cards" v-for="project in projects">
                            <div v-if="project.status == 2">
                              <CardProject :project="project"  @click="showProject(project)"/>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <!-- / Content -->

              <CreateProject :customers="customers" @getAllProjects="getAllProjects" :teams="teams"/>
              <TeamModal/>
              <OffCanvas ref="offCanvas" :project_selected="project_selected" :progresses = "project_selected.progresses" />
  </template>
  <script>
    
    import CreateProject from './CreateProject.vue'
    import TeamModal from './TeamModal.vue'
    import CardProject from './CardProject.vue'
    import OffCanvas from './OffCanvas.vue'
    
    export default{
      components: { CreateProject, TeamModal, CardProject, OffCanvas },
      data(){
        return{
          projects:[],
          progress:[],
          teams:[],
          customers:[],
          products:[],
          project_selected: {}
        }
      },
      methods:{
        showProject(project){
            this.project_selected = project
        },
        showProgress(progress){
            this.progress = progress
        },
        getAllTeams(){
                axios.get('/api/getAllTeams')
                .then(res =>{
                    this.teams = res.data
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
        },
        getAllCustomers(){
                axios.get('/api/getAllCustomers')
                .then(res =>{
                    this.customers = res.data
                })
                .catch(err =>{
                    console.log(err.response.data)
                })
        },  
        getAllProjects(){
                this.project_selected = {}
                axios.get('/api/getAllProjects')
                .then(res =>{
                  this.projects = res.data

                  this.projects.forEach(element =>{
                    if(element.status == 0){
                      element.textStatus = 'Sin primer contacto'
                    }
                    else if(element.status == 1){
                      element.textStatus = 'En desarrollo'
                    }else if(element.status == 2){
                      element.textStatus = 'En revisión'
                    }
                  })
                })
                .catch(err =>{
                  console.log(err.response.data)
                })
        },
        getAllProducts(){
                axios.get('/api/getAllProducts')
                .then(res =>{
                  console.log(res)
                  this.products = res.data
                })
                .catch(err =>{
                  console.log(err.response.data)
                })
        },
        allowDrop(e){
          e.preventDefault()
        },
        drag(e){
          console.log('draggeando')
          e.dataTransfer.setData('text', e.target.id)
        },
        drop(e){
          e.preventDefault()
          console.log()
          var data = e.dataTransfer.getData('text')

          var idArea = e.path[0].id

          var idStatus = 0

          if(idArea == 'clientArea'){
            idStatus = 0
          }else if(idArea == 'directionArea'){
            idStatus = 1
          }else if(idArea == 'qualityArea'){
            idStatus = 2
          }  

          if(confirm('Estas seguro de cambiar de estado a este proyecto?')){

            const fd = new FormData()

            fd.append('status', idStatus)
            fd.append('project_id', data)

            axios.post('/api/changeStatusProject', fd)
            .then(res =>{
              console.log(res.data)
              this.getAllProjects()
            })
            .catch(err =>{
              console.log(err.response.data)
            })
            //e.target.appendChild(document.getElementById(data))
          }
        }
      },
      mounted(){
        this.getAllProjects()
        this.getAllCustomers()
        this.getAllTeams()
      }
    }
  </script>