<template>
    <v-btn
        @click="changeRoute(routeName)"
        class="mb-8"
        color="indigo"
        elevation="2"
        block
        x-large
        outlined
    >
        <i
            v-if="icon"
            :class="icon"
            class="pr-2"
        />
        {{ text }}
    </v-btn>
</template>

<script>
    export default {
        name: "game-menu-buttons",

        data: () => ({
            gameId: null,
        }),

        props: {
            routeName: {
                type: String,
                required: true
            },
            text: {
                type: String,
                required: true
            },
            icon: {
                type: String,
                default: null
            }
        },

        created() {
            this.gameId = this.$route.params.id;
        },

        methods: {
            changeRoute(name) {
                this.$router.push({
                    name,
                    params: {
                        id: this.gameId
                    }
                });
            },
        }
    }
</script>
