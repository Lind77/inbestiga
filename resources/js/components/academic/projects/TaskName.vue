<template>
    <div :class="`bg-info ps-2 py-2 border-start border-primary text-white rounded`" @click="">
        <p class="mb-0" v-show="!showField" @click="showInput" :title="taskName">{{ cutString(taskName) }}</p>
        <input v-show="showField" type="text" v-model="taskName" ref="taskName" class="form-control w-75"
            @blur="hideInput">
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            showField: false,
            taskName: this.name
        }
    },
    props: {
        name: String,
        id: Number
    },
    methods: {
        hideInput() {
            axios.get(`/api/assigned-activity-name/${this.id}/${this.taskName}`)
                .then((result) => {
                    this.showField = false
                }).catch((err) => {
                    console.log(err)
                });
        },
        showInput() {
            this.showField = true
            this.$nextTick(() => {
                this.$refs.taskName.select()
            })
        },
        cutString(string) {
            if (string.length > 30) {
                return string.substring(0, 25) + '...'
            } else {
                return string
            }

        }
    }
}
</script>
<style lang="">

</style>