<template>
    <!--  <button class="btn btn-primary" @click="importAttendance">Importar</button> -->
    <!-- <div v-for="marks in myJson">
        <p v-for="mark in marks">{{ mark.first_name }} {{ mark.last_name }} {{ mark.att_date }} {{ mark.first_punch }} {{
            mark.last_punch }}</p>
    </div> -->
    <button class="btn btn-primary w-25" @click="ping">Probar URL</button>
</template>
<script>
import axios from 'axios';

export default {
    methods: {
        ping() {
            axios.get('http://192.168.1.254:8081/att/api/firstLastReport/?departments=1%2C2%2C3%2C4%2C5&employees=-1&end_date=2023-07-30&format=json&page=1&page_size=20&start_date=2023-07-01', {
                headers: {
                    "Access-Control-Allow-Origin": "*",
                    "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS"
                }
            })
                .then((result) => {
                    this.$swal('GG')
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>