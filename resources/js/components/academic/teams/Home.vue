<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Equipos <span @click="changeVisibility"
                class="badge bg-label-primary me-1 cursor-pointer">+</span></h4>
        <input v-if="visible" class="form-control w-25 mb-3" type="text" placeholder="Nombre del equipo" v-model="name"
            @keyup.enter="insertTeam" />
        <div class="row">
            <div class="col-lg-4">
                <input type="text" placeholder="Buscar inbestigador..." class="form-control">
                <button class="btn btn-info btn-sm my-1 w-100" draggable="true" @dragover.prevent @drop.stop.prevent
                    @dragstart="drag" :id="`${user.id}`" v-for="user in  acadUsers ">{{ user.name
                    }}</button>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6" v-for="team in teams">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-white">Equipo {{ team.name }}</h5>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    <div v-for="memoir in team.memoirs">
                                        <li class="avatar avatar-sm pull-up" :title="memoir.user.name">
                                            <span class="avatar-initial rounded-circle bg-primary">{{ memoir.user.name[0]
                                            }}</span>
                                        </li>
                                    </div>
                                    <div :id="team.id" class="w-100 py-1" @drop="drop" @dragenter.prevent @dragover.prevent>

                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            visible: false,
            teams: [],
            name: '',
            acadUsers: []
        }
    },
    methods: {
        drag(e) {
            e.dataTransfer.setData('text', e.target.id)
        },
        drop(e) {
            let userId = e.dataTransfer.getData('text')

            const fd = new FormData()
            fd.append('userId', userId)
            fd.append('teamId', e.target.id)

            axios.post('/api/user-team', fd)
                .then((result) => {
                    e.target.appendChild(document.getElementById(userId))
                }).catch((err) => {
                    console.error(err)
                });
            console.log(userId, e.target.id);

        },
        changeVisibility() {
            this.visible = !this.visible;
        },
        getAllTeams() {
            axios.get('/api/getAllTeams')
                .then(res => {
                    this.teams = res.data
                })
                .catch(err => {
                    console.log(err)
                })
        },
        getAcademicUsers() {
            axios.get('/api/academic-users')
                .then((result) => {
                    this.acadUsers = result.data
                }).catch((err) => {
                    console.log(err)
                });
        },
        insertTeam() {
            const fd = new FormData()
            fd.append('name', this.name)

            axios.post('/api/teams', fd)
                .then((result) => {
                    this.visible = false
                    this.name = ''
                    this.getAllTeams()
                }).catch((err) => {
                    console.error(err)
                });
        }
    },
    mounted() {
        this.getAllTeams()
        this.getAcademicUsers()
    }
}
</script>