<template>
    <div class="modal fade" id="filesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content glass">
                <div class="modal-body">
                    <h4 class="text-white text-center fw-normal">
                        Archivos del proyecto
                    </h4>
                    <template v-for="file in files">
                        <div
                            class="card bg-secondary text-white my-2 cursor-pointer"
                            v-if="file.files.length > 0"
                            @click="showVoucherImage(file)"
                        >
                            <div class="card-body">
                                <small>{{
                                    formatDate(file.files[0].created_at)
                                }}</small>
                                <h5
                                    class="card-title text-white"
                                    v-if="file && file.files[0]"
                                >
                                    {{ file.files[0].url }}
                                </h5>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            statusByNumber: {
                1: "Pendiente",
                2: "Aprobado",
                3: "Rechazado",
            },
        };
    },
    props: {
        files: Array,
    },
    methods: {
        showVoucherImage(file) {
            var fileUrl = file.files[0].url;

            window.open(
                "https://inbestiga.com/inbestiga/public/files/" + fileUrl
            );
        },
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY");
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
