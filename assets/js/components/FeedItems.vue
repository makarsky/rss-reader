<template>
    <div>
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
    </div>
</template>

<script>
    export default {
        name: 'FeedItems',
        props: {
            feedItems: [],
        },
    }
</script>

<style scoped>
</style>