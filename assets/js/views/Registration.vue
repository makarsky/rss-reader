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
                    <v-form v-model="valid" ref="form" @submit.prevent="register">
                        <v-text-field
                                label="Email"
                                v-model="email"
                                :rules="emailRules"
                                name="email"
                                prepend-icon="person"
                                type="text"
                                @input="checkEmail"
                                required
                        />
                        <v-text-field
                                id="password"
                                v-model="plainPassword"
                                :rules="plainPasswordRules"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                type="password"
                                @input="resetError('plainPassword')"
                                required
                        />
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
                valid: false,
                email: '',
                plainPassword: '',
            };
        },
        computed: {
            isLoading() {
                return this.$store.getters['registration/isLoading'];
            },
            hasRegistrationErrors() {
                return this.$store.getters['registration/hasRegistrationErrors'];
            },
            registrationErrors() {
                return this.$store.getters['registration/registrationErrors'];
            },
            emailRules() {
                return [
                    v => !this.hasRegistrationErrors || !this.registrationErrors.email || this.registrationErrors.email,
                ];
            },
            plainPasswordRules() {
                return [
                    v => !this.hasRegistrationErrors || !this.registrationErrors.plainPassword || this.registrationErrors.plainPassword,
                ];
            },
        },
        methods: {
            async register() {
                let payload = {
                    email: this.$data.email,
                    plainPassword: this.$data.plainPassword,
                };

                await this.$store.dispatch('registration/register', payload);

                if (!this.$store.getters['registration/hasRegistrationErrors']) {
                    this.$router.push({path: '/login'});
                } else {
                    this.$refs.form.validate();
                }
            },
            async checkEmail() {
                await this.$store.dispatch('registration/checkEmail', {email: this.email});
                this.$refs.form.validate();
            },
            async resetError(propName) {
                await this.$store.dispatch('registration/resetError', propName);
                this.$refs.form.validate();
            }
        }
    }
</script>

<style scoped>

</style>