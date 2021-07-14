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

        <!-- Card Text -->
        <v-card-text class="text-center py-0 px-0">
            <v-slide-y-transition
                v-if="!loading && !isLoading"
                mode="out-in"
            >
                <div>
                    <!-- Slot -->
                    <slot/>

                    <!-- Copy Game URL -->
                    <v-container
                        v-if="withCopyLink"
                        class="px-10"
                    >
                        <v-row>
                            <v-col class="col-12 col-sm-7 col-md-8 px-0 py-0">
                                <v-text-field
                                    v-model="joinUrl"
                                    ref="joinUrl"
                                    :label="$t('menu.general.copy.label')"
                                    outlined
                                    dense
                                    disabled
                                    hide-details
                                    aria-disabled="true"
                                />
                            </v-col>

                            <v-col class="col-sm-1 px-0 py-0"/>

                            <v-col class="col-12 col-sm-3 px-0 py-0">
                                <v-btn
                                    color="primary"
                                    v-clipboard="joinUrl"
                                    @success="handleCopySuccess"
                                    dark
                                    block
                                >
                                    <i class="fas fa-copy pr-2"/>
                                    {{ $t('menu.general.copy.buttonText') }}
                                </v-btn>
                            </v-col>
                        </v-row>

                        <!-- Language switch -->
                        <v-row>
                            <v-col class="pt-8 pb-0 px-0">
                                <language-switch dense/>
                            </v-col>
                        </v-row>

                        <!-- Player-Listing -->
                        <div>
                            <v-divider class="pb-3"/>

                            <player-listing/>
                        </div>
                    </v-container>
                </div>
            </v-slide-y-transition>

            <!-- Loading -->
            <v-fade-transition
                v-else
                mode="out-in"
            >
                <!-- Loading -->
                <v-progress-circular
                    class="my-6"
                    color="deep-purple lighten-1"
                    indeterminate
                    :size="70"
                    :width="7"
                />
            </v-fade-transition>

        </v-card-text>

        <!-- Actions -->
        <v-card-actions
            v-if="backLink"
            class="grey lighten-2 rounded-br-xl"
        >
            <v-row>
                <!-- Left -->
                <v-col class="px-0 py-2">
                    <slot name="bottomLeft">
                        <v-btn
                            @click="changeRoute('gameshow.menu.index')"
                            text
                        >
                            <i class="fas fa-2x fa-caret-left pr-3"></i>
                            {{ $t('navigation.back') }}
                        </v-btn>
                    </slot>
                </v-col>

                <!-- Right -->
                <v-col class="px-0 py-0 pr-8 text-right">
                    <slot name="bottomRight"/>
                </v-col>
            </v-row>
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
            dialog: true,
            gameId: null,
            joinUrl: '',
        }),

        props: {
            isLoading: {
                type: Boolean,
                default: false
            },
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
                this.loading = false;
                this.isLoading = false;
                return;
            }

            this.fetchMe();
        },

        watch: {
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
                                if (!this.getPlayerLoginSuccess) {
                                    this.setPlayerName(response.data);
                                }
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
                    this.loginPlayer(playerName.value.toString()).then(() => {
                        this.fetchMe();
                    });
                });
            },

            initValues() {
                this.gameId  = this.$route.params.id;
                this.joinUrl = window.location.href;
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
