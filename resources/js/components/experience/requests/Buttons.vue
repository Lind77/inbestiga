<template>
    <div class="buttons" v-if="permission.status == 0">
        <button type="button" class="btn btn-icon btn-success ms-1" @click="updateStatus(permission, 1)">
            <span class="tf-icons bx bx-check"></span>
        </button>
        <button type="button" class="btn btn-icon btn-danger ms-1" @click="updateStatus(permission, 2)">
            <span class="tf-icons bx bx-x"></span>
        </button>
    </div>
    <div class="buttons" v-if="permission.status == 1">
        <button type="button" class="btn btn-icon btn-warning ms-1" @click="updateStatus(permission, 3)">
            <span class="tf-icons bx bx-check"></span>
        </button>
        <button type="button" class="btn btn-icon btn-info ms-1" @click="updateStatus(permission, 4)">
            <span class="tf-icons bx bx-x"></span>
        </button>
        <button type="button" class="btn btn-icon btn-danger ms-1" @click="updateStatus(permission, 5)">
            <span class="tf-icons bx bx-block"></span>
        </button>
    </div>
</template>
<script>
export default {
    props: {
        permission: Object
    },
    methods: {
        updateStatus(permission, status) {
            axios.get('/api/accept-permit/' + permission.id + '/' + status)
                .then((result) => {
                    this.$emit('updateStatus', permission.id, result.data)
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>
<style lang="">
    
</style>