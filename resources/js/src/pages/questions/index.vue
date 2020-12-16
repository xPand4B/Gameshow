<template>
    <game-menu
        back-link="gameshow.menu.index"
    >
        <!-- Title-->
        <template v-slot:title>
            {{ $t('questions.title') }}
        </template>

        <template v-slot:content>
            <!-- Tab selection -->
            <v-row>
                <!-- Tabs -->
                <v-col
                    cols="11"
                    class="py-0 px-0"
                >
                    <v-tabs
                        v-model="selectedTab"
                        center-active
                        show-arrows
                    >
                        <v-tab
                            v-for="(item, index) in questions"
                            :key="`questions.tab.${index}`"
                            class="px-0"
                        >
                            {{ getDisplayableIndex(index) }}
                        </v-tab>

                    </v-tabs>
                </v-col>

                <!-- Abb tab -->
                <v-col class="py-0 px-0 my-auto text-center">
                    <v-btn
                        @click="addQuestion"
                        icon
                    >
                        <v-icon v-text="'fas fa-plus'"/>
                    </v-btn>
                </v-col>
            </v-row>

            <v-divider class="pb-5"/>

            <v-tabs-items v-model="selectedTab">
                <v-tab-item
                    v-for="(item, index) in questions"
                    :key="`questions.tab.${index}.item`"
                >
                    <!-- Question -->
                    <v-textarea
                        v-model="questions[selectedTab].question"
                        :label="$t('questions.form.question.label')"
                        clear-icon="fas fa-times"
                        clearable
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
                        <v-expansion-panel
                            v-for="(item, index) in questions[selectedTab].answers"
                            :key="`question.${selectedTab}.answer.${index}`"
                        >
                            <!-- Header -->
                            <v-expansion-panel-header class="blue-grey lighten-4">
                                <h3>{{ $t('questions.form.title', { num: getDisplayableIndex(index) }) }}</h3>
                            </v-expansion-panel-header>

                            <!-- Content -->
                            <v-expansion-panel-content>
                                <!-- Answers -->
                                <v-row>
                                    <v-col class="pb-0">
                                        <v-textarea
                                            v-model="questions[selectedTab].answers[index].answer"
                                            :label="$t('questions.form.answer.label')"
                                            clear-icon="fas fa-times"
                                            clearable
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
                                            v-model="questions[selectedTab].answers[index].context"
                                            :label="$t('questions.form.answerNote.label')"
                                            :hint="$t('questions.form.answerNote.hint')"
                                            clear-icon="fas fa-times"
                                            clearable
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
                                            v-model="questions[selectedTab].answers[index].isCorrect"
                                            :label="$t('questions.form.isCorrect.label')"
                                        />
                                    </v-col>
                                </v-row>

                                <!-- Delete answer option -->
                                <v-row>
                                    <v-col class="py-0">
                                        <v-btn
                                            @click="deleteAnswerOption(index)"
                                            elevation="4"
                                            color="red darken-1"
                                            block
                                            outlined
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
                    </v-expansion-panels>

                    <!-- Bottom action buttons -->
                    <v-row class="mt-10">
                        <!-- Add Answer -->
                        <v-col cols="6">
                            <v-btn
                                @click="addAnswerOption"
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

                        <!-- Delete question -->
                        <v-col>
                            <v-btn
                                @click="deleteQuestion(index)"
                                elevation="4"
                                color="red darken-2"
                                block
                                outlined
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

        </template>
    </game-menu>
</template>

<script>
    import { GameMenu } from './../../components/gamemenu';

    export default {
        name: "pages-questions-index",

        components: {
            GameMenu,
        },

        data: () => ({
            selectedTab: 0,
            selectedAnswerOption: null,
            questions: []
        }),

        created() {
            if (this.questions.length === 0) {
                this.addQuestion();
                this.addQuestion();
                this.selectedTab = 0;
            }
        },

        watch: {
            selectedTab: {
                handler() {
                    this.selectedAnswerOption = null;
                }
            }
        },

        methods: {
            getDisplayableIndex(index) {
                let displayIndex = (index + 1);

                if (displayIndex < 10) {
                    displayIndex = `0${displayIndex}`;
                }

                return displayIndex;
            },

            addQuestion() {
                this.questions.push({
                    question: '',
                    answers: [
                        this.getNewAnswerOption(),
                        this.getNewAnswerOption(),
                        this.getNewAnswerOption(),
                        this.getNewAnswerOption(),
                    ]
                });
            },

            addAnswerOption() {
                this.questions[this.selectedTab].answers.push(
                    this.getNewAnswerOption()
                );
            },

            getNewAnswerOption() {
                return { answer: '', context: '', isCorrect: false };
            },

            deleteQuestion(index) {
                if (this.questions.length === 1) {
                    Swal.fire({
                        icon: 'error',
                        title: this.$t('questions.modal.lastQuestion.title'),
                        text: this.$t('questions.modal.lastQuestion.text'),
                    });
                    return;
                }

                this.selectedTab = this.questions.length - 2;
                this.questions.splice(index, 1);
            },

            deleteAnswerOption(index) {
                if (this.questions[this.selectedTab].answers.length === 2) {
                    Swal.fire({
                        icon: 'error',
                        title: this.$t('questions.modal.lastAnswerOption.title'),
                        text: this.$t('questions.modal.lastAnswerOption.text'),
                    });
                    return;
                }

                this.questions[this.selectedTab].answers.splice(
                    index, 1
                );
            },
        }
    }
</script>
