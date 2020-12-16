<template>
    <!-- Player-Menu -->
    <game-menu with-copy-link>
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
            v-slot:content
        >
            <!-- Start -->
            <v-btn
                v-if="isGamemaster"
                @click="startGame"
                class="mt-8"
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
                class="mt-8"
                :text="$t('menu.gamemaster.items.questions')"
                route-name="gameshow.questions"
                icon="fas fa-question"
            />

            <!-- Settings -->
            <game-menu-buttons
                :text="$t('menu.gamemaster.items.settings')"
                class="mt-8"
                route-name="gameshow.settings"
                icon="fas fa-cogs"
            />
        </template>
    </game-menu>

</template>

<script>
    import { mapGetters } from 'vuex';
    import { GameMenuButtons, GameMenu } from './../../components/gamemenu';

    export default {
        name: "pages-menu-index",

        components: {
            GameMenu,
            GameMenuButtons,
        },

        computed: {
            ...mapGetters([
                'isGamemaster'
            ])
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
