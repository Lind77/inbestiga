<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Organigrama</h4>
        <div class="d-flex justify-content-center" v-for="rol in rolesByHierarchy">
            <template v-for="rol in rol.roles">
                <button class="btn btn-primary my-2 mx-2">{{ rol.name }}</button>
            </template>
        </div>
    </div>
</template>
<script>
export default {
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
        }
    },
    mounted() {
        this.getRoles();
    }
}
</script>
<style lang="">
    
</style>