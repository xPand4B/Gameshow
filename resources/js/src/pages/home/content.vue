<template>
    <v-form v-model="isValid">
        <!-- Text -->
        <v-card-text class="mx-auto">
            <v-container>
                <v-row>
                    <!-- Username -->
                    <v-col class="pb-0">
                        <v-text-field
                            v-on:keyup.enter="onCreateSubmit"
                            v-model="form.username"
                            autoComplete="username"
                            :label="$t('homepage.index.form.username.label')"
                            :hint="$t('homepage.index.form.username.hint')"
                            :rules="[
                                value => !!value || $t('validation.required'),
                                v => v.length <= 20 || $t('validation.max-chars', { num: 20 })
                            ]"
                            counter="20"
                            persistent-hint
                            outlined
                            required
                            aria-required="true"
                        />
                    </v-col>

                    <!-- Language switch -->
                    <v-col
                        cols="4"
                        class="pb-0"
                    >
                        <language-switch class="mb-6"/>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>

        <v-divider/>

        <v-card-actions>
            <v-row>
                <!-- Create new Game -->
                <v-col>
                    <v-btn
                        @click="onCreateSubmit"
                        :disabled="!isValid"
                        color="green darken-1"
                        elevation="3"
                        ripple
                        :dark="isValid"
                        large
                        block
                        rounded
                    >
                        {{ $t('homepage.index.form.create') }}
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-form>
</template>

<script>
    import { mapGetters, mapActions } from "vuex";

    export default {
        name: "pages-home-content",

        data: () => ({
            isValid: false,
            form: {
                username: 'xPand',
            }
        }),

        computed: {
            ...mapGetters(['getCurrentGameId'])
        },

        methods: {
            ...mapActions([
                'loginPlayer',
                'createNewGame',
            ]),

            onCreateSubmit() {
                if (! this.isValid) {
                    return;
                }

                this.loginPlayer(this.form.username).then(() => {
                    this.createNewGame(this.form);
                });
            },
        }
    }
</script>
