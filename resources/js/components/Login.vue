<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
                <v-form ref="form" @submit.prevent="submit">
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
                            type="password"
                            v-model="form.password"
                            v-validate="'required|min:6'"
                            :error-messages="errors.collect('password')"
                            label="Password"
                            data-vv-name="password"
                            required
                    ></v-text-field>
                    <v-btn color="green" type="submit">Submit</v-btn>
                </v-form>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                valid: true,
                form: {
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            submit() {
                if (this.$validator.validateAll()) {
                    axios.post('/api/auth/login', this.form)
                        .then(response => {
                            console.log(response.data)
                        })
                        .catch(error => {
                            if (error.response) {
                                console.log(error.response.data)
                            }
                        })
                }
            }
        }
    }
</script>

<style scoped>

</style>