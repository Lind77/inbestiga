<template>
    <div class="mb-3">
        <label for="formFile" class="form-label">{{ label }}</label>
        <input
            class="form-control"
            type="file"
            id="formFile"
            @change="insertFile"
        />
    </div>
</template>
<script>
export default {
    props: {
        label: String,
        projectId: Number,
        type: Number,
    },
    methods: {
        insertFile(e) {
            this.$swal("Cargando datos...");

            const fd = new FormData();
            fd.append("file", e.target.files[0]);
            fd.append("project_id", this.projectId);
            fd.append("type", this.type);
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
    },
};
</script>
<style lang=""></style>
