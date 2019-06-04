<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
        <v-form ref="form" @submit.prevent="signUp">
            <v-text-field
                type="text"
                v-model="form.name"
                v-validate="'required'"
                :error-messages="errors.collect('name')"
                label="Name"
                data-vv-name="name"
                required
                autofocus
            ></v-text-field>
            <v-text-field
                type="email"
                v-model="form.email"
                v-validate="'required|email'"
                :error-messages="errors.collect('email')"
                label="E-mail"
                data-vv-name="email"
                required
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
            <v-btn color="blue" type="submit">Sign Up</v-btn>

            <router-link to="/login">
                <v-btn flat>Login</v-btn>
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
                    name: null,
                    email: null,
                    password: null
                },
                routeAfterLogin: { name: 'forum.index' }
            }
        },
        methods: {
            signUp() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        User.signup(this.form).then(() => {
                            this.$router.push(this.routeAfterLogin)
                        })
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

<style scoped>

</style>