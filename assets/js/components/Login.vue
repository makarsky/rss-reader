<template>
    <v-row
            align="center"
            justify="center"
    >
        <v-col
                cols="12"
                sm="8"
                md="4"
        >
            <v-card class="elevation-12">
                <v-toolbar
                        color="primary"
                        dark
                        flat
                >
                    <v-toolbar-title>Login form</v-toolbar-title>
                    <v-spacer />
                    <v-tooltip>
                        <template v-slot:activator="{ on }">
                            <v-icon>mdi-key</v-icon>
                        </template>
                        <span>Source</span>
                    </v-tooltip>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-text-field
                                label="Email"
                                name="login"
                                prepend-icon="person"
                                type="text"
                        />

                        <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                type="password"
                        />
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <router-link to="registration">Registration</router-link>
                    <v-spacer/>
                    <v-btn color="primary">Log In</v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Login'
    }
</script>

<style scoped>

</style>