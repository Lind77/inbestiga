<template>
    <input
        type="date"
        v-model="date"
        class="form-control"
        @change="setLimitDate"
    />
</template>
<script>
import moment from "moment";
export default {
    props: {
        dateSprint: Date,
        activityId: Number,
    },
    data() {
        return {
            date: {},
        };
    },
    methods: {
        setLimitDate() {
            if (this.dateSprint != "0000-00-00") {
                var days = moment(this.dateSprint, "YYYY-MM-DD").diff(
                    moment(this.date),
                    "days"
                );
                const fd = new FormData();

                fd.append("assignedActivtyId", this.activityId);
                fd.append("end_date", this.date);
                fd.append("_method", "put");

                axios
                    .post("/api/assigned-activity-limit-date", fd)
                    .then((result) => {
                        this.$swal("Fecha límite actualizada correctamente.");
                    })
                    .catch((err) => {
                        console.log(err);
                    });

                /* if (days < 0) {
                    this.$swal("No te pases el límite de Sprint.");
                    this.date = null;
                } else {
                } */
            } else {
                this.$swal("Asigna una fecha límite al Sprint.");
                this.date = null;
            }
        },
    },
};
</script>
<style lang=""></style>
