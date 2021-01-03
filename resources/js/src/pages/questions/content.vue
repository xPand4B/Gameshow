<template>
    <v-container>
        <!-- Tab selection -->
        <v-row>
            <!-- Tabs -->
            <v-col class="col-12 col-sm-11 py-0 px-0">
                <v-tabs
                    v-model="selectedTab"
                    center-active
                    show-arrows
                >
                    <v-tab
                        v-for="(item, questionIndex) in getGameQuestionsFormatted"
                        :key="`questions.tab.${questionIndex}`"
                        class="px-0"
                    >
                        {{ getDisplayableIndex(questionIndex) }}
                    </v-tab>

                </v-tabs>
            </v-col>

            <!-- Abb tab -->
            <v-col class="col-12 col-sm-1 py-0 px-0 my-auto text-center">
                <v-btn
                    @click="onAddQuestion"
                    icon
                >
                    <v-icon v-text="'fas fa-plus'"/>
                </v-btn>
            </v-col>
        </v-row>

        <v-divider class="pb-5"/>

        <!-- Tab Items -->
        <v-tabs-items v-model="selectedTab">
            <v-tab-item
                v-for="(question, questionIndex) in getGameQuestionsFormatted"
                :key="`questions.tab.${questionIndex}.item`"
            >
                <!-- Question -->
                <v-textarea
                    v-model="getGameQuestionsFormatted[selectedTab].question"
                    @change="onUpdateQuestions({ name: 'question' }, getGameQuestionsFormatted[selectedTab].question)"
                    :label="$t('questions.form.question.label')"
                    rows="4"
                    dense
                    outlined
                    required
                    aria-required="true"
                />

                <v-divider class="pb-5"/>

                <!-- Content -->

                <v-expansion-panels
                    v-model="selectedAnswerOption"
                    accordion
                    focusable
                >
                    <v-slide-y-reverse-transition
                        style="width: 100%"
                        mode="out-in"
                        hide-on-leave
                        group
                    >
                    <v-expansion-panel
                        v-for="(answer, answerIndex) in getAnswersFromSelectedQuestion"
                        :key="`question.${selectedTab}.answer.${answerIndex}`"
                    >
                        <!-- Header -->
                        <v-expansion-panel-header class="blue-grey lighten-4">
                            <h3>
                                {{ $t('questions.form.title', { num: getDisplayableIndex(answerIndex) }) }}
                                <v-scroll-x-transition>
                                    <i
                                        v-if="getAnswersByIndex(answerIndex).isCorrect"
                                        class="primary--text fas fa-star fa-sm"
                                    ></i>
                                </v-scroll-x-transition>
                            </h3>
                        </v-expansion-panel-header>

                        <!-- Content -->

                        <v-expansion-panel-content>
                            <!-- Answers -->
                            <v-row>
                                <v-col class="pb-0">
                                    <v-textarea
                                        v-model="getAnswersByIndex(answerIndex).answer"
                                        @change="onUpdateQuestions({ name: 'answer', answerId: answer.id }, getAnswersByIndex(answerIndex).answer)"
                                        :label="$t('questions.form.answer.label')"
                                        rows="3"
                                        dense
                                        outlined
                                        required
                                        aria-required="true"
                                    />
                                </v-col>
                            </v-row>

                            <!-- Answer Note -->
                            <v-row>
                                <v-col class="py-0">
                                    <v-textarea
                                        v-model="getAnswersByIndex(answerIndex).context"
                                        @change="onUpdateQuestions({ name: 'context', answerId: answer.id }, getAnswersByIndex(answerIndex).context)"
                                        :label="$t('questions.form.answerNote.label')"
                                        :hint="$t('questions.form.answerNote.hint')"
                                        rows="1"
                                        persistent-hint
                                        dense
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <!-- Correct Answer -->
                            <v-row>
                                <v-col class="py-0">
                                    <v-checkbox
                                        v-model="getAnswersByIndex(answerIndex).isCorrect"
                                        @change="onUpdateQuestions({ name: 'isCorrect', answerId: answer.id }, getAnswersByIndex(answerIndex).isCorrect)"
                                        :label="$t('questions.form.isCorrect.label')"
                                    />
                                </v-col>
                            </v-row>

                            <!-- Delete answer option -->
                            <v-row class="py-0">
                                <v-col class="py-0">
                                    <v-btn
                                        @click="onDeleteAnswerOption(answer.id)"
                                        elevation="4"
                                        color="red darken-1"
                                        block
                                        outlined
                                        :disabled="!!isSecondLastAnswer"
                                    >
                                        <v-icon
                                            v-text="'fas fa-times'"
                                            class="pr-2"
                                        />
                                        {{ $t('questions.form.deleteAnswerOption.button') }}
                                    </v-btn>
                                </v-col>
                            </v-row>

                        </v-expansion-panel-content>
                    </v-expansion-panel>
                    </v-slide-y-reverse-transition>
                </v-expansion-panels>

            <!-- Bottom action buttons -->
                <!-- Add Answer -->
                <v-row class="mt-6">
                    <v-col>
                        <v-btn
                            @click="onAddAnswerOption(questionIndex)"
                            elevation="4"
                            color="green darken-1"
                            block
                            outlined
                        >
                            <v-icon
                                v-text="'fas fa-plus'"
                                class="pr-2"
                            />
                            {{ $t('questions.form.addAnswer.button') }}
                        </v-btn>
                    </v-col>
                </v-row>

                <!-- Delete question -->
                <v-row>
                    <v-col>
                        <v-btn
                            elevation="4"
                            @click="onDeleteQuestion(questionIndex)"
                            color="red darken-2"
                            block
                            outlined
                            :disabled="!!isLastQuestion"
                        >
                            <v-icon
                                v-text="'fas fa-trash'"
                                class="pr-2"
                            />
                            {{ $t('questions.form.deleteQuestion.button') }}
                        </v-btn>
                    </v-col>
                </v-row>

            </v-tab-item>
        </v-tabs-items>

    </v-container>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "pages-questions-content",

        data: () => ({
            loading: true,
            selectedTab: 0,
            selectedAnswerOption: null,
        }),

        watch: {
            selectedTab: {
                handler() {
                    this.selectedAnswerOption = null;
                }
            }
        },

        computed: {
            ...mapGetters([
                'getGameQuestions',
                'getGameQuestionsFormatted'
            ]),

            getAnswersFromSelectedQuestion() {
                return this.getGameQuestionsFormatted[this.selectedTab].answers;
            },

            isLastQuestion() {
                return this.getGameQuestionsFormatted.length === 1;
            },

            isSecondLastAnswer() {
                return this.getAnswersFromSelectedQuestion.length === 2;
            }
        },

        methods: {
            ...mapActions([
                'addQuestion',
                'deleteQuestion',
                'updateQuestions',
                'addAnswerOption',
                'deleteAnswerOption',
            ]),

            getDisplayableIndex(index) {
                let displayIndex = (index + 1);

                if (displayIndex < 10) {
                    displayIndex = `0${displayIndex}`;
                }

                return displayIndex;
            },

            getAnswersByIndex(answerIndex) {
                return this.getAnswersFromSelectedQuestion[answerIndex];
            },

            onAddQuestion() {
                this.addQuestion(this.$route.params.id).then(() => {
                    this.selectedAnswerOption = undefined;
                    this.selectedTab = this.getGameQuestionsFormatted.length - 1;
                });
            },

            onUpdateQuestions(field = {}, value) {
                let data = {
                    gameId: this.$route.params.id,
                    questionId: this.getGameQuestions.data.attributes[this.selectedTab].id,
                };

                switch(field.name) {
                    case 'answer':
                    case 'context':
                    case 'isCorrect':
                        data.payload = { name: field.name, answerId: field.answerId, value };
                        break;

                    default:
                        data.payload = { name: field.name, value };
                        break;
                }

                this.updateQuestions(data);
            },

            onAddAnswerOption(index) {
                this.addAnswerOption({
                    gameId: this.$route.params.id,
                    questionId: this.getGameQuestions.data.attributes[this.selectedTab].id,
                    index
                }).then(() => {
                    // this.selectedAnswerOption = this.getGameQuestionsFormatted[index].answers.length - 1;
                });
            },

            onDeleteQuestion(index) {
                if (this.isLastQuestion) {
                    Swal.fire({
                        icon: 'error',
                        title: this.$t('questions.modal.lastQuestion.title'),
                        text: this.$t('questions.modal.lastQuestion.text'),
                    });
                    return;
                }

                if (this.selectedTab === this.getGameQuestionsFormatted.length - 1) {
                    this.selectedTab = this.getGameQuestionsFormatted.length - 2;
                }

                this.selectedAnswerOption = null;

                this.deleteQuestion({
                    gameId: this.$route.params.id,
                    questionId: this.getGameQuestions.data.attributes[this.selectedTab].id,
                    index
                });
            },

            onDeleteAnswerOption(answerId) {
                if (this.getAnswersFromSelectedQuestion.length === 2) {
                    Swal.fire({
                        icon: 'error',
                        title: this.$t('questions.modal.lastAnswerOption.title'),
                        text: this.$t('questions.modal.lastAnswerOption.text'),
                    });
                    return;
                }

                this.selectedAnswerOption = undefined;

                this.deleteAnswerOption({
                    gameId: this.$route.params.id,
                    questionId: this.getGameQuestions.data.attributes[this.selectedTab].id,
                    answerId,
                    index: this.selectedTab
                });
            },
        }
    }
</script>

<style scoped lang="scss">
    .v-expansion-panel--active+.v-expansion-panel, .v-expansion-panel--active:not(:first-child) {
        margin-top: 0 !important;
    }

    .v-expansion-panel--active>.v-expansion-panel-header {
        min-height: auto !important;
    }
</style>
