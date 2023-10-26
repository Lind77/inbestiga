<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3">Proyectos
      <!-- <span v-if="store.rol == 'AdminAcad'" class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#projectModal">+</span> -->
    </h4>
    <div class="row">
      <!-- <div class="col-md-4" id="clientArea" @drop="drop" @dragover="allowDrop">
        <p class="fw-bold h5">Experiencia</p>
        <div class="container-cards" v-for="project in projects">
          <div v-if="project.status == 0">
            <CardProject :project="project" @click="showProject(project)" @getAllProjects="getAllProjectsAcad" />
          </div>
        </div>

      </div> -->

      <div class="col-md-4" id="directionArea" v-for="project in projects">
        <div class="container-cards">
          <div class="card">
            <div class="card-body">
              <h5 v-if="project.propertiable" v-for="customer in project.propertiable.quotation.customers">
                {{ customer.name }}
              </h5>
              <p v-if="project.propertiable.projects[0].team">Equipo: {{ project.propertiable.projects[0].team.name }}</p>
              <router-link :to="{ name: 'profile-acad', params: { idProject: project.propertiable.id } }">
                <i class='bx bx-file text-success'></i>
              </router-link>
              <i class='bx bx-check-double text-info cursor-pointer' @click="showModalAssignation(project)"></i>
            </div>
          </div>

          <!--  <div v-if="project.status == 1">
            <CardProject :project="project" @getAllProjects="getAllProjectsAcad" />
          </div> -->
        </div>
      </div>
      <!-- 
      <div class="col-md-4" id="qualityArea" @drop="drop" @dragover="allowDrop">
        <p class="fw-bold h5">Calidad académica</p>
        <div class="container-cards" v-for="project in projects">
          <div v-if="project.status == 2">
            <CardProject :project="project" @getAllProjects="getAllProjectsAcad" @showQualityModal="showQualityModal" />
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <!-- <OffCanvas :project_selected="project_selected" @getAllProjects="getAllProjectsAcad" /> -->
  <QualityModal :qualityActivities="qualityActivities" />
  <TeamModal :contract="contractId" @getAllProjectsAcad="getAllProjectsAcad" />
</template>

<script>
import { userStore } from '../../../stores/UserStore'
import CardProject from './CardProject.vue'
import OffCanvas from './OffCanvas.vue'
import QualityModal from './QualityModal.vue'
import TeamModal from './TeamModal.vue'

export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { CardProject, OffCanvas, QualityModal, TeamModal },
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
      contractId: 0
    }
  },
  methods: {
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