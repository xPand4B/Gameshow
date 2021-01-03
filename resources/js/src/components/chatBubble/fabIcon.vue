<template>
    <div>
        <v-slide-y-transition
            hide-on-leave
            mode="out-in"
        >
            <v-icon
                v-if="!fab"
                v-text="'fas fa-comments'"
            />
        </v-slide-y-transition>

        <v-slide-y-reverse-transition
            hide-on-leave
            mode="out-in"
        >
            <v-icon
                v-if="fab"
                v-text="'fas fa-times'"
            />
        </v-slide-y-reverse-transition>
    </div>
</template>

<script>
    export default {
        name: "chat-bubble-fab-icon",

        props: {
            fab: {
                type: Boolean,
                required: true
            }
        }
    }
</script>
