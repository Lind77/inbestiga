<template>
    <div class="modal fade" id="filesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Archivos del proyecto </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-progress-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-info my-1 w-100" @click="downloadFile(file.url)"
                                v-for="file in files">{{
                                    file.url }}</button>
                        </div>
                        <div class="col-8">
                            <label for="" class="form-label">Subir Archivo</label>
                            <input @change="handleFile" type="file" name="" id="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
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
    props: {
        files: Array
    },
    data() {
        return {
            recentFiles: []
        }
    },
    methods: {
        getNameFile(url) {
            const fragments = url.split('/')
            return fragments[5]
        },
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
            window.open('https://inbestiga.com/inbestiga/public/files/' + url)
        },
        formatDate(date) {
            return moment(date).format('DD/MM/yyyy H:mm a')
        },
        handleFile(e) {
            this.$swal('Subiendo Archivo...')
            const fd = new FormData()

            fd.append('file', e.target.files[0])
            fd.append('project_id', this.$route.params.idProject)

            axios.post('/api/files-project', fd, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((result) => {
                    this.$swal().close()
                    this.$emit('updateFilesModal')
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
