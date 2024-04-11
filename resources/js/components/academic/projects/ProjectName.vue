<template>
    <div>
        <p class="mb-0" v-show="!showField" @click="showInput" :title="projectName">{{ projectName }}</p>
        <input v-show="showField" type="text" v-model="projectName" ref="projectName" class="form-control w-75"
            @blur="hideInput">
    </div>
</template>
<script>
export default {
    data() {
        return {
            showField: false,
            projectName: this.title
        }
    },
    props: {
        id: Number,
        title: String
    },
    methods: {
        hideInput() {
            axios.get(`/api/update-project-title/${this.id}/${this.projectName}`)
                .then((result) => {
                    this.showField = false
                }).catch((err) => {
                    console.log(err)
                });
        },
        showInput() {
            this.showField = true
            this.$nextTick(() => {
                this.$refs.projectName.select()
            })
        }
    }
}
</script>
