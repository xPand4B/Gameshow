<template>
    <v-tab>
        <v-row>
            <!-- Icon -->
            <v-col cols="3">
                <i :class="icon"></i>
            </v-col>

            <!-- Text -->
            <v-col class="my-auto">
                {{ text }}
            </v-col>
        </v-row>
    </v-tab>
</template>

<script>
    export default {
        name: "settings-tab",

        props: {
            icon: {
                type: String,
                default: null
            },
            text: {
                type: String,
                required: true
            }
        }
    }
</script>

