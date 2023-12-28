<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="fw-bold py-3">Gestión de Proyectos</h4>
          <div>
            <EspecialButton :title="'Cantidad'" :icon="'bx bx-user'" :number="projects.length" />
            <EspecialButton :title="'Equipos'" :icon="'bx bx-group'" :number="0" />
            <EspecialButton :title="'Reportes'" :icon="'bx bx-line-chart'" :number="0" />
          </div>
        </div>
      </div>
      <div class="card w-100 mt-5 mb-5">
        <div class="row px-3">
          <div class="col">
            <label for="">Categoría</label>
            <select class="form-control" @change="filterProjectsByCategory" v-model="categorySelected">
              <option value="1">Ingeniería</option>
              <option value="2">Ciencias Médicas</option>
              <option value="3">Derecho</option>
              <option value="4">Ciencias contables</option>
              <option value="5">Ciencias sociales</option>
            </select>
          </div>
          <div class="col">
            <label for="">Buscador</label>
            <input type="text" v-model="search" class="form-control" placeholder="Buscar..."
              @keyup.enter="searchProjectByWord">
          </div>
          <div class="col">
            <label for="">Estado</label>
            <select class="form-control">
              <option value="1">To Do</option>
              <option value="2">Doing</option>
              <option value="3">Done</option>
              <option value="4">Stand By</option>
            </select>
          </div>
        </div>
      </div>
      <div class="nav-align-top mb-4 px-2">
        <ul class="nav nav-pills mb-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Home</button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false"
              tabindex="-1">Tabla</button>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
            <div class="row row-cols-3">
              <CardProject v-for="project in projectsFiltered" :project="project" @getAllProjectsAcad="getAllProjectsAcad"
                @showTeamModal="showTeamModal" />

            </div>
            <div class="d-flex align-items-center justify-content-center mt-4">
              <template v-for="(n, index) in totalProjects">
                <button class="btn btn-icon btn-primary mx-1" v-if="index % 9 == 0">{{ (index / 9) + 1 }}</button>
              </template>

            </div>
          </div>
          <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
            <ProjectTable :projects="projectsFiltered" />
          </div>
        </div>
      </div>



    </div>
    <!-- <span v-if="store.rol == 'AdminAcad'" class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#projectModal">+</span> -->
  </div>
  <!-- <OffCanvas :project_selected="project_selected" @getAllProjects="getAllProjectsAcad" /> -->
  <QualityModal :qualityActivities="qualityActivities" />
  <TeamModal :contract="contractId" @getAllProjectsAcad="getAllProjectsAcad" />
</template>

<script>
import { userStore } from '../../../stores/UserStore'
import EspecialButton from './EspecialButton.vue'
import CardProject from './CardProject.vue'
import OffCanvas from './OffCanvas.vue'
import QualityModal from './QualityModal.vue'
import TeamModal from './TeamModal.vue'
import ProjectTab from './ProjectTab.vue'
import ProjectTable from './ProjectTable.vue'


export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { CardProject, OffCanvas, QualityModal, TeamModal, ProjectTab, EspecialButton, ProjectTable },
  data() {
    return {
      projects: [],
      progress: [],
      teams: [],
      customers: [],
      products: [],
      project_selected: {},
      activities: [],
      qualityActivities: [],
      contractId: 0,
      projectsFiltered: [],
      categorySelected: 0,
      search: '',
      totalProjects: 0
    }
  },
  methods: {
    showTeamModal(contractId) {
      this.contractId = contractId;
      $('#teamModal').modal('show');
    },
    searchProjectByWord() {
      if (this.search == '') {
        this.projectsFiltered = this.projects
      } else {
        this.projectsFiltered = []
        axios.get('/api/search-projects/' + this.search)
          .then((result) => {
            this.projectsFiltered = result.data
          }).catch((err) => {

          });
        /* this.projects.forEach((project) => {
          if (project.propertiable && project.propertiable.quotation) {
            project.propertiable.quotation.customers.forEach((customer) => {
              if (customer.name.toLowerCase().includes(this.search)) {
                this.projectsFiltered.push({ ...project })
              }
            })
          }
        }) */
      }

    },
    filterProjectsByCategory() {
      console.log(this.projects);
      this.projectsFiltered = []
      this.projects.forEach((project) => {
        var category = JSON.parse(project.projectable.properties[0].properties)
        var forkInvestigation = category.filter(question => question.type == 6)

        if (forkInvestigation && forkInvestigation[0]) {
          if (forkInvestigation[0].answer == this.categorySelected) {
            this.projectsFiltered.push({ ...project })
          }
        }

      })
    },
    enterProject(projectId) {
      alert('nani' + projectId);
    },
    filterProjects(index) {
      this.projectsFiltered = []
      this.projects.forEach(project => {
        var properties = JSON.parse(project.properties);
        var forkInvestigation = properties.filter(property => property.type == 6)
        console.log(forkInvestigation);
        if (forkInvestigation[0] && forkInvestigation[0].answer == index) {
          this.projectsFiltered.push({ ...project })
        }
      })
    },
    showModalAssignation(project) {
      console.log(project.propertiable_id);
      this.contractId = project.propertiable_id;
      $('#teamModal').modal('show')
    },
    showQualityModal(qualityActivities) {
      this.qualityActivities = qualityActivities
      $('#qualityModal').modal('show')
    },
    showProject(project) {
      this.project_selected = project
      if (this.project_selected.title) {
        $('#offcanvas').offcanvas('show')
      }
    },
    showProgress(progress) {
      this.progress = progress
    },
    getAllTeams() {
      axios.get('/api/getAllTeams')
        .then(res => {
          this.teams = res.data
        })
        .catch(err => {
          console.log(err.response.data)
        })
    },
    getAllCustomers() {
      axios.get('/api/customers')
        .then(res => {
          this.customers = res.data
        })
        .catch(err => {
          console.log(err.response.data)
        })
    },
    getAllProjectsAcad() {
      this.project_selected = {}
      this.$swal({
        title: 'Cargando ...',
        showConfirmButton: false,
      });
      axios.get('/api/projects-properties')
        .then(res => {
          this.projects = res.data.data
          this.projectsFiltered = res.data.data
          this.totalProjects = res.data.total
          this.$swal.close()
        })
        .catch(err => {
          console.log(err)
        })
    },
    getAllProducts() {
      axios.get('/api/getAllProducts')
        .then(res => {
          console.log(res)
          this.products = res.data
        })
        .catch(err => {
          console.log(err.response.data)
        })
    },
    allowDrop(e) {
      e.preventDefault()
    },
    drag(e) {
      console.log('draggeando')
      e.dataTransfer.setData('text', e.target.id)
    },
    drop(e) {
      e.preventDefault()
      console.log()
      var data = e.dataTransfer.getData('text')

      var idArea = e.path[0].id

      var idStatus = 0

      if (idArea == 'clientArea') {
        idStatus = 0
      } else if (idArea == 'directionArea') {
        idStatus = 1
      } else if (idArea == 'qualityArea') {
        idStatus = 2
      }

      if (confirm('Estas seguro de cambiar de estado a este proyecto?')) {

        const fd = new FormData()

        fd.append('status', idStatus)
        fd.append('project_id', data)

        axios.post('/api/changeStatusProject', fd)
          .then(res => {
            console.log(res.data)
            this.getAllProjects()
          })
          .catch(err => {
            console.log(err.response.data)
          })
        //e.target.appendChild(document.getElementById(data))
      }
    }
  },
  mounted() {
    this.getAllProjectsAcad()

    /* this.getAllCustomers()
    this.getAllTeams()
    Echo.private('projects')
    .listen('NewProject',(e)=>{
      console.log(e)
      this.getAllProjectsAcad()
    }) */
  }
}
</script>