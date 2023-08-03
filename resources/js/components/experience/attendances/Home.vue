<template>
    <!--  <button class="btn btn-primary" @click="importAttendance">Importar</button> -->
    <!-- <div v-for="marks in myJson">
        <p v-for="mark in marks">{{ mark.first_name }} {{ mark.last_name }} {{ mark.att_date }} {{ mark.first_punch }} {{
            mark.last_punch }}</p>
    </div> -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <input type="file" @change="handleFileUpload" class="form-control">
        <p class="h3" v-for="user in users">
            {{ user.name }}
        <p class="h6" v-for="attendance in user.attendances">{{ attendance.date }} {{ attendance.first_punch }} - {{
            attendance.last_punch }}</p>
        <p class="h6" v-for="schedule in user.schedules">
            <template v-if="schedule.day == 1">
                {{ schedule }}
            </template>
        </p>
        </p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            file: '',
            users: []
        }
    },
    methods: {
        getAttendances() {
            axios.get('/api/schedules')
                .then((result) => {
                    this.users = result.data;
                }).catch((err) => {
                    console.error(err)
                });
        },
        handleFileUpload(e) {
            const fd = new FormData()

            fd.append('file', e.target.files[0])

            axios.post('/api/json-file', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((result) => {
                    this.$swal('Asistencias almacenadas correctamente')
                }).catch((err) => {
                    console.error(err);
                });

        }
    },
    mounted() {
        this.getAttendances();
    }
}
</script>