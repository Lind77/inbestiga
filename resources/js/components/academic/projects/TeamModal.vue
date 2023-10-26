<template>
    <div class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Asignar a un equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
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
export default {
    props: {
        contract: Number
    },
    data() {
        return {
            team_selected: '',
            teams: []
        }
    },
    methods: {
        assignTeam() {
            const fd = new FormData()
            fd.append('contract_id', this.contract)
            fd.append('team_selected', this.team_selected)
            axios.post('/api/assignTeam', fd)
                .then(res => {
                    console.log(res)
                    $('#teamModal').modal('hide')
                    this.$emit('getAllProjectsAcad')
                })
                .catch(err => {
                    console.error(err)
                })
        },
        getAllTeams() {
            axios.get('/api/getAllTeams')
                .then(res => {
                    this.teams = res.data
                })
                .catch(err => {
                    console.error(err)
                })
        }
    },
    mounted() {
        this.getAllTeams()
    }
}
</script>