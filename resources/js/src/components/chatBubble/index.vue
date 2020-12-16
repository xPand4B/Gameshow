<template>
    <div>
        <!-- Chat Window -->
        <v-slide-y-reverse-transition>
            <chat-bubble-window v-if="fab"/>
        </v-slide-y-reverse-transition>

        <!-- Chat Bubble Floating Button -->
        <v-btn
            v-show="show"
            @click="fab = !fab"
            class="mb-16 mr-5"
            large
            :color="color"
            :dark="dark"
            absolute
            bottom
            right
            fab
        >
<!--            <v-badge-->
<!--                color="green"-->
<!--                content="1"-->
<!--            >-->
                <v-icon
                    v-if="fab"
                    v-text="'fas fa-times'"
                />
                <v-icon
                    v-else
                    v-text="'fas fa-comments'"
                />
<!--            </v-badge>-->
        </v-btn>
    </div>
</template>

<script>
    import ChatBubbleWindow from './chatWindow';

    export default {
        name: "chat-bubble-index",

        components: {
            ChatBubbleWindow,
        },

        props: {
            color: {
                type: String,
                default: 'deep-purple lighten-1'
            },
            dark: {
                type: Boolean,
                default: true
            }
        },

        data: () => ({
            show: false,
            fab: false,
        }),

        watch: {
            $route: {
                handler: function(to, from) {
                    if (! this.$route.name.includes('gameshow.home')) {
                        this.show = true;
                    }
                },
                immediate: true
            }
        }
    }
</script>
