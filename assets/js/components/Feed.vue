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
            <v-row>
                <v-col>
                    <v-card class="elevation-12">
                        <v-toolbar flat>
                            <v-toolbar-title>Article</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            Summary
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <router-link to="login">Read on</router-link>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card class="elevation-12">
                        <v-toolbar flat>
                            <v-toolbar-title>Article</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            Summary
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <router-link to="login">Read on</router-link>
                        </v-card-actions>
                    </v-card>
                </v-col>yarn.lock
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Feed'
    }
</script>

<style scoped>

</style>