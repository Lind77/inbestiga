<template>
    <button class="btn btn-primary mx-1">
        <div class="d-flex flex-column">
            <p class="mb-0 fw-bold" v-if="number != 0">{{ number }}</p>
            <i :class="icon" v-if="number == 0"></i>
            {{ title }}
        </div>
    </button>
</template>
<script>
export default {
    props: {
        title: String,
        icon: String,
        number: Number
    }
}
</script>
<style lang="">
    
</style>