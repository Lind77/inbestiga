<template>
    <div class="card invoice-preview-card mt-2">
        <div class="card-body">
            <span class="h5 m-2 demo text-body fw-bold"
                >Documentos necesarios
            </span>
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
};
</script>
<style lang=""></style>
