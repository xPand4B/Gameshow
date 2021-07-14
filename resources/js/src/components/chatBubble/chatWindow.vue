<template>
    <v-row class="chat-window">
        <v-col class="white rounded-tr-xl rounded-bl-xl elevation-5">
            <v-row>
                <v-col>
                    <div
                        class="chat"
                        v-chat-scroll="{always: false, smooth: true}"
                    >
                        <div
                            v-for="(message, index) in getChatMessages"
                            :key="index"
                            class="messages"
                            :class="(getPlayerName === message.user && getPlayerId === message.user_id ) ? 'mine' : 'yours'"
                        >
                            <div
                                class="message"
                                :style="stringToHslColor( message.user.repeat(message.user_id))"
                            >
                                <i
                                    v-if="message.is_gamemaster"
                                    class="fas fa-crown fa-sm"
                                />

                                <strong>{{ message.user }}</strong>
                                <small>{{ message.time }}</small>
                                <br>
                                {{ message.message }}
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <v-row>
                <v-col class="pb-0">
                    <v-text-field
                        v-model="newMessage"
                        @keydown="sendTypingEvent"
                        @keyup.enter="sendMessage"
                        :hint="activeUser ? `${activeUser} is typing...` : null"
                        placeholder="Write something..."
                        persistent-hint
                        dense
                        outlined
                        rounded
                        :append-outer-icon="'fas fa-paper-plane'"
                        @click:append-outer="sendMessage"
                    />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "chat-bubble-window",

        data: () => ({
            chatChannel: null,
            messages: [],
            newMessage: '',
            activeUser: false,
            typingTimer: false,
        }),

        watch: {
            getJoinedSuccessfully: {
                handler: function(newValue, oldValue) {
                    if (newValue !== true) {
                        return;
                    }

                    this.chatChannel = `Game.${this.$route.params.id}.Chat`;

                    Echo.join(this.chatChannel)
                        .listenForWhisper('newMessage', message => {
                            this.pushChatMessage(message);
                        });

                    Echo.join(this.chatChannel)
                        .listenForWhisper('typing', user => {
                            this.activeUser = user;

                            if (this.typingTimer) {
                                clearTimeout(this.typingTimer);
                            }

                            this.typingTimer = setTimeout(() => {
                                this.activeUser = false;
                            }, 3000);
                        });
                },
                immediate: true
            }
        },

        computed: {
            ...mapGetters([
                'getPlayerName',
                'getPlayerId',
                'isGamemaster',
                'getChatMessages',
                'getJoinedSuccessfully'
            ])
        },

        methods: {
            ...mapActions([
                'pushChatMessage'
            ]),

            sendTypingEvent() {
                Echo.join(this.chatChannel)
                    .whisper('typing', this.getPlayerName);
            },

            sendMessage() {
                if (this.messageIsBlank()) {
                    return;
                }

                const date = new Date();
                const data = {
                    user: this.getPlayerName,
                    user_id: this.getPlayerId,
                    is_gamemaster: this.isGamemaster,
                    message: this.newMessage,
                    time: `${ ('0'+date.getHours()).slice(-2)}:${ ('0'+date.getMinutes()).slice(-2)}`
                };

                this.pushChatMessage(data);

                Echo.join(this.chatChannel)
                    .whisper('newMessage', data);

                this.newMessage = '';
            },

            messageIsBlank() {
                return (!this.newMessage || /^\s*$/.test(this.newMessage));
            },

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

                return `background: hsl(${hue}, ${saturation}%, ${lightness}%);`;
            },
        }
    }
</script>

<style scoped lang="scss">
    .chat-window {
        position: absolute;
        z-index: 1;
        height: 100px;
        bottom: 540px;
        right: 40px;
        width: 400px;
    }

    .chat {
        height: 400px;
        overflow-y: scroll;
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .messages {
        display: flex;
        flex-direction: column;
    }

    .message {
        border-radius: 20px;
        padding: 8px 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        display: inline-block;
    }

    .yours {
        align-items: flex-start;
    }

    .yours .message {
        margin-right: 25%;
        background-color: #B0BEC5;
        position: relative;
    }

    .yours .message.last:before {
        content: "";
        position: absolute;
        z-index: 0;
        bottom: 0;
        left: -7px;
        height: 20px;
        width: 20px;
        background: #B39DDB;
        border-bottom-right-radius: 15px;
    }
    .yours .message.last:after {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: 0;
        left: -10px;
        width: 10px;
        height: 20px;
        background: white;
        border-bottom-right-radius: 10px;
    }

    .mine {
        align-items: flex-end;
    }

    .mine .message {
        //color: white;
        margin-left: 25%;
        //background: linear-gradient(to bottom, #00D0EA 0%, #0085D1 100%) fixed;
        background: #7E57C2;
        position: relative;
    }

    .mine .message.last:before {
        content: "";
        position: absolute;
        z-index: 0;
        bottom: 0;
        right: -8px;
        height: 20px;
        width: 20px;
        background: linear-gradient(to bottom, #00D0EA 0%, #0085D1 100%) fixed;
        border-bottom-left-radius: 15px;
    }

    .mine .message.last:after {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: 0;
        right: -10px;
        width: 10px;
        height: 20px;
        background: white;
        border-bottom-left-radius: 10px;
    }
</style>
