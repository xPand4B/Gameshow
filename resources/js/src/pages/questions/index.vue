<template>
    <game-menu
        custom-card
        back-link="gameshow.menu.index"
    >
        <!-- Title-->
        <template v-slot:title>
            {{ $t('settings.title') }}
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

    }
</script>
