<template lang="">
    <p v-show="showName" class="mb-0" @click="editName(assignedActivity)">{{
                assignedActivity.user ? assignedActivity.user.name : 'Sin asignar' }}</p>
    <select ref="selectName" v-model="selected" v-show="!showName" class="form-control" @change="updateUserTask" @blur="updateUserTask" v-if="team">
        <option value="0" disabled="disabled" v-if="selected == null" >Seleccionar dueño</option>
        <option :value="`${user.id}`" v-for="user in team.users">{{ user.name }}
        </option>
    </select>
</template>
<script>
export default {
    data() {
        return {
            showName: true,
            selected: this.assignedActivity ? this.assignedActivity.user_id : 0
        }
    },
    props: {
        assignedActivity: Object,
        team: Object
    },
    methods: {
        editName() {
            if (this.team) {
                this.showName = false
            } else {
                this.$swal('Se debe asignar el equipo primero')
            }

        },
        updateUserTask() {
            if (this.selected) {
                axios.get(`/api/assigned-activity-user/${this.assignedActivity.id}/${this.selected}`)
                    .then((result) => {
                        this.showName = true
                        if (this.assignedActivity.user) {
                            this.assignedActivity.user.name = result.data.name
                        } else {
                            var name = result.data.name
                            this.assignedActivity.user = { name: name }
                        }

                    }).catch((err) => {
                        console.log(err)
                    });
            }
        }
    }
}
</script>
<style lang="">

</style>