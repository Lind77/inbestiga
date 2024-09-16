<template>
    <div class="select" @click="showOptions">Selecciona un responsable</div>
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
            this.$emit("changeEventColor", user.id);
            $(".select").html($("#" + user.id));
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
    props: {
        users: Array,
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
