<template >
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4>Subir archivos</h4>
        <input type="file" @change="handleFileExcel" class="form-control">

        <template v-if="recentFiles != []">
            <h4 class="mt-3">Archivos recientes</h4>

            <div class="card bg-warning text-white w-25" v-for="file in  recentFiles ">
                <div class="card-body">
                    <p>Fecha de subida: {{ formatDate(file.created_at) }}</p>
                    <a class="btn btn-danger" @click="downloadFile(file.url)">Descargar</a>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
import moment from 'moment'
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    data() {
        return {
            recentFiles: []
        }
    },
    methods: {
        downloadFile(url) {
            window.open(url)
        },
        formatDate(date) {
            return moment(date).format('DD/MM/yyyy H:mm a')
        },
        handleFileExcel(e) {
            this.$swal('Subiendo Archivo...')
            const fd = new FormData()

            fd.append('file', e.target.files[0])
            fd.append('user_id', this.store.authUser.id)

            axios.post('/api/files', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((result) => {
                    this.$swal('Archivo correctamente')
                    this.getRecentFiles()
                }).catch((err) => {
                    console.error(err);
                });
        },
        getRecentFiles() {
            axios.get('/api/files/' + this.store.authUser.id)
                .then((result) => {
                    this.recentFiles = result.data
                }).catch((err) => {
                    console.error(err);
                });
        }
    },
    mounted() {
        this.getRecentFiles()
    }
}
</script>
<style lang="">
    
</style>