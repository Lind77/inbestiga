<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Seguimiento de Proyectos 
      <!-- <span v-if="store.rol == 'AdminAcad'" class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#projectModal">+</span> -->
    </h4>
    <div class="row">
      <div class="col-md-4" id="clientArea" @drop="drop" @dragover="allowDrop">
       <p class="fw-bold h5">Clientes</p> 
      <div class="container-cards" v-for="project in projects">
        <div v-if="project.status == 0">
          <CardProject :project="project" @click="showProject(project)"/>
        </div>
      </div>
      
      </div>
      <div class="col-md-4" id="directionArea" @drop="drop" @dragover="allowDrop">
        <p class="fw-bold h5">Dirección académica</p>
        <div class="container-cards" v-for="project in projects">
          <div v-if="project.status == 1">
            <CardProject :project="project"/>
        </div>
        </div>
      </div>
      <div class="col-md-4" id="qualityArea" @drop="drop" @dragover="allowDrop">
        <p class="fw-bold h5">Calidad académica</p>
        <div class="container-cards" v-for="project in projects">
          <div v-if="project.status == 2">
            <CardProject :project="project"  @getAllProjects="getAllProjects"/>
        </div>
        </div>
      </div>
    </div>
  </div>

  <CreateProject :customers="customers" @getAllProjects="getAllProjects" :teams="teams"/>
  <OffCanvas :project_selected="project_selected" @getAllProjects="getAllProjects"/>
  <QualityModal/>
</template>

<script>
    import {useCounterStore} from '../../../stores/UserStore'
    import CreateProject from './CreateProject.vue'
    import CardProject from './CardProject.vue'
    import OffCanvas from './OffCanvas.vue'
    import QualityModal from './QualityModal.vue'
    
    export default{
      setup(){
      const store = useCounterStore()
      return{
        store
      }
      },
      components: { CreateProject, CardProject, OffCanvas, QualityModal },
      data(){
        return{
          projects:[],
          progress:[],
          teams:[],
          customers:[],
          products:[],
          project_selected: {},
          activities: []
        }
      },
      methods:{
        showProject(project){
            this.project_selected = project
            if(this.project_selected.title){
              $('#offcanvas').offcanvas('show')
            }
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
                this.$swal({
                  title: 'Cargando ...',
                  showConfirmButton: false,
                });
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
                  this.$swal.close()
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
        Echo.private('projects')
        .listen('NewProject',(e)=>{
          console.log(e)
          this.getAllProjects()
        })
      }
    }
  </script>