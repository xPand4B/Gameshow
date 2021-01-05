<template>
    <v-card class="rounded-tr-xl rounded-bl-xl">
        <v-card-title class="headline blue-grey darken-1 white--text">
            {{ $t('menu.modal.title') }}
        </v-card-title>

        <v-card-text>
            <v-list>
                <start-modal-item
                    :text="$t('menu.modal.stats.currentPlayerCount')"
                    :value="`${getLobbyUserCount - 1}/${getCurrentGamePlayerCount}`"
                    :success="getLobbyFull"
                    :warning="!getLobbyFull"
                />
                <start-modal-item
                    :text="$t('menu.modal.stats.totalQuestions')"
                    :value="getGameQuestionsTotalCount.toString()"
                    :success="getGameQuestionsTotalCount > 5"
                    :warning="getGameQuestionsTotalCount <= 5"
                />

                <v-divider/>

                <start-modal-item
                    :text="$t('menu.modal.stats.correctPoints')"
                    :value="getGamePointSettings.correctAnswer.toString()"
                />
                <start-modal-item
                    :text="$t('menu.modal.stats.pointsIfWrongAnswer')"
                    :value="getGamePointSettings.pointsForPlayersIfWrongAnswer ? $t('menu.modal.stats.pointsIfWrongAnswerTrue') : $t('menu.modal.stats.pointsIfWrongAnswerFalse')"
                />
                <start-modal-item
                    :text="$t('menu.modal.stats.wrongPoints')"
                    :value="getGamePointSettings.wrongAnswer.toString()"
                />

                <v-divider/>

                <start-modal-item
                    :text="$t('menu.modal.stats.activeJoker')"
                    :value="getActiveGameJokerCount.toString()"
                    :success="getActiveGameJokerCount !== 0"
                    :warning="getActiveGameJokerCount === 0"
                />
            </v-list>
        </v-card-text>

        <v-card-actions>
            <v-row>
                <v-col>
                    <slot name="cancelButton"/>
                </v-col>
                <v-col>
                    <v-slide-y-reverse-transition mode="out-in">
                        <slot name="startButton"/>
                    </v-slide-y-reverse-transition>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import StartModalItem from './startGameModalItem';

    export default {
        name: "pages-menu-startGameModal",

        components: {
            StartModalItem,
        },

        computed: {
            ...mapGetters([
                'getLobbyUserCount',
                'getCurrentGamePlayerCount',
                'getLobbyFull',
                'getGameQuestionsTotalCount',
                'getGamePointSettings',
                'getActiveGameJokerCount'
            ]),
        },

        methods: {
            ...mapActions([
                'fetchQuestions'
            ]),
        }
    }
</script>
