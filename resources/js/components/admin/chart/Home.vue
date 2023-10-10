<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="card-header d-flex align-items-center justify-content-between">Organigrama
            <button class="btn btn-secondary add-new btn-primary w-25" type="button" @click="openAreaModal">
                <span>
                    <i class="bx bx-plus me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">Nueva área</span>
                </span>
            </button>
        </h5>
        <template v-for="area in areas">
            <button class="btn btn-primary my-2 mx-2 w-25" draggable="true" @dragstart="drag" :id="`${area.id}`">{{
                area.name
            }}</button>
        </template>
        <div :id="`${index}`" class="row bg-transparent border border-primary my-2 py-3 rounded justify-content-center"
            v-for="(level, index) in levels" @drop="drop" @dragenter.prevent @dragover.prevent>
            <!-- <h3 class="w-100"> {{ index + 1 }}</h3> -->
        </div>

        <!--  <div class="d-flex justify-content-center" v-for="rol in rolesByHierarchy">

        </div> -->
    </div>
    <areaModal @getAreas="getAreas" />
</template>
<script>
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
            let area = e.dataTransfer.getData('text')
            e.target.appendChild(document.getElementById(area))
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