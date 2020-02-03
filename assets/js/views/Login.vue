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
                    <v-spacer/>
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
                                v-model="email"
                                name="login"
                                prepend-icon="person"
                                type="text"
                        />

                        <v-text-field
                                id="password"
                                v-model="password"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                type="password"
                        />
                        <div v-if="hasError" class="error--text">
                            Error: wrong email or password
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <router-link to="registration">Registration</router-link>
                    <v-spacer/>
                    <v-btn
                            color="primary"
                            @click="performLogin()"
                    >
                        Log In
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                email: "",
                password: ""
            };
        },
        computed: {
            isLoading() {
                return this.$store.getters['security/isLoading'];
            },
            hasError() {
                return this.$store.getters['security/hasError'];
            },
            error() {
                return this.$store.getters['security/error'];
            }
        },
        async created() {
            let redirect = this.$route.query.redirect;

            if (this.$store.getters['security/isAuthenticated']) {
                if (typeof redirect !== 'undefined') {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({path: '/feed'});
                }
            }
        },
        methods: {
            async performLogin() {
                let payload = {email: this.$data.email, password: this.$data.password},
                    redirect = this.$route.query.redirect;

                await this.$store.dispatch('security/login', payload);
                if (!this.$store.getters['security/hasError']) {
                    if (typeof redirect !== 'undefined') {
                        this.$router.push({path: redirect});
                    } else {
                        this.$router.push({path: '/feed'});
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>