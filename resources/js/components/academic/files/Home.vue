<template >
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4>Subir archivos</h4>
        <input type="file" @change="handleFileExcel" class="form-control">
        <div class="row">
            <template v-if="recentFiles != []">
                <h4 class="mt-3">Archivos recientes</h4>
                <div class="col-md-4" v-for="file in  recentFiles">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <p>Fecha de subida: {{ formatDate(file.created_at) }}</p>
                            <a class="btn btn-primary" @click="downloadFile(file.url)">Descargar</a>
                            <div class="btn btn-icon btn-danger ms-1" @click="deleteFile(file.id)">
                                <i class="bx bx-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
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
        deleteFile(fileId) {
            this.$swal({
                title: '¿Tienes la seguridad de eliminar este archivo?',
                icon: 'question',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'No'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/files/' + fileId)
                            .then((result) => {
                                this.getRecentFiles()
                                this.$swal('Archivo eliminado correctamente')
                            }).catch((err) => {
                                console.error(err);
                            });
                    } else {
                        this.$swal.close()
                    }
                })

        },
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
                    this.$swal('Archivo almacenado correctamente')
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