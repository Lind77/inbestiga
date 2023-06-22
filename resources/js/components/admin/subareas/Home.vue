<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">SubAreas</h4>
        <div class="repeater-wrapper pt-0 pt-md-4 mb-2" data-repeater-item="">
            <div class="d-flex border rounded position-relative pe-0 bg-light">
                <div class="row w-100 m-0 p-3">
                    <div class="col-md-4 col-12 mb-md-0 mb-3 ps-md-0">
                        <p class="mb-2 repeater-title">Area</p>
                        <select v-model="subarea.areaId" class="form-select">
                            <option :value="area.id" v-for="area in areas">{{ area.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mb-md-0 mb-3">
                        <p class="mb-2 repeater-title">Sub-Area</p><input v-model="subarea.name" type="text"
                            class="form-control">
                    </div>
                    <div class="col-md-4 col-12 mb-md-0 mb-3"><button @click="insertSubarea"
                            class="btn btn-primary mt-4">Agregar</button></div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2"><i
                        class="bx bx-x fs-4 text-muted cursor-pointer" data-repeater-delete=""></i></div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SubArea</th>
                            <th>Area</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr v-for="subarea in subareas">
                            <td>{{ subarea.name }}</td>
                            <td>{{ subarea.area.name }}</td>
                            <td><span @click="deleteSubarea(subarea.id)"
                                    class="badge bg-label-danger me-1 cursor-pointer"><i class='bx bx-trash'></i></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            areas: [],
            subareas: [],
            subarea: {
                name: '',
                areaId: 0
            }
        }
    },
    methods: {
        getAreas() {
            axios.get('/api/areas')
                .then((result) => {
                    this.areas = result.data
                }).catch((err) => {
                    console.error(err);
                });
        },
        getSubAreas() {
            axios.get('/api/subareas')
                .then((result) => {
                    this.subareas = result.data
                }).catch((err) => {
                    console.error(err);
                });
        },
        insertSubarea() {
            const fd = new FormData()

            fd.append('area_id', this.subarea.areaId)
            fd.append('name', this.subarea.name)

            axios.post('/api/subareas', fd)
                .then((result) => {
                    this.getSubAreas()
                    this.subarea = {
                        name: '',
                        areaId: 0
                    }
                }).catch((err) => {
                    console.error(err);
                });
        },
        deleteSubarea(subareaId) {
            this.$swal({
                title: '¿Deseas eliminar esta subarea?',
                icon: 'question',
                confirmButtonText: 'Si',
                showCancelButton: true,
                cancelButtonText: 'No'
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/subareas/' + subareaId)
                            .then((result) => {
                                this.getSubAreas()
                            }).catch((err) => {
                                console.error(err);
                            });
                    } else {
                        this.$swal.close()
                    }
                })

        }
    },
    mounted() {
        this.getAreas()
        this.getSubAreas()
    }
}
</script>
<style lang="">
    
</style>