<template>
    <div class="card my-1">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span class="h5 my-2 demo text-body fw-bold">
                    Seleccionar Equipo
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-danger" v-show="!teamSelected">
                <p>
                    <strong>Nota:</strong> Si no seleccionas un equipo, el
                    proyecto no se asignará a ninguno y el usuario no podrá
                    agendar reuniones.
                </p>
            </div>
            <select v-model="teamIdSelected" class="form-control">
                <option value="">Seleccionar Equipo</option>
                <option :value="team.id" v-for="team in teams">
                    {{ team.name }}
                </option>
            </select>
            <button class="btn btn-success mt-2" @click="assignTeam">
                Asignar
            </button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
            addendumStatuses: {
                0: "Por confirmar",
                1: "Aceptado",
                2: "Rechazado",
            },
            teamIdSelected: 0,
        };
    },
    props: {
        teams: Array,
        projectId: Number,
        teamSelected: Number,
    },
    methods: {
        assignTeam() {
            if (this.teamIdSelected == 0) {
                alert("Selecciona un equipo");
                return;
            }
            axios
                .post("/api/assign-team", {
                    team_id: this.teamIdSelected,
                    project_id: this.projectId,
                })
                .then((result) => {
                    this.$emit("getQuotation");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        openAdendumsFile() {},
        deleteAddendum(addendumId) {
            if (confirm("Estás seguro de eliminar esta adenda?")) {
                axios
                    .delete("/api/addendums/" + addendumId)
                    .then((result) => {
                        this.$emit("getQuotation");
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        openAdendumsModal() {
            this.$emit("openAdendumsModal");
        },
    },
    mounted() {
        this.teamIdSelected = this.teamSelected;
    },
    watch: {
        teamSelected(newVal) {
            if (newVal) {
                console.log(newVal);
                this.teamIdSelected = newVal;
            }
        },
    },
};
</script>
<style lang=""></style>
