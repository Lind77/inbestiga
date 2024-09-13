<template>
    <div class="select" @click="showOptions">Selecciona un responsable</div>
    <li class="list w-100 bg-ligth" v-if="showDropdown">
        <ul @click="clickOption">
            <span class="badge badge-dot bg-warning me-2"> </span>
            test
        </ul>
    </li>
</template>
<script>
export default {
    methods: {
        clickOption() {
            this.showDropdown = false;
        },
        showOptions() {
            this.showDropdown = !this.showDropdown;
        },
    },
    data() {
        return {
            showDropdown: false,
        };
    },
};
</script>
<style scoped>
.select {
    border: 2px solid #696cff;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
}

.list {
    border: 1px solid #696cff;
    border-radius: 5px;
    list-style: none;
}

.list ul {
    margin-bottom: 0px;
    padding: 10px 15px;
}

.list ul:hover {
    background-color: #a5a5a5;
}

.badge.badge-dot {
    display: inline-block;
    margin: 0;
    padding: 0;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    vertical-align: middle;
}
</style>
