<template>
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Productos <span class="badge bg-label-primary me-1" data-bs-toggle="modal" data-bs-target="#basicModal">+</span></h4>
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
                        <div class="col-md-6 col-xl-4" v-for="product in products">
                        <div class="card bg-primary text-white mb-3">
                          <div class="card-header">Registrado</div>
                          <div class="card-body">
                            <h5 class="card-title text-white">{{ product.title }}</h5>
                            <div class="card-text w-100">
                              <span v-for="activity in product.fixed_activities" class="badge bg-success mx-1 my-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#taskModal" @click="showModalActivity(activity)">{{ activity.title }}</span>
                              <span @click="addActivity(product.id)" class="badge badge-center bg-success my-1">+</span>
                              <input :id="`smallInput${product.id}`" v-on:keyup.enter="insertActivity(product.id)" v-model="activityTitle" class="form-control form-control-sm d-none" type="text" placeholder="Inserte Actividad"/>
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
            <ActivityModal v-if="selectedActivity" @getAllProducts="getAllProducts" :activity="selectedActivity"/>
</template>
  <script>
    import InsertModal from './InsertModal.vue'
    import ActivityModal from './ActivityModal.vue'
    
    export default{
      components: { InsertModal, ActivityModal },
      data(){
        return{
          products:[],
          selectedActivity: null,
          showInput: false,
          activityTitle:''        
        }
      },
      methods:{
        addActivity(id){
          document.getElementById('smallInput'+id).classList.remove('d-none')
          this.showInput = true
        },
        insertActivity(id){
          const fd = new FormData
          fd.append('product_id', id)
          fd.append('title', this.activityTitle)
          axios.post('/api/insertActivity', fd)
          .then(res => {
            this.getAllProducts()
            this.activityTitle = ''
            document.getElementById('smallInput'+id).classList.add('d-none')
          })
          .catch(err => {
            alert(err.response.data)
          })
        },
        showModalActivity(activity){
          this.selectedActivity = activity
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
      },
      mounted(){
        this.getAllProducts()
      }
    }
  </script>