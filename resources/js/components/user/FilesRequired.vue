<template>
    <div class="card mt-2">
        <div class="card-body">
            <label for="" class="text-white fw-bold"
                >Documentación Requerida</label
            >
            <div class="row">
                <div class="col-12">
                    <div v-for="file in filesProject">
                        <File
                            :file="file"
                            :projectId="project.id"
                            @getQuotation="getQuotation"
                        />
                    </div>
                    <div v-for="file in filesRequired">
                        <File
                            v-if="file.complete == false"
                            :file="file"
                            :projectId="project.id"
                            @getQuotation="getQuotation"
                            :status="file.status"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import File from "./File.vue";

export default {
    props: {
        filesProject: Array,
        filesRequired: Array,
        project: Object,
    },
    components: { File },
    methods: {
        getQuotation() {
            this.$emit("getQuotation");
        },
    },
    data() {
        return {
            filesRequired: [
                {
                    label: "Reglamento / lineamientos de investigación",
                    status: 1,
                    complete: false,
                },
                {
                    label: "Estructura de plan de tesis/ informe final",
                    status: 2,
                    complete: false,
                },
                {
                    label: "Plantilla de tesis o ejemplo de tesis",
                    status: 3,
                    complete: false,
                },
                {
                    label: "Manual de redacción de su universidad (APA, ISO, Vancouver)",
                    status: 4,
                    complete: false,
                },
            ],
        };
    },
    watch: {
        project() {
            this.project.files.forEach((file) => {
                if (file.type == 1) {
                    this.filesProject.push(file);
                    var fileRequiredFound = this.filesRequired.find(
                        (fileRequired) => fileRequired.status == file.status
                    );
                    fileRequiredFound.complete = true;
                    file.label = fileRequiredFound.label;
                } else if (file.type == 2) {
                    this.postFiles.push(file);
                }
            });

            this.filesProject.forEach((file) => {
                if (file.type == 1) {
                    var fileRequiredFound = this.filesRequired.find(
                        (fileRequired) => fileRequired.status == file.status
                    );
                    fileRequiredFound.complete = true;
                    file.label = fileRequiredFound.label;
                } else if (file.type == 2) {
                    var indexFile = this.filesProject.findIndex(
                        (fileProject) => fileProject.id == file.id
                    );
                    this.filesProject.splice(indexFile, 1);
                }
            });
        },
    },
};
</script>
<style scoped>
.card {
    background: none;
}
</style>
