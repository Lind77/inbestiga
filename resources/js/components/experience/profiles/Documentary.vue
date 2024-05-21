<template lang="">
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
</template>
<script>
export default {
    props: {
        questions: Array,
    },
};
</script>
