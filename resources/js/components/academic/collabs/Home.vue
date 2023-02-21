<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Colaboradores</h4>
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1039px">
                        <thead>
                            <tr>
                                <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1" style="width: 0px; display: none" aria-label=""></th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 252px" aria-label="User: activate to sort column ascending" aria-sort="descending">
                                    Colaborador
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px" aria-label="Role: activate to sort column ascending">
                                    Equipo
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even" v-for="owner in owners">
                                <td class="control" tabindex="0" style="display: none"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-success">{{ owner.name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <router-link :to="{name:'user-acad', params:{ idUser: owner.id }}" class="text-body text-truncate"><span class="fw-semibold">{{ owner.name }}</span>
                                            </router-link>
                                            <small class="text-muted">{{ owner.email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-success" v-if="owner.memoir">Equipo {{ owner.memoir.team.name }}</span>
                                    <div v-else class="d-inline-block text-nowrap">
                                        <button class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <span class="badge bg-label-danger" >Pendiente</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a v-for="team in teams" @click="assignTeam(owner.id, team.id)" class="dropdown-item">{{ team.name }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            owners:[],
            teams: []
        }
    },
    methods:{
        getAllOwners(){
            axios.get('/api/getAllOwners')
            .then(res =>{
                this.owners = res.data
            })
            .catch(err =>{
                console.log(err)
            })
        },
        getAllTeams(){
            axios.get('/api/getAllTeams')
            .then(res =>{
                this.teams = res.data
            })
            .catch(err =>{
                console.log(err)
            })
        },
        assignTeam(owner_id, team_id){

            const fd = new FormData()

            fd.append('team_id', team_id)
            fd.append('owner_id', owner_id)

            axios.post('/api/assignTeamUser', fd)
            .then(res =>{
                this.getAllOwners()
            })
            .catch(err =>{
                console.log(err)
            })
        }
    },
    mounted(){
        this.getAllOwners()
        this.getAllTeams()
    }
}
</script>
