<template>
    <div class="mb-3">
        <label for="formFile" class="form-label">{{ file.label }}</label>
        <template v-if="file.complete == false">
            <input
                class="form-control"
                type="file"
                id="formFile"
                @change="insertFile"
            />
        </template>
        <template v-else>
            <button
                class="btn btn-success rounded cursor-pointer text-white p-3 mb-2 w-100"
                @click="downloadFile(file.url)"
            >
                {{ file.url }}
            </button>
        </template>
    </div>
</template>
<script>
export default {
    props: {
        file: Object,
        projectId: Number,
        status: Number,
    },
    data() {
        return {};
    },
    methods: {
        insertFile(e) {
            this.$swal("Cargando datos...");

            const fd = new FormData();
            fd.append("file", e.target.files[0]);
            fd.append("project_id", this.projectId);
            fd.append("type", 1);
            fd.append("status", this.status);
            axios
                .post("/api/file-archive", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((result) => {
                    this.$emit("getQuotation");
                    this.$swal.close();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        downloadFile(url) {
            window.open("https://inbestiga.com/inbestiga/public/files/" + url);
        },
    },
};
</script>
<style lang=""></style>
