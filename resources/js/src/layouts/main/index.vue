<template>
    <div class="fullscreen bg-gradient-blue">
        <v-container fill-height>
            <v-row>
                <v-col class="offset-sm-1 col-sm-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6 offset-xl-4 col-xl-4">
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

            <!-- Chat Bubble-->
            <chat-bubble/>

        </v-container>
    </div>
</template>

<script>
    import ChatBubble from './../../components/chatBubble';

    export default {
        name: "layout-main",

        components: {
            ChatBubble,
        },
    }
</script>

<style scoped lang="scss">
    .fullscreen {
        height: 100%;
        width: 100vw;
    }
</style>
