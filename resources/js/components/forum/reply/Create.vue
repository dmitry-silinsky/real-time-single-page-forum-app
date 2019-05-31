<template>
    <v-form ref="form" @submit.prevent="submit">
        <v-textarea
                name="body"
                label="Reply text"
                v-model="body"
                v-validate="'required'"
                :error-messages="errors.collect('body')"
                data-vv-name="body"
                outline
        ></v-textarea>
        <v-btn type="submit" color="green" dark class="mt-0">Reply</v-btn>
    </v-form>
</template>

<script>
    export default {
        props: ['questionSlug'],
        data() {
            return {
                body: null
            }
        },
        methods: {
            async submit() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.create()
                    }
                })
            },
            async create() {
                try {
                    const response = await axios.post(`/api/question/${this.questionSlug}/reply`, { body: this.body })
                    this.body = null
                    this.$validator.reset()
                    this.$emit('created', response.data.data)
                    window.scrollTo(0, 0)
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            }
        }
    }
</script>
