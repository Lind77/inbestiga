<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header d-flex align-items-center justify-content-between">Areas
                <button @click="addArea" class="btn btn-secondary add-new btn-primary w-25" type="button"><span><i
                            class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Nuevo
                            Area</span></span></button>
            </h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr v-for="area in areas">
                            <td>{{ area.name }}</td>
                            <td><span @click="deleteArea(area.id)" class="badge bg-label-danger me-1 cursor-pointer"><i
                                        class='bx bx-trash'></i></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <InsertArea @getAllAreas="getAllAreas" />
    </div>
</template>
<script>
import InsertArea from './InsertArea.vue'

export default {
    components: { InsertArea },
    data() {
        return {
            areas: [],
        }
    },
    methods: {
        getAllAreas() {
            axios.get('/api/areas')
                .then(res => {
                    this.areas = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
        addArea() {
            $('#areaModal').modal('show')
        },
        deleteArea(id) {
            this.$swal({
                title: '¿Deseas eliminar esta área?',
                icon: 'question',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'No'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/api/areas/${id}`)
                            .then(res => {
                                this.getAllAreas()
                            })
                            .catch(err => {
                                console.log(err)
                            })
                    } else {
                        this.$swal.close()
                    }
                })

        }
    },
    mounted() {
        this.getAllAreas()
    }
}
</script>