<template lang="">
    <div class="card bg-info mt-2">
        <div class="card-body">
            <h4 class="text-white">Separa tu reunión.</h4>
            <button
                class="btn btn-warning"
                v-if="
                    quotation.contract &&
                    quotation.contract.projects[0] &&
                    quotation.contract.projects[0].team &&
                    quotation.contract.projects[0].team.name
                "
                @click="toCalendly"
            >
                CLICK AQUÍ <i class="bx bx-headphone"></i>
            </button>
            <h6 class="text-white mt-2" v-if="quotation && quotation.contract">
                Equipo asignado:
                {{
                    quotation.contract.projects[0].team
                        ? quotation.contract.projects[0].team.name
                        : "Sin asignar"
                }}
            </h6>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        quotation: Object,
    },
    methods: {
        toCalendly() {
            var team = this.quotation.contract.projects[0].team;

            var coordSelected = team.users.find(
                (user) => user.roles[0].name == "CoordAcad"
            );

            console.log(coordSelected);

            window.open(coordSelected.calendly_user);
        },
    },
};
</script>
<style lang=""></style>
