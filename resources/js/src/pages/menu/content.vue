<template>
    <v-container class="pt-6 px-6">
        <template v-if="isGamemaster">
            <!-- To many players alert -->
            <v-slide-y-transition
                hide-on-leave
                mode="out-in"
            >
                <v-alert
                    v-if="getLobbyTooManyPlayers"
                    class="mb-8"
                    elevation="2"
                    type="warning"
                    border="left"
                >
                    {{ $t('lobby.full') }}
                </v-alert>
            </v-slide-y-transition>

            <!-- Start -->
            <v-slide-y-reverse-transition
                hide-on-leave
                mode="out-in"
            >
                <v-btn
                    v-if="!getLobbyTooManyPlayers"
                    @click.stop="startGame()"
                    class="mb-8"
                    color="indigo"
                    elevation="2"
                    :disabled="getLobbyTooManyPlayers"
                    block
                    x-large
                    outlined
                >
                    <i class="fas fa-play pr-2"/>
                    {{ $t('menu.gamemaster.items.start') }}
                </v-btn>
            </v-slide-y-reverse-transition>
        </template>

        <v-dialog
            v-model="dialog"
            max-width="600"
        >
            <menu-content-start-modal>
                <template v-slot:cancelButton>
                    <v-btn
                        @click="dialog = false"
                        color="red darken-1"
                        outlined
                        block
                    >
                        <v-icon
                            v-text="'fas fa-times'"
                            class="mr-2"
                        />
                        {{ $t('menu.modal.cancel') }}
                    </v-btn>
                </template>

                <template
                    v-if="getLobbyFull"
                    v-slot:startButton
                >
                    <v-btn
                        @click="dialog = false"
                        color="green darken-1"
                        outlined
                        block
                    >
                        <i class="fas fa-play fa-sm mr-2"></i>
                        {{ $t('menu.modal.start') }}
                    </v-btn>
                </template>
            </menu-content-start-modal>
        </v-dialog>

        <!-- Questions -->
        <game-menu-buttons
            v-if="isGamemaster"
            class="mb-8"
            :text="$t('menu.gamemaster.items.questions')"
            route-name="gameshow.questions"
            icon="fas fa-question"
        />

        <!-- Settings -->
        <game-menu-buttons
            :text="$t('menu.gamemaster.items.settings')"
            class="mb-8"
            route-name="gameshow.settings"
            icon="fas fa-cogs"
        />
    </v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import { GameMenuButtons } from './../../components/gamemenu';
    import MenuContentStartModal from './startGameModal';

    export default {
        name: "pages-menu-content",

        components: {
            GameMenuButtons,
            MenuContentStartModal,
        },

        data: () => ({
            dialog: false
        }),

        computed: {
            ...mapGetters([
                'isGamemaster',
                'getLobbyFull',
                'getLobbyTooManyPlayers',
                'getGameQuestions',
            ]),
        },

        methods: {
            ...mapActions([
                'fetchQuestions'
            ]),

            async startGame() {
                if (this.getGameQuestions.length === 0) {
                    await this.fetchQuestions(this.$route.params.id);
                }
                this.dialog = true;
            },
        }
    }
</script>
