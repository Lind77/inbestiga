<template>
    <div class="card bg-primary text-white mb-3">
    <div class="card-body">
        <h5 class="card-title text-white mb-0">Equipo {{ team.name }}</h5>
    </div>
    </div>
</template>
<script>
    export default{
        name: 'CardTeam',
        props:{
            team: Object
        }
    }
</script>