<template>
    <v-form ref="form" @submit.prevent="update" class="ml-2 mr-2 mt-2">
        <v-textarea
                name="body"
                label="Reply text"
                v-model="body"
                v-validate="'required'"
                :error-messages="errors.collect('body')"
                data-vv-name="body"
                outline
                autofocus
        ></v-textarea>
        <v-card-actions>
            <v-btn type="submit" icon small>
                <v-icon color="green">save</v-icon>
            </v-btn>
            <v-btn icon small>
                <v-icon @click="cancel">cancel</v-icon>
            </v-btn>
        </v-card-actions>
    </v-form>
</template>

<script>
    export default {
        props: ['reply', 'questionSlug'],
        data() {
            return {
                body: this.reply.body
            }
        },
        methods: {
            async update() {
                try {
                    await axios.patch(`/api/question/${this.questionSlug}/reply/${this.reply.id}`, {
                        body: this.body
                    })
                    this.$emit('updated', this.body)
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            },
            cancel() {
                this.body = this.reply.body
                this.$emit('cancel')
            }
        }
    }
</script>
