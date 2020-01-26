<template>
    <v-row
            align="center"
            justify="center"
    >
        <v-col
                cols="12"
                sm="8"
                md="8"
        >
            <v-row
                    v-if="isLoading"
                    align="center"
                    justify="center"
                    class="grey lighten-5 full-height"
            >
                <div class="text-center">
                    <v-progress-circular
                            :size="50"
                            color="primary"
                            indeterminate
                    />
                </div>
            </v-row>
            <frequent-words
                    v-show="!isLoading"
                    :frequent-words="frequentWords"
            />
            <v-row v-for="feedItem in feedItems" v-bind:key="feedItem.link">
                <v-col>
                    <v-card class="">
                        <v-toolbar flat>
                            <v-toolbar-title>{{feedItem.title}}</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text v-html="feedItem.description">
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <a :href="feedItem.link" target="_blank">Read on</a>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import FrequentWords from '../components/FrequentWords';
    export default {
        name: 'Feed',
        components: {FrequentWords},
        data() {
            return {
                feedItems: [],
                frequentWords: null,
            };
        },
        computed: {
            isLoading() {
                return this.$store.getters['feed/isLoading'];
            },
        },
        async created() {
            let response = await this.$store.dispatch('feed/load');
            this.feedItems = response.feed.items;
            this.frequentWords = response.frequentWords;
        }
    }
</script>

<style scoped>
.full-height {
    height: 80vh;
    background: #C82829;
}
</style>