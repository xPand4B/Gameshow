<template>
    <div class="w-100">
        <v-row class="h-60">
            <!-- Management -->
            <v-col
                cols="5"
                class="red"
            >
                Management
                <ul>
                    <li>Mark current player</li>
                    <li>Manual Points</li>
                </ul>
            </v-col>

            <!-- Question + Answers + Correct one -->
            <v-col class="blue">
                Question + Answers + Correct one
            </v-col>
        </v-row>

        <!-- Player over-view -->
        <v-row class="h-40">
            <v-col
                cols="12"
                class="orange"
            >
                Player over-view
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "pages-game-gamemaster",

        data: () => ({

        })
    }
</script>

<style scoped lang="scss">
    .w-100 {
        width: 100vw;
    }

    .h-60 {
        height: 60vh;
    }

    .h-40 {
        height: 40vh;
    }
</style>
