<template>
    <div
        class="modal fade"
        id="adendumsUserModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel1">
                        Adendas
                    </h5>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="text-white">Fecha</td>
                                <td class="text-white">Estado</td>
                                <td class="text-white">Opciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="addendum in addendums">
                                <td class="text-white">{{ addendum.date }}</td>
                                <td class="text-white">
                                    {{ addendumStatuses[addendum.status] }}
                                    <div class="d-flex">
                                        <button
                                            class="btn btn-sm btn-icon btn-success"
                                            @click="
                                                updateStatus(1, addendum.id)
                                            "
                                        >
                                            <i class="bx bx-check"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-icon btn-danger ms-1"
                                            @click="
                                                updateStatus(2, addendum.id)
                                            "
                                        >
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a
                                        :href="`${appUrl}api/showAddendum/${addendum.id}`"
                                        target="_blank"
                                        class="btn btn-icon btn-info mx-2 text-white"
                                        disabled
                                        ><i class="bx bx-file"></i
                                    ></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        addendums: Array,
    },
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
            addendumStatuses: {
                0: "Por confirmar",
                1: "Aceptado",
                2: "Rechazado",
            },
        };
    },
    methods: {
        updateStatus(newStatus, addendumId) {
            const fd = new FormData();

            fd.append("status", newStatus);
            fd.append("_method", "PUT");

            axios
                .post("/api/update-addendum-status/" + addendumId, fd)
                .then((result) => {
                    this.$emit("getProjectInfo");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.112);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 5px;

    padding: 10px 0px;
}
</style>
