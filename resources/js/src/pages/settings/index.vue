<template>
    <game-menu back-link="gameshow.menu.index">

        <!-- Title-->
        <template v-slot:title>
            {{ $t('settings.title') }}
        </template>

        <!-- Content -->
        <settings-content/>
    </game-menu>
</template>

<script>
    import { GameMenu } from './../../components/gamemenu';
    import SettingsContent from './content';

    export default {
        name: "pages-settings-index",

        components: {
            GameMenu,
            SettingsContent,
        },
    }
</script>
