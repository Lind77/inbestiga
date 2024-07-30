<template>
    <div class="card card-action mb-6 mt-2 transparent">
        <div class="card-header">
            <h5 class="card-action-title mb-0 text-white text-center fw-bold">
                {{ title }}
            </h5>

            <div class="card-action-element">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a
                            @click="collapseCard"
                            href="javascript:void(0);"
                            class="card-collapsible text-white"
                            ><i
                                :class="`tf-icons bx bx-chevron-${
                                    collapse ? 'down' : 'up'
                                }`"
                            ></i
                        ></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="collapse" :class="{ show: !collapse }" style="">
            <div class="card-body pt-0">
                <div class="row">
                    <component
                        :is="componentSelected"
                        :project="project"
                        @openModal="openModal"
                    ></component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ContractCard from "./ContractCard.vue";
import CustomerCard from "./CustomerCard.vue";
import TimeLine from "./TimeLine.vue";

export default {
    components: { ContractCard, CustomerCard, TimeLine },
    props: {
        title: String,
        componentSelected: String,
        project: Object,
    },
    data() {
        return {
            collapse: true,
        };
    },
    methods: {
        openModal() {
            this.$emit("openModal");
        },
        collapseCard() {
            this.collapse = !this.collapse;
        },
    },
    computed: {
        getComponentMain() {
            return this.componentSelected;
        },
    },
};
</script>
<style scoped>
.card {
    border: solid 2px #fb15d7;
}
.transparent {
    background: none;
}
</style>
