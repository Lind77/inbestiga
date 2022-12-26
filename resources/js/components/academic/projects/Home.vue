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
                          <div class="card text-white mb-3 bg-danger cursor-pointer" draggable="true" @dragstart="drag" :id="`${project.id}`" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"
                            @click="showProject(project)"
                            >
                          <!-- <div class="card-header">
                            <p class="mb-0">{{ project.textStatus }}</p>
                          </div> -->
                          <div class="card-body">
                            <h4 class="card-title text-white m-0">{{ project.title }}</h4>
                          </div>
                          </div>
                          </div>
                        </div>
                        
                        </div>
                        <div class="col-md-4" id="directionArea" @drop="drop" @dragover="allowDrop">
                          Dirección académica
                          <div class="container-cards" v-for="project in projects">
                            <div v-if="project.status == 1">
                              <div class="card text-white mb-3 bg-success cursor-pointer" draggable="true" @dragstart="drag" :id="`${project.id}`" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"
                            @click="showProject(project)"
                            >
                          <!-- <div class="card-header">
                            <p class="mb-0">{{ project.textStatus }}</p>
                          </div> -->
                          <div class="card-body">
                            <h4 class="card-title text-white m-0">{{ project.title }}</h4>
                          </div>
                          </div>
                          </div>
                          </div>
                        </div>
                        <div class="col-md-4" id="qualityArea" @drop="drop" @dragover="allowDrop">
                          Calidad académica
                          <div class="container-cards" v-for="project in projects">
                            <div v-if="project.status == 2">
                            <div class="card text-white mb-3 bg-warning" draggable="true" @dragstart="drag" :id="`${project.id}`">
                          <div class="card-header">
                            <p class="mb-0">{{ project.textStatus }}</p>
                            <p class="mb-0">Fecha de Culminación: {{ project.deadline }}</p>
                          </div>
                          <div class="card-body">
                            <a class="text-white" @click="showProgress(project.progress)" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#progressModal">
                                    {{ project.progress.reduce((acc, item)=> acc+item.percentage, 0) }} %
                                    </a>    
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" :style="{width: project.progress.reduce((acc, item)=> acc+item.percentage, 0) + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                            <h4 class="card-title text-white">{{ project.title }}</h4>
                            <div class="card-text w-100">
                              <span class="badge badge-center bg-success">
                                <i class='bx bx-user bx-xs'></i>
                              </span>
                              <span data-bs-toggle="modal" data-bs-target="#teamModal" class="badge badge-center bg-success mx-2">
                                <i class='bx bx-group bx-xs'></i>
                              </span>
                            </div>
                          </div>
                            </div>
                          </div>
                          </div>
                        </div>
                      </div>
                      <OffCanvas v-if="project_selected" :project_selected="project_selected"/>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              
              
              <!-- / Content -->
  
              <div class="content-backdrop fade"></div>
              <ProgressModal :progress="progress" />
              <CreateProject :customers="customers" @getAllProjects="getAllProjects" :owners="owners" :products="products"/>
              <TeamModal/>
  </template>
  <script>
    import ProgressModal from './ProgressModal.vue'
    import CreateProject from './CreateProject.vue'
    import TeamModal from './TeamModal.vue'
    import OffCanvas from './OffCanvas.vue'
    
    export default{
      components: { ProgressModal, CreateProject, TeamModal, OffCanvas },
      data(){
        return{
          projects:[],
          progress:[],
          owners:[],
          customers:[],
          products:[],
          project_selected: null
        }
      },
      methods:{
        showProject(project){
            this.project_selected = project
        },
        showProgress(progress){
            this.progress = progress
        },
        getAllOwners(){
                axios.get('/api/getAllOwners')
                .then(res =>{
                    this.owners = res.data
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
        this.getAllOwners()
      }
    }
  </script>
  <style scoped>
  #div1, #div2 {
    float: left;
    width: 100%;
    height: 35px;
    margin: 10px;
    padding: 10px;
    border: 1px solid black;
  }
  </style>