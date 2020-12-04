<template>
    <div class="fullscreen bg-gradient-blue">
        <v-container fill-height>
            <v-row>
                <v-col class="offset-sm-1 col-sm-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6">
                    <!-- Card -->
                    <v-card
                        elevation="3"
                        shaped
                    >
                        <v-fade-transition mode="out-in">
                            <router-view/>
                        </v-fade-transition>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
    export default {
        name: "layout-main",
    }
</script>

<style scoped lang="scss">
    .fullscreen {
        height: 100vh;
        width: 100vw;
    }
</style>
