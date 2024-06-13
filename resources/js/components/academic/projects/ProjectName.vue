<template>
    <div>
        <p
            class="mb-0 fw-bold"
            v-show="!showField"
            @click="showInput"
            :title="projectName"
        >
            {{ projectName.substring(0, 23) + "..." }}
        </p>
        <small v-for="customer in customers">{{ customer.name }} <br /></small>
        <input
            v-show="showField"
            type="text"
            v-model="projectName"
            ref="projectName"
            class="form-control w-75"
            @blur="hideInput"
        />
    </div>
</template>
<script>
export default {
    data() {
        return {
            showField: false,
            projectName: "",
        };
    },
    props: {
        id: Number,
        title: String,
        customers: Array,
    },
    methods: {
        hideInput() {
            axios
                .get(`/api/update-project-title/${this.id}/${this.projectName}`)
                .then((result) => {
                    this.showField = false;
                    console.log(result.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        showInput() {
            //this.projectName = this.title;
            this.showField = true;
            this.$nextTick(() => {
                this.$refs.projectName.select();
            });
        },
    },
    watch: {
        title() {
            this.projectName = this.title;
        },
    },
    mounted() {
        this.projectName = this.title;
    },
};
</script>
