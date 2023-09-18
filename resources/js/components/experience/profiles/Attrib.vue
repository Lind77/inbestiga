<template>
    <div class="d-flex">
        <div>
            <p v-if="!isEditing" @dblclick="handleDoubleClick">Click me to edit</p>
            <input v-else class="form-control" type="text" ref="myinput" v-model="inputValue" @blur="isEditing = false" />
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            inputValue: '',
            isEditing: false
        }
    },
    methods: {
        handleDoubleClick() {
            this.isEditing = true;
            console.log(this.$refs)
            this.$refs.myinput.focus();
            this.inputValue = ''; // Set the initial input value
        }
    },
}
</script>
<style lang="">
    
</style>