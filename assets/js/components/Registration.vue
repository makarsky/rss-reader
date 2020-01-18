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
                    <v-toolbar-title>Registration form</v-toolbar-title>
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
                        <v-text-field
                                id="password"
                                label="Repeat Password"
                                name="password2"
                                prepend-icon="lock"
                                type="password"
                        />
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <router-link to="login">Log In</router-link>
                    <v-spacer/>
                    <v-btn color="primary">Register</v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Registration'
    }
</script>

<style scoped>

</style>