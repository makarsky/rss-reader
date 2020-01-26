<template>
    <v-row>
        <v-col>
            <div>
                <div>Top 10 frequent words:</div>
                <v-chip-group column>
                    <v-chip v-for="(number, word) in frequentWords" v-bind:key="word">
                        {{word}} ({{number}})
                    </v-chip>
                </v-chip-group>
            </div>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'FrequentWords',
        props: {
            frequentWords: Object,
        },
    }
</script>

<style scoped>
</style>