<template>
    <game-menu
        back-link="gameshow.menu.index"
        :is-loading="loading"
    >
        <!-- Title-->
        <template v-slot:title>
            {{ $t('questions.title') }}
        </template>

        <question-content/>
    </game-menu>
</template>

<script>
    import { mapActions } from 'vuex';
    import { GameMenu } from './../../components/gamemenu';
    import QuestionContent from './content';

    export default {
        name: "pages-questions-index",

        components: {
            GameMenu,
            QuestionContent,
        },

        data: () => ({
            loading: true
        }),

        created() {
            this.fetchQuestions(this.$route.params.id).then(() => {
                this.loading = false;
            });
        },

        methods: {
            ...mapActions([
                'fetchQuestions',
            ]),
        }
    }
</script>
