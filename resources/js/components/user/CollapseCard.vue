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
                        :quotations="quotations"
                        :userId="userId"
                        @openModal="openModal"
                        @openModalAcademic="openModalAcademic"
                        @showModalVouchers="showModalVouchers"
                        @updateModalVouchers="updateModalVouchers"
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
import TablePayment from "./TablePayments.vue";

export default {
    components: {
        ContractCard,
        CustomerCard,
        TimeLine,
        TablePayment,
    },
    props: {
        title: String,
        componentSelected: String,
        project: Object,
        quotations: Array,
        userId: Number,
    },
    data() {
        return {
            collapse: false,
            projectSelected: {},
        };
    },
    methods: {
        updateModalVouchers(voucher) {
            this.$emit("updateModalVouchers", voucher);
        },
        showModalVouchers() {
            this.$emit("showModalVouchers", this.project);
        },
        openModalAcademic() {
            this.$emit("openModalAcademic");
        },
        openModal() {
            this.$emit("openModal");
        },
        collapseCard() {
            this.$emit("changeBackground", this.collapse);
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
