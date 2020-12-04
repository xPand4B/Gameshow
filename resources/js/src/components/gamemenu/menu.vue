<template>
    <div>
        <!-- Title-->
        <div class="rounded-tl-xl pl-10 deep-purple lighten-1 white--text">
            <!-- Title-->
            <v-card-title class="text-h3 px-0">
                <slot name="title">
                    !!! Missing title !!!
                </slot>

                <br>
            </v-card-title>
        </div>

        <!-- Text -->
        <v-card-text
            v-if="!customCard"
            class="mx-auto"
        >
            <div
                v-if="isLoading || loading"
                class="text-center"
            >
                <v-progress-circular
                    indeterminate
                    color="deep-purple lighten-1"
                    :size="70"
                    :width="7"
                />
            </div>
            <v-container
                v-else
                class="pb-0"
            >
                <slot name="content"/>

                <!-- Copy Game URL -->
                <v-container v-if="withCopyLink">
                    <v-row>
                        <v-col
                            cols="9"
                            class="px-0 pb-0"
                        >
                            <v-text-field
                                v-model="joinUrl"
                                ref="joinUrl"
                                :label="$t('menu.general.copy.label')"
                                outlined
                                dense
                                disabled
                                aria-disabled="true"
                            />
                        </v-col>

                        <v-col class="px-0">
                            <v-btn
                                class="ml-4"
                                color="info"
                                v-clipboard="joinUrl"
                                @success="handleCopySuccess"
                                block
                            >
                                <i class="fas fa-copy pr-2"/>
                                {{ $t('menu.general.copy.buttonText') }}
                            </v-btn>
                        </v-col>
                    </v-row>

                    <!-- Player-Listing -->
                    <div>
                        <v-divider class="pb-3"/>

                        <player-listing/>
                    </div>
                </v-container>

            </v-container>
        </v-card-text>

        <slot/>

        <!-- Actions -->
        <v-card-actions
            v-if="backLink"
            class="grey lighten-2 rounded-br-xl"
        >
            <v-btn
                @click="changeRoute('gameshow.menu.index')"
                text
            >
                <i class="fas fa-2x fa-caret-left pr-3"></i>
                {{ $t('navigation.back') }}
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import PlayerListing from './playerListing';

    export default {
        name: "game-menu",

        components: {
            PlayerListing,
        },

        data: () => ({
            loading: false,
            gameId: null,
            joinUrl: ''
        }),

        props: {
            isLoading: {
                type: Boolean,
                default: false
            },
            customCard: {
                type: Boolean,
                default: false
            },
            fetchGame: {
                type: Boolean,
                default: false
            },
            withCopyLink: {
                type: Boolean,
                default: false
            },
            backLink: {
                type: String,
                default: null
            }
        },

        created() {
            if (!this.fetchGame) {
                return;
            }

            this.loading = true;
            this.gameId = this.$route.params.id;

            this.$store.dispatch('fetchSingleGameData', this.gameId).then(() => {
                this.joinUrl = `${document.location.origin}/${this.gameId}`;

                this.loading = false;
            });

            Echo.join(`Game.${this.$route.params.id}.Lobby`)
                .here((users) => {
                    this.lobbyInit(users);
                })
                .joining((user) => {
                    this.lobbyJoined(user);
                })
                .leaving((user) => {
                    this.lobbyLeft(user);
                });
        },

        methods: {
            ...mapActions([
                'lobbyInit',
                'lobbyJoined',
                'lobbyLeft',
            ]),

            handleCopySuccess() {
                Toast.fire({
                    icon: 'success',
                    title: 'Link has been copied!'
                });
            },

            changeRoute(name) {
                this.$router.push({
                    name,
                    params: {
                        id: this.$route.params.id
                    }
                })
            }
        }
    }
</script>
