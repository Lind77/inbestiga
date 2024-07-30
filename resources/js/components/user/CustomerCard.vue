<template>
    <div class="col-lg-6 mb-6 mb-xl-0">
        <div class="mt-4">
            <div class="row" v-if="project && project.projectable">
                <div
                    v-for="customer in project.projectable.quotation.customers"
                    class="text-white"
                >
                    <span
                        class="avatar-initial rounded-circle bg-primary py-2 px-3 me-2"
                        >{{ customer.name[0] }}</span
                    >{{ customer.name }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        project: Object,
    },
};
</script>
<style lang=""></style>
