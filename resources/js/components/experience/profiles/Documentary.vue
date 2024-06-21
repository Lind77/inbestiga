<template lang="">
    <div class="card invoice-preview-card mt-2">
        <div class="card-body">
            <div class="row">
                <span class="h5 mt-2 demo text-body fw-bold"
                    >Estado del trámite universitario</span
                >
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <template v-for="newQuestion in questions">
                                    <td v-if="newQuestion.type == 2">
                                        {{ newQuestion.question }}
                                    </td>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <template v-for="newQuestion in questions">
                                    <td v-if="newQuestion.type == 2">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            v-model="newQuestion.answer"
                                        />
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        questions: Array,
    },
    data() {
        return {
            documentaryQuestions: [
                { question: "Tema", answer: true, type: 2 },
                { question: "Plan de Tesis", answer: false, type: 2 },
                {
                    question: "Observaciones del Plan de Tesis",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Aprobación del Plan de Tesis",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Aplicación de instrumentos",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Elaboración de Informe Final",
                    answer: false,
                    type: 2,
                },
                {
                    question: "Observaciones del informe final",
                    answer: false,
                    type: 2,
                },
                { question: "Revisión de jurados", answer: false, type: 2 },
                { question: "Sustentación Final", answer: false, type: 2 },
            ],
        };
    },
};
</script>
