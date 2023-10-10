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
        <div class="d-flex justify-content-center" v-for="rol in rolesByHierarchy">
            <template v-for="rol in rol.roles">
                <button class="btn btn-primary my-2 mx-2">{{ rol.name }}</button>
            </template>
        </div>
    </div>
    <areaModal />
</template>
<script>
import areaModal from './AreaModal.vue'

export default {
    components: { areaModal },
    data() {
        return {
            roles: [],
            rolesByHierarchy: [],
        }
    },
    methods: {
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
        this.getRoles();
    }
}
</script>
<style lang="">
    
</style>