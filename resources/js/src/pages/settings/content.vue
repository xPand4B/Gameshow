<template>
    <div>
        <v-container>
            <v-tabs vertical>
            <!-- Tabs -->
                <!-- General -->
                <settings-tab
                    icon="fas fa-2x fa-cog"
                    :text="$t('settings.tabs.general.tab')"
                />

                <!-- Gameplay -->
                <settings-tab
                    icon="fas fa-2x fa-gamepad"
                    :text="$t('settings.tabs.gameplay.tab')"
                />

                <!-- Joker -->
                <settings-tab
                    icon="fas fa-2x fa-hat-wizard"
                    :text="$t('settings.tabs.joker.tab')"
                />

            <!-- Tab Content -->
                <!-- General -->
                <v-tab-item class="mx-10">
                    <v-card flat>
                        <v-card-text class="px-0">
                            <!-- Max. Player selection -->
                            <v-select
                                v-model="playerCount.selected"
                                :items="playerCount.available"
                                @change="updateGameSettings('player_count', playerCount.selected)"
                                :label="$t('settings.tabs.general.content.playerCount.label')"
                                :hint="$t('settings.tabs.general.content.playerCount.hint')"
                                :disabled="!isGamemaster"
                                persistent-hint
                                outlined
                            />
                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <!-- Gameplay -->
                <v-tab-item class="mx-10">
                    <v-card flat>
                        <v-card-text class="px-0">
                            <!-- Correct Answer Points -->
                            <v-text-field
                                v-model="points.correctAnswer"
                                @change="updateGameSettings('correct_points', points.correctAnswer)"
                                type="number"
                                :label="$t('settings.tabs.gameplay.content.correctAnswerPoints.label')"
                                :disabled="!isGamemaster"
                            />

                            <!-- Points for Players if the Answer is wrong -->
                            <v-checkbox
                                v-model="points.pointsForPlayersIfWrongAnswer"
                                @change="updateGameSettings('points_if_wrong_answer', points.pointsForPlayersIfWrongAnswer)"
                                class="mb-8"
                                :label="$t('settings.tabs.gameplay.content.pointsForPlayersIfWrongAnswer.label')"
                                :hint="$t('settings.tabs.gameplay.content.pointsForPlayersIfWrongAnswer.hint')"
                                persistent-hint
                                :disabled="!isGamemaster"
                            />

                            <!-- Wrong Answer Points -->
                            <v-text-field
                                v-model="points.wrongAnswer"
                                @change="updateGameSettings('wrong_points', points.wrongAnswer)"
                                type="number"
                                :label="$t('settings.tabs.gameplay.content.wrongAnswerPoints.label')"
                                :disabled="!points.pointsForPlayersIfWrongAnswer || !isGamemaster"
                            />
                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <!-- Joker -->
                <v-tab-item class="mx-10">
                    <v-card flat>
                        <v-card-text class="px-0">
                            <h3>{{ $t('settings.tabs.joker.title') }}</h3>

                            <v-divider/>

                            <div
                                v-for="(item, key, index) in joker"
                                :key="key + index.toString()"
                            >
                                <v-row>
                                    <v-col
                                        cols="8"
                                        class="py-0"
                                    >
                                        <v-checkbox
                                            v-model="item.value"
                                            @change="updateGameSettings(`joker.${key}`, item.value)"
                                            :label="item.label"
                                            :value="item.value"
                                            :disabled="!isGamemaster"
                                        />
                                    </v-col>

                                    <v-col
                                        cols="4"
                                        class="py-0"
                                    >
                                        <v-select
                                            v-model="item.count"
                                            @change="updateGameSettings(`joker.${key}`, item.count)"
                                            :items="availableJokerCount"
                                            class="mt-0"
                                            :disabled="!item.value || !isGamemaster"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col class="pt-0">
                                        <div class="v-messages__message">{{ item.hint }}</div>
                                    </v-col>
                                </v-row>
                            </div>

                        </v-card-text>
                    </v-card>
                </v-tab-item>

            </v-tabs>
        </v-container>
    </div>
</template>

<script>
    import SettingsTab from './settings-tab';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "pages-settings-content",

        components: {
            SettingsTab,
        },

        data: () => ({
            valid: true,
            loading: false,
            playerCount: {
                selected: null,
                available: [1, 2, 3, 4, 5]
            },
            availableJokerCount: [1, 2, 3, 4],
            joker: {},
            points: {}
        }),

        mounted() {
            this.updateStoredData();

            Echo.private(`Game.${this.getCurrentGameId}.Settings`)
                .listen('.game.updated', (game) => {
                    this.$store.dispatch('formatPusherData', game);
                    this.updateStoredData();
                });
        },

        computed: {
            ...mapGetters([
                'getCurrentGameId',
                'getCurrentGamePlayerCount',
                'getGameJoker',
                'getGamePointSettings',
                'isGamemaster',
            ])
        },

        methods: {
            updateStoredData() {
                this.playerCount.selected = this.getCurrentGamePlayerCount;

                this.points = this.getGamePointSettings;

                this.joker = this.getGameJoker;
            },

            updateGameSettings(fieldName = '', value) {
                this.loading = true;
                let payload = {};

                if (fieldName.includes('joker.')) {
                    payload = [];
                    for (let [name, item] of Object.entries(this.joker)) {
                        payload.push({
                            id: item.id,
                            count: item.count,
                            active: !!item.value
                        });
                    }
                } else {
                    if (typeof(value) === 'boolean') {
                        payload[fieldName] = !!value;
                    } else {
                        payload[fieldName] = value.toString();
                    }
                }

                this.$store
                    .dispatch('updateGameSettings', payload)
                    .then(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>
