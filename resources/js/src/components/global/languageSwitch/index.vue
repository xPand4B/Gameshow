<template>
    <v-select
        v-model="$i18n.locale"
        @change="onLanguageChange"
        :items="languages"
        item-text="name"
        item-value="ISO"
        :label="$t('general.form.language.label')"
        :dense="dense"
        outlined
    />
</template>

<script>
    import i18n from '../../../snippets';

    export default {
        name: "language-switch",

        props: {
            dense: {
                type: Boolean,
                default: false
            }
        },

        data: () => ({
            selected: i18n.locale,
            languages: []
        }),

        mounted() {
            for (const [ISO, value] of Object.entries(i18n.messages)) {
                this.languages.push({
                    ISO: ISO,
                    name: value.language
                });
            }
        },

        methods: {
            onLanguageChange() {
                this.selected = i18n.locale;
                localStorage.setItem('locale', this.selected);
            }
        }
    }
</script>
