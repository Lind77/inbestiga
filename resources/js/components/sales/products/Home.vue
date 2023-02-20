<template>
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold">Productos <span class="badge bg-label-primary me-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#basicModal">+</span></h4>
              <div class="row">
              <div class="col-xl">
                <div class="card mb-4">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tabla de Productos</h5>
                  </div>
                  <div class="card-body">
                    <form>
                      <h5 class="mb-4">Productos</h5>
                      <input type="text" class="form-control mb-3" />
                      <div class="row">
                        <div class="col-md-12 col-xl-12" v-for="product in products">
                        <div class="card bg-primary text-white mb-3">
                          <div class="card-header" v-if="product.type == 2">Registrado</div>
                          <div class="card-header" v-else-if="product.type == 3">Observación</div>
                          <div class="card-body">
                            <h5 class="card-title text-white h4">{{ product.title }}
                              <div class="d-flex">
                                <span @click="addActivity(product.id)" class="badge badge-center bg-success cursor-pointer">+</span>  
                                <span class="badge badge-center bg-warning cursor-pointer" @click="insertTime(product.id)"><i class='bx bx-time'></i></span> 
                              </div> 
                              <input :id="`smallInput${product.id}`" v-on:keyup.enter="insertActivity(product.id)" v-model="activityTitle" class="form-control form-control-sm d-none mt-3 w-50" type="text" placeholder="Inserte Actividad"/>
                            </h5>
                            <div class="row">
                              <div class="col-md-4 col-xl-4" v-for="activity in product.fixed_activities">
                                <div class="card mt-3 bg-success">
                                  <div class="card-body text-capitalize h5 text-white">
                                    <p class="h5 text-white mb-0">{{ activity.title }} 
                                      <span @click="addTask(activity.id)" class="badge badge-center bg-warning my-1 cursor-pointer">+</span>
                                    </p>
                                    <input :id="`taskInput${activity.id}`" v-on:keyup.enter="insertTask(activity.id)" v-model="taskTitle" class="form-control form-control-sm d-none mt-1 mb-1 w-75" type="text" placeholder="Inserte Tarea"/>
                                    <p v-for="task in activity.fixed_tasks" class="bg-warning rounded p-1 py-1 cursor-pointer h6 text-white">
                                      {{ task.title }}
                                    </p>
                                  </div>
                                </div>
                                </div>
                              </div>  
                          </div>
                        </div>
                      </div>
                      </div>
                      <!-- <div class="table-responsive text-nowrap">
                        <table class="table">
                          <thead class="table-primary">
                            <tr class="text-nowrap">
                              <th>Productos</th>
                              <th>Actividades</th>
                              <th>Tareas</th>
                              <th>Plazo</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <tr v-for="product in products">
                              <td><strong>{{product.title}}</strong></td>
                              <td>
                                <tr v-for="activity in product.activities">
                                <button class="btn btn-primary mt-1" >
                                  {{ activity.title }}
                                </button>
                                </tr>
                              </td>
                              <td></td>
                              <td>{{product.term}}</td>
                              <td>S./ {{product.amount}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div> -->
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            
            
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
            <InsertModal @getAllProducts="getAllProducts"/>
            <TimeModal :idActivity="idActivity"/>
            <!-- <ActivityModal @getAllProducts="getAllProducts" :activity="selectedActivity"/> -->
</template>
  <script>
    import InsertModal from './InsertModal.vue'
    import ActivityModal from './ActivityModal.vue'
    import TimeModal from './TimeModal.vue'
    
    export default{
      components: { InsertModal, ActivityModal, TimeModal },
      data(){
        return{
          products:[],
          selectedActivity: {},
          showInput: false,
          showInputTask: false,
          activityTitle:'',
          taskTitle:'',
          idActivity: 0        
        }
      },
      methods:{
        insertTime(id){
          this.idActivity = id
          $('#timeModal').modal('show')
        },
        addActivity(id){
          document.getElementById('smallInput'+id).classList.toggle('d-none')
          this.showInput = true
        },
        insertActivity(id){
          const fd = new FormData
          fd.append('product_id', id)
          fd.append('title', this.activityTitle)
          fd.append('type', 1)
          axios.post('../api/insertFixedActivity', fd)
          .then(res => {
            this.getAllProducts()
            this.activityTitle = ''
            document.getElementById('smallInput'+id).classList.add('d-none')
          })
          .catch(err => {
            alert(err.response.data)
          })
        },
        addTask(id){
          document.getElementById('taskInput'+id).classList.toggle('d-none')
          this.showInputTask = true
        },
        insertTask(id){
          const fd = new FormData
          fd.append('fixed_activity_id', id)
          fd.append('title', this.taskTitle)
          axios.post('../api/insertFixedTask', fd)
          .then(res => {
            this.getAllProducts()
            this.taskTitle = ''
            document.getElementById('taskInput'+id).classList.add('d-none')
          })
          .catch(err => {
            alert(err.response.data)
          })
        },
        getAllProducts(){
            this.$swal({
                  title: 'Cargando ...',
                  showConfirmButton: false,
            });
            axios.get('../api/getAllProducts')
            .then(res =>{
              console.log(res)
              this.products = res.data
              this.$swal.close()
            })
            .catch(err =>{
              console.log(err.response.data)
            })
        },
      },
      mounted(){
        this.getAllProducts()
      }
    }
  </script>