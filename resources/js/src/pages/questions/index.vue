<template>
    <game-menu
        back-link="gameshow.menu.index"
    >
        <!-- Title-->
        <template v-slot:title>
            {{ $t('questions.title') }}
        </template>

        <template v-slot:content>

            <v-tabs
                v-model="tab"
                fixed-tabs
                show-arrows
            >
                <v-tab
                    v-for="item in items"
                    :key="item"
                >
                    {{ item }}
                </v-tab>

                <v-tab disabled>
                    <v-icon v-text="'fas fa-plus'"/>
                </v-tab>
            </v-tabs>
            <v-divider class="pb-5"/>

            <!-- Question -->
            <v-textarea
                :label="$t('questions.form.question.label')"
                rows="4"
                dense
                outlined
                required
                aria-required="true"
            />

            <v-divider class="pb-5"/>

            <!-- Answers -->
            <v-card
                elevation="6"
                class="px-5 py-1"
                rounded
            >
                <v-row>
                    <!-- Answers -->
                    <v-col
                        cols="11"
                        class="pb-0"
                    >
                        <v-textarea
                            :label="$t('questions.form.answer.label')"
                            rows="3"
                            dense
                            outlined
                            required
                            aria-required="true"
                        />
                    </v-col>
                    <!-- Answers -->
                    <v-col class="pb-0 px-0">
                        <v-btn
                            icon
                        >
                            <v-icon
                                color="red darken-2"
                                v-text="'fas fa-times'"
                            />
                        </v-btn>
                    </v-col>
                </v-row>

                <!-- Answer Note -->
                <v-row>
                    <v-col class="py-0">
                        <v-textarea
                            :label="$t('questions.form.answerNote.label')"
                            :hint="$t('questions.form.answerNote.hint')"
                            rows="1"
                            persistent-hint
                            dense
                            outlined
                        />
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="py-0">
                        <v-checkbox
                            :label="$t('questions.form.isCorrect.label')"
                        />
                    </v-col>
                </v-row>
            </v-card>

            <!-- Add Answer -->
            <v-btn
                elevation="4"
                color="deep-purple darken-1"
                class="my-7"
                block
                outlined
            >
                <v-icon
                    v-text="'fas fa-plus'"
                    class="pr-4"
                />
                {{ $t('questions.form.addAnswer.button') }}
            </v-btn>

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
            tab: null,
            items: [
                '01', '02', '03', '04',
            ],
        })
    }
</script>
