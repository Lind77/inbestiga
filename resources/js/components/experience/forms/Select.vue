<template lang="">
    <select v-model="newQuestion.answer" class="form-select">
        <option
            :value="`${index + 1}`"
            v-for="(option, index) in newQuestion.options"
        >
            {{ option }}
        </option>
    </select>
    <input type="text" class="form-control ms-2" v-model="newOption" />

    <button
        class="btn btn-icon btn-success ms-2"
        @click="addOptions(newQuestion)"
    >
        <i class="bx bx-plus"></i>
    </button>
</template>
<script>
export default {
    data() {
        return {
            newOption: "",
        };
    },
    props: {
        newQuestion: Object,
    },
    methods: {
        addOptions() {
            this.$emit("addOptions", this.newQuestion, this.newOption);
            this.newOption = "";
        },
    },
};
</script>
<style lang=""></style>
