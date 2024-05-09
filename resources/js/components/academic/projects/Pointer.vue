<template lang="">
    <p v-show="!showPointer" @click="editPoints(assignedActivity)">
        {{ assignedActivity.points ? assignedActivity.points : "Sin asignar" }}
    </p>
    <input
        v-show="showPointer"
        @blur="closePointer(assignedActivity)"
        class="form-control"
        ref="pointerField"
        type="number"
        min="0"
        max="100"
        v-model="points"
    />
</template>
<script>
export default {
    props: {
        assignedActivity: Object,
    },
    data() {
        return {
            points: 0 || this.assignedActivity.points,
            showPointer: false,
        };
    },
    methods: {
        editPoints() {
            this.showPointer = true;
        },
        closePointer(assignedActivity) {
            assignedActivity.points = this.points;
            axios
                .get(
                    "/api/assigned-activity-points/" +
                        assignedActivity.id +
                        "/" +
                        this.points
                )
                .then((result) => {
                    this.showPointer = false;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
