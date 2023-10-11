<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h4 class="card-header d-flex align-items-center justify-content-between">Organigrama
                <button class="btn btn-secondary add-new btn-primary w-25" type="button" @click="openAreaModal">
                    <span>
                        <i class="bx bx-plus me-0 me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Nueva área</span>
                    </span>
                </button>
            </h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <template v-for="(level, index) in levels">
                            <h6 class="mb-0">Nivel {{ index + 1 }}</h6>
                            <div :id="`area${index}`"
                                class="row bg-transparent border border-primary my-1 py-5 rounded justify-content-center"
                                @drop="drop" @dragenter.prevent @dragover.prevent>
                                <!-- <h3 class="w-100"> {{ index + 1 }}</h3> -->
                            </div>
                        </template>
                    </div>
                    <div class="col-4">
                        <template v-for="area in areas">
                            <button class="btn btn-info my-2 mx-2 w-50" draggable="true" @dragstart="drag"
                                :id="`${area.id}`">{{
                                    area.name
                                }}</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>




        <!--  <div class="d-flex justify-content-center" v-for="rol in rolesByHierarchy">

        </div> -->
    </div>
    <areaModal @getAreas="getAreas" />
</template>
<script>
import axios from 'axios'
import areaModal from './AreaModal.vue'

export default {
    components: { areaModal },
    data() {
        return {
            roles: [],
            rolesByHierarchy: [],
            areas: [],
            levels: [0, 1, 2]
        }
    },
    methods: {
        drag(e) {
            this.visible = true
            e.dataTransfer.setData('text', e.target.id)
        },
        drop(e) {
            let areaId = e.dataTransfer.getData('text')
            let hierarchy = e.target.id.slice(4)

            const fd = new FormData()
            fd.append('areaId', areaId)
            fd.append('hierarchy', hierarchy)

            axios.post('/api/areas-hierarchy', fd)
                .then((result) => {

                }).catch((err) => {
                    console.error(err)
                });

            e.target.appendChild(document.getElementById(areaId))
        },
        getAreas() {
            axios.get('/api/areas')
                .then((result) => {
                    this.areas = result.data
                }).catch((err) => {
                    console.error(err)
                });
        },
        getRoles() {
            axios.get('/api/roles-hierarchy')
                .then((result) => {
                    this.roles = result.data
                    this.roles.forEach((role) => {
                        var roleByHierarchy =
                        {
                            order: role.hierarchy,
                            roles: []
                        }
                        this.rolesByHierarchy.push(roleByHierarchy)
                    })

                    this.roles.forEach((roleContent) => {
                        var selectedHierarchy = this.rolesByHierarchy.find(role => role.order == roleContent.hierarchy)

                        selectedHierarchy.roles.push({ ...roleContent })
                    })



                }).catch((err) => {
                    console.error(err)
                });
        },
        openAreaModal() {
            $('#areaModal').modal('show');
        }
    },
    mounted() {
        this.getAreas();
    }
}
</script>
<style lang="">
    
</style>