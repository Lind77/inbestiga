<template>
    <div class="w-100">
        <div class="card">
            <div class="card-header">
                <span class="h5 mt-2 demo text-body fw-bold"
                    >Información General
                </span>
            </div>
            <div class="card-body">
                <div class="mt-2">
                    <p class="mb-2">
                        <span class="fw-bold">Servicio Contratado </span>
                    </p>
                    <div class="list-group">
                        <a
                            v-for="detail in quotation.details"
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action"
                        >
                            {{ detail.name }}</a
                        >
                    </div>
                </div>
                <table class="table" v-if="quotation.contract">
                    <thead>
                        <tr>
                            <th>Servicio Adicional</th>
                            <th>Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <i class="bx bx-landscape"></i> Lugar o contexto
                                de estudio
                            </td>
                            <td>
                                {{
                                    quotation.contract.third_article_place == 0
                                        ? "Inbestiga"
                                        : "Usuario"
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bx bxs-vial"></i> Aplicación de
                                instrumentos
                            </td>
                            <td>
                                {{
                                    quotation.contract.third_article == 0
                                        ? "Inbestiga"
                                        : "Usuario"
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bx bxs-collection"></i> Diapositivas
                            </td>
                            <td>
                                {{
                                    quotation.contract.ppts == 0
                                        ? "Inbestiga"
                                        : "Usuario"
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        quotation: Object,
    },
};
</script>
<style lang=""></style>
