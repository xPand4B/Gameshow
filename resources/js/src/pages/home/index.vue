<template>
    <game-menu
        main-menu
        :is-loading="false"
    >
        <!-- Title -->
        <template v-slot:title>
            {{ $t('homepage.index.title') }}
        </template>

        <home-content/>
    </game-menu>
</template>

<script>
    import { GameMenu } from './../../components/gamemenu';
    import HomeContent from './content';

    export default {
        name: "pages-home-index",

        components: {
            GameMenu,
            HomeContent,
        },
    }
</script>
