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
                v-if="loading"
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
                class="pb-0 px-6"
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

        <!-- Custom Card -->
        <v-fade-transition mode="out-in">
            <div
                v-if="loading && customCard && !mainMenu"
                class="text-center py-5"
            >
                <v-progress-circular
                    indeterminate
                    color="deep-purple lighten-1"
                    :size="70"
                    :width="7"
                />
            </div>
            <slot v-else/>
        </v-fade-transition>

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
    import ApiRoutes from "../../routes/apiRoutes";

    export default {
        name: "game-menu",

        components: {
            PlayerListing,
        },

        data: () => ({
            ApiRoutes,
            loading: true,
            gameId: null,
            joinUrl: ''
        }),

        props: {
            mainMenu: {
                type: Boolean,
                default: false
            },
            customCard: {
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

        beforeMount() {
            if (this.mainMenu) {
                return;
            }

            this.fetchMe();
        },

        watch: {
            isLoading: {
                handler: function(newVal, oldVal) {
                    if (!newVal && oldVal) {
                        this.initValues();
                    }
                },
                deep: true,
                immediate: true,
            },
            mainMenu: {
                handler: function(newVal, oldVal) {
                    if (!newVal && oldVal) {
                        this.fetchMe();
                    }
                },
                deep: true,
                immediate: true,
            },
        },

        computed: {
            ...mapGetters([
                'getPlayerLoginSuccess'
            ])
        },

        methods: {
            ...mapActions([
                'fetchSingleGameData',
                'setPlayerName',
                'loginPlayer',
                'lobbyInit',
                'lobbyJoined',
                'lobbyLeft',
            ]),

            fetchMe() {
                axios.get(ApiRoutes.v1.auth.me)
                    .then(response => {
                        if (response.data.success) {
                            this.fetchSingleGameData(this.$route.params.id).then(() => {
                                this.setPlayerName(response.data.playerName);
                                this.initValues();
                            })
                            return;
                        }

                        this.enterPlayerName();

                    }).catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                });
            },

            enterPlayerName() {
                Swal.fire({
                    icon: 'question',
                    title: "What's your username?",
                    input: 'text',
                    allowOutsideClick: false,
                    preConfirm: (input) => {
                        if (!!!input) {
                            Swal.showValidationMessage(
                                this.$t('validation.required')
                            );
                        } else if (input.length > 20) {
                            Swal.showValidationMessage(
                                this.$t('validation.max-chars', { num: 20 })
                            );
                        }
                    }
                }).then(playerName => {
                    // console.log(playerName.value.toString());
                    this.loginPlayer(playerName.value.toString()).then(() => {
                        this.fetchMe();
                    });
                });
            },

            initValues() {
                this.gameId  = this.$route.params.id;
                this.joinUrl = `${document.location.origin}/${this.gameId}`;
                this.loading = false;

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
