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
                                v-model="email"
                                name="email"
                                prepend-icon="person"
                                type="text"
                        />
                        <v-text-field
                                id="password"
                                v-model="plainPassword"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                type="password"
                        />
                        <div v-if="hasError" class="error--text">
                            {{ error }}
                        </div>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <router-link to="login">Log In</router-link>
                    <v-spacer/>
                    <v-btn
                            color="primary"
                            @click="register()"
                    >
                        <v-progress-circular
                                v-if="isLoading"
                                :size="20"
                                indeterminate
                        />
                        Register
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Registration',
        data() {
            return {
                email: '',
                plainPassword: '',
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
            await this.$store.dispatch('security/resetState');
        },
        methods: {
            async register() {
                let payload = {
                    email: this.$data.email,
                    plainPassword: this.$data.plainPassword,
                };

                await this.$store.dispatch('security/register', payload);

                if (!this.$store.getters['security/hasError']) {
                    this.$router.push({path: '/login'});
                }
            }
        }
    }
</script>

<style scoped>

</style>