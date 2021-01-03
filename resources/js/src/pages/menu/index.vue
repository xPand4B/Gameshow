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

        <menu-content/>

    </game-menu>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { GameMenu } from './../../components/gamemenu';
    import MenuContent from './content';

    export default {
        name: "pages-menu-index",

        components: {
            GameMenu,
            MenuContent,
        },

        computed: {
            ...mapGetters([
                'isGamemaster'
            ])
        },
    }
</script>
