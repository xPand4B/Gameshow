<template>
    <div>
        <!-- Chat Window -->
        <v-slide-y-reverse-transition>
            <chat-bubble-window v-show="fab"/>
        </v-slide-y-reverse-transition>

        <!-- Chat Bubble Floating Button -->
        <v-slide-x-reverse-transition>
            <v-btn
                v-show="show && getJoinedSuccessfully"
                @click="toggleFab()"
                class="mb-16 mr-5"
                large
                :color="color"
                :dark="dark"
                absolute
                bottom
                right
                fab
            >
                <v-badge
                    v-if="unreadMessages"
                    color="green"
                    :content="messageCount"
                >
                    <chat-fab-icon :fab="fab"/>
                </v-badge>

                <chat-fab-icon
                    v-else
                    :fab="fab"
                />
            </v-btn>
        </v-slide-x-reverse-transition>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import ChatBubbleWindow from './chatWindow';
    import ChatFabIcon from './fabIcon';

    export default {
        name: "chat-bubble-index",

        components: {
            ChatBubbleWindow,
            ChatFabIcon,
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
            messageCount: 0,
            unreadMessages: false
        }),

        watch: {
            $route: {
                handler: function(to, from) {
                    if (! this.$route.name.includes('gameshow.home')) {
                        this.show = true;
                    }
                },
                immediate: true
            },

            getJoinedSuccessfully: {
                handler: function(newValue, oldValue) {
                    if (newValue !== true) {
                        return;
                    }

                    this.chatChannel = `Game.${this.$route.params.id}.Chat`;

                    Echo.join(this.chatChannel)
                        .listenForWhisper('newMessage', () => {
                            if (!this.fab) {
                                this.unreadMessages = true;
                                this.messageCount++;
                            }
                        });
                },
                immediate: true
            }
        },

        computed: {
            ...mapGetters([
                'getJoinedSuccessfully'
            ]),
        },

        methods: {
            toggleFab() {
                this.fab = !this.fab;

                if (this.fab) {
                    this.messageCount = 0;
                    this.unreadMessages = false;
                }
            }
        }
    }
</script>
