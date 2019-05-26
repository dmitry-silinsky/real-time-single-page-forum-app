<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
            <v-form ref="form" @submit.prevent="login">
                <v-text-field
                        type="email"
                        v-model="form.email"
                        v-validate="'required|email'"
                        :error-messages="errors.collect('email')"
                        label="E-mail"
                        data-vv-name="email"
                        required
                        autofocus
                ></v-text-field>
                <v-text-field
                        :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                        :type="showPassword ? 'text' : 'password'"
                        v-model="form.password"
                        v-validate="'required|min:6'"
                        :error-messages="errors.collect('password')"
                        label="Password"
                        data-vv-name="password"
                        hint="At least 6 characters"
                        required
                        @click:append="showPassword = !showPassword"
                ></v-text-field>
                <v-btn color="green" type="submit">Login</v-btn>

                <router-link to="/signup">
                    <v-btn flat>Sign Up</v-btn>
                </router-link>
            </v-form>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data() {
            return {
                showPassword: false,
                valid: true,
                form: {
                    email: null,
                    password: null
                },
                routeAfterLogin: { name: 'forum.index' }
            }
        },
        methods: {
            login() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        User.login(this.form)
                        EventBus.$emit('login')
                        this.$router.push(this.routeAfterLogin)
                    }
                })
            }
        },
        created() {
            if (User.loggedIn()) {
                this.$router.push(this.routeAfterLogin)
            }
        }
    }
</script>
