<template>
    <!-- Player-Menu -->
    <game-menu
        :is-loading="!hasUsername"
        :fetch-game="hasUsername"
        :with-copy-link="hasUsername"
    >
        <!-- Menu-Title -->
        <template v-slot:title>
            <div v-if="isGamemaster">
                {{ $t('menu.gamemaster.title') }}
            </div>
            <div v-else>
                {{ $t('menu.player.title') }}
            </div>
        </template>

        <!-- Menu-Buttons -->
        <template
            v-if="hasUsername"
            v-slot:content
        >
            <!-- Start -->
            <v-btn
                v-if="isGamemaster"
                @click="startGame"
                class="mb-8"
                color="indigo"
                elevation="2"
                block
                x-large
                outlined
            >
                <i class="fas fa-play pr-2"/>
                {{ $t('menu.gamemaster.items.start') }}
            </v-btn>

            <!-- Questions -->
            <game-menu-buttons
                v-if="isGamemaster"
                :text="$t('menu.gamemaster.items.questions')"
                route-name="gameshow.questions"
                icon="fas fa-question"
            />

            <!-- Settings -->
            <game-menu-buttons
                :text="$t('menu.gamemaster.items.settings')"
                route-name="gameshow.settings"
                icon="fas fa-cogs"
            />
        </template>
    </game-menu>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import { GameMenuButtons, GameMenu } from './../../components/gamemenu';

    export default {
        name: "pages-menu-index",

        components: {
            GameMenu,
            GameMenuButtons,
        },

        data: () => ({
            username: '',
            hasUsername: false
        }),

        created() {
            this.hasUsername = this.hasPlayerNameSet;

            if (! this.hasUsername) {
                this.enterPlayerName();
            }
        },

        computed: {
            ...mapGetters([
                'hasPlayerNameSet',
                'isGamemaster',
            ]),
        },

        methods: {
            ...mapActions([
                'setPlayerName',
                'unsetPlayerName',
            ]),

            startGame() {
                // TODO: Add translation
                Swal.fire({
                    icon: 'question',
                    title: 'Are u sure?',
                    confirmButtonText: `Start game`,
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Start game
                    }
                })
            },

            enterPlayerName() {
                Swal.fire({
                    icon: 'question',
                    title: "What's your username?",
                    input: 'text',
                    allowOutsideClick: false,
                    preConfirm: (input) => {
                        if (!!!input) {
                            Swal.showValidationMessage(
                                this.$t('validation.required')
                            );
                        } else if (input.length > 20) {
                            Swal.showValidationMessage(
                                this.$t('validation.max-chars', { num: 20 })
                            );
                        }
                    }
                }).then(playerName => {
                    this.setPlayerName(playerName.value.toString()).then(() => {
                        this.$router.go(0);
                    });
                });
            }
        }
    }
</script>
