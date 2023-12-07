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

      <div class="row">
        <CardProject v-for="project in projects" :project="project"></CardProject>
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

export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { CardProject, OffCanvas, QualityModal, TeamModal, ProjectTab, EspecialButton },
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
      projectsFiltered: []
    }
  },
  methods: {
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
          this.projects = res.data
          this.filterProjects(0)
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