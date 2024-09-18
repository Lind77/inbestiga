<template>
    <div class="select" tabindex="0" @click="showOptions" @blur="hideOptions">
        <template v-if="userSelected">
            <span
                class="badge badge-dot me-2"
                v-if="userSelected.color"
                :style="`background-color:${userSelected.color}`"
            >
            </span>
            {{ userSelected.name }}
        </template>
        <template v-else> Selecciona un responsable </template>
    </div>
    <li class="list w-100 bg-ligth" v-if="showDropdown">
        <ul
            @click="clickOption(user)"
            class="mb-0 ps-2"
            v-for="user in users"
            :id="user.id"
        >
            <span
                class="badge badge-dot me-2"
                v-if="user.color"
                :style="`background-color:${user.color}`"
            >
            </span>
            {{
                user.name
            }}
        </ul>
    </li>
</template>
<script>
export default {
    methods: {
        clickOption(user) {
            this.$emit("changeEventColor", user.id, user.color);
            $(".select").html($("#" + user.id));
            this.showDropdown = false;
        },
        showOptions() {
            this.showDropdown = !this.showDropdown;
        },
        hideOptions() {
            this.showDropdown = false;
        },
    },
    data() {
        return {
            showDropdown: false,
        };
    },
    props: {
        users: Array,
        userSelected: Object,
    },
};
</script>
<style scoped>
.select {
    border: 1px solid #d9dee3;
    border-radius: 7px;
    padding: 7px 15px;
    cursor: pointer;
}

.select:focus {
    border: 2px solid #696cff;
}

.list {
    box-shadow: 0px 4px 20px -1px rgba(0, 0, 0, 0.165);
    border-radius: 5px;
    list-style: none;
}

.list ul {
    margin-bottom: 0px;
    padding: 10px 15px;
}

.list ul:hover {
    background-color: #dadada;
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
