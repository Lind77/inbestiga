<template>
    <div class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Asignar equipo</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col mb-3">
                    <label for="nameSmall" class="form-label">Proyecto</label>
                    <p>{{ this.project.title }}</p>
                    <label for="nameSmall" class="form-label">Equipo</label>
                    <select v-model="team_selected" class="form-select">
                        <option :value="team.id" v-for="team in teams">
                            {{ team.name }}
                        </option>
                    </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Salir
                </button>
                <button type="button" class="btn btn-primary" @click="assignTeam">Asignar</button>
            </div>
            </div>
        </div>
        </div>
</template>
<script>
import axios from 'axios'

export default {
    props:{
        project: Object,
        activity: Object
    },
    data(){
        return{
            team_selected: '',
            teams:[]
        }
    },
    methods:{
        assignTeam(){
            const fd =  new FormData()

            fd.append('project_id', this.project.id)
            fd.append('team_selected', this.team_selected)
            axios.post('/api/assignTeam', fd)
            .then(res =>{
                const fd = new FormData()
                fd.append('id', this.activity.id)
                fd.append('comment', 'Completado')

                axios.post('/api/updateProgress', fd)
                .then(res =>{
                    this.$emit('getActivities')
                })
                .catch(err =>{
                    if(err.response){
                        console.log(err.response.data)
                    }
                })
                $('#teamModal').modal('hide')
            })
            .catch(err =>{
                console.error(err)
            })

        },
        getAllTeams(){
            axios.get('/api/getAllTeams')
            .then(res =>{
                this.teams = res.data
            })
            .catch(err =>{
                console.error(err)
            })
        }
    },
    mounted(){
        this.getAllTeams()
    }

}
</script>