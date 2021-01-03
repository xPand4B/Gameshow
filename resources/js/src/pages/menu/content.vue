<template>
    <v-container class="pt-6 px-6">
        <template v-if="isGamemaster">
            <!-- To many players alert -->
            <v-slide-y-transition
                hide-on-leave
                mode="out-in"
            >
                <v-alert
                    v-if="getLobbyFull"
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
                    v-if="!getLobbyFull"
                    @click="startGame"
                    class="mb-8"
                    color="indigo"
                    elevation="2"
                    :disabled="getLobbyFull"
                    block
                    x-large
                    outlined
                >
                    <i class="fas fa-play pr-2"/>
                    {{ $t('menu.gamemaster.items.start') }}
                </v-btn>
            </v-slide-y-reverse-transition>
        </template>

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
    import { mapGetters } from 'vuex';
    import { GameMenuButtons } from './../../components/gamemenu';

    export default {
        name: "pages-menu-content",

        computed: {
            ...mapGetters([
                'isGamemaster',
                'getLobbyFull'
            ]),
        },

        components: {
            GameMenuButtons,
        },

        methods: {
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

        }
    }
</script>
