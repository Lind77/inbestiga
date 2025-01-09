<template>
    <div class="card my-1">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span class="h5 my-2 demo text-body fw-bold">Adendas </span>
                <button
                    class="btn btn-sm btn-success text-white"
                    @click="openAdendumsModal"
                >
                    Agregar Adendas
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <td>Fecha</td>
                        <td>Generador Por</td>
                        <td>Estado</td>
                        <td>Opciones</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="addendum in addendums">
                        <td>{{ addendum.date }}</td>
                        <td>{{ addendum.user_id }}</td>
                        <td>{{ addendum.status }}</td>
                        <td>
                            <a
                                :href="`${appUrl}api/showAddendum/${addendum.id}`"
                                target="_blank"
                                class="btn btn-icon btn-info mx-2 text-white"
                                disabled
                                ><i class="bx bx-file"></i
                            ></a>
                            <button
                                class="btn btn-danger btn-icon ms-2"
                                @click="deleteAddendum(addendum.id)"
                            >
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            appUrl: import.meta.env.VITE_AXIOS_URL,
        };
    },
    props: {
        addendums: Array,
    },
    methods: {
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
};
</script>
<style lang=""></style>
