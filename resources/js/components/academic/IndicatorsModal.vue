<template>
    <div
        class="modal fade"
        id="indicatorsModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Indicadores de Calidad</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="close-progress-modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <template v-for="indicator in indicators">
                        <div class="d-flex mb-2">
                            <label
                                class="form-check-label"
                                for="flexSwitchCheckDefault"
                                >{{ indicator.name }}</label
                            >
                            <div class="form-check form-switch ps-5">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="flexSwitchCheckDefault"
                                    v-model="indicator.status"
                                />
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
                    <input
                        @click="insertDetailsFirstMeeting"
                        type="submit"
                        class="btn btn-primary"
                        value="Aprobar"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            detail: "",
        };
    },
    props: {
        indicators: Array,
    },
    methods: {},
};
</script>
