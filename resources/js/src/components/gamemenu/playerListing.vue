<template>
    <v-row>
        <v-slide-y-transition group>
            <v-chip
                v-for="(user, index) in getLobbyUser"
                :key="`lobby.user.${index}`"
                class="ma-2"
                color="primary"
                :outlined="getCurrentPlayerName !== user.text"
            >
                <i
                    v-if="user.isGamemaster"
                    class="fas fa-crown fa-sm pr-2"
                />
                {{ user.text }}
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
                'getCurrentPlayerName'
            ]),
        },
    }
</script>

