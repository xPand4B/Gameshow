<template>
    <v-row>
        <v-slide-y-transition group>
            <v-chip
                v-for="(user, index) in getLobbyUser"
                :key="`lobby.user.${index}`"
                class="ma-2"
                :style="stringToHslColor(user.text)"
            >
                <i
                    v-if="user.isGamemaster"
                    class="fas fa-crown fa-sm pr-2"
                />

                <template v-if="getPlayerName !== user.text">
                    {{ user.text }}
                </template>
                <template v-else>
                    <strong>{{ user.text }}</strong>
                </template>
            </v-chip>
        </v-slide-y-transition>
    </v-row>
</template>

<script>
    import { mapGetters } from "vuex";

    export default {
        name: "game-menu-playerListing",

        computed: {
            ...mapGetters([
                'getLobbyUser',
                'getPlayerName'
            ]),
        },

        methods: {
            /**
             * @link https://medium.com/@pppped/compute-an-arbitrary-color-for-user-avatar-starting-from-his-username-with-javascript-cd0675943b66
             *
             * @param str - hue parameter
             * @param saturation - a number between 0 and 100
             * @param lightness - a number between 0 and 100
             * @returns {string}
             */
            stringToHslColor(str, saturation = 60, lightness = 70) {
                let hash = 0;

                for (let i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }

                const hue = hash % 360;

                return `background-color: hsl(${hue}, ${saturation}%, ${lightness}%); !important`;
            },
        }
    }
</script>

