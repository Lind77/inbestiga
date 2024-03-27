<template lang="">
    <p v-show="showName" class="mb-0" @click="editName(assignedActivity)">{{
                assignedActivity.user ? assignedActivity.user.name : 'Sin signar' }}</p>
    <select ref="selectName" v-show="!showName" class="form-control" @change="updateUserTask" @blur="updateUserTask">
        <option :value="`${user.id}`" v-for="user in team.users">{{ user.name }}
        </option>
    </select>
</template>
<script>
export default {
    data() {
        return {
            showName: true
        }
    },
    props: {
        assignedActivity: Object,
        team: Object
    },
    methods: {
        editName() {
            this.showName = false
            this.$refs.selectName.open = true
        },
        updateUserTask() {

            axios.get(`/api/assigned-activity-user/${this.assignedActivity.id}/${this.$refs.selectName.value}`)
                .then((result) => {
                    this.showName = true
                    this.assignedActivity.user.name = result.data.name
                }).catch((err) => {
                    console.log(err)
                });
        }
    }
}
</script>
<style lang="">

</style>