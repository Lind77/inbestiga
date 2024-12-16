<template>
    <div class="mb-2">
        <label for="" class="fw-bold">Reasignar</label>
        <select
            name=""
            id=""
            class="form-control"
            @change="updateUserProject(project)"
            v-model="newAcadUserSelected"
        >
            <option :value="acadUser.id" v-for="acadUser in acadUsers">
                {{ acadUser.name }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
        acadUsers: Array,
    },
    methods: {
        updateUserProject(project) {
            axios
                .get(
                    "/api/update-user-project/" +
                        this.newAcadUserSelected +
                        "/" +
                        project.id
                )
                .then((result) => {
                    this.$swal("Usuario actualizado correctamente");
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
