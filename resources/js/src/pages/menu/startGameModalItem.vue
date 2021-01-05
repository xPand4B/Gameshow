<template>
    <v-list-item>
        <v-list-item-content class="py-0">
            <v-list-item-title>
                <v-row>
                    <v-col class="py-0">
                        {{ text }}
                    </v-col>
                    <v-col
                        :class="[success ? 'green--text' : null, warning ? 'orange--text' : null, danger ? 'red--text' : null]"
                        class="py-0"
                    >
                        {{ value }}
                    </v-col>
                </v-row>
            </v-list-item-title>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
    export default {
        name: "pages-menu-startGameModal-item",

        props: {
            text: {
                type: String,
                required: true
            },
            value: {
                type: String,
                required: true
            },
            success: {
                type: Boolean,
                default: false
            },
            warning: {
                type: Boolean,
                default: false
            },
            danger: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped lang="scss">
    .v-list-item {
        min-height: 30px;
    }
</style>
