<template>
    <p v-if="endDate">{{ formatDate(endDate) }}</p>
    <input
        v-if="!endDate"
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
        endDate: String,
        activity: Object,
    },
    data() {
        return {
            date: {},
            showDate: true,
        };
    },
    methods: {
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
        },
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
                        this.$emit("updateLimitDate", this.date, this.activity);
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
