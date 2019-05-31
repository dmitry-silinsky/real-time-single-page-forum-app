<template>
    <v-card class="mt-3">
        <v-card-title>
            <div class="headline">{{ reply.user.name }}</div>
            <div class="ml-2">said {{ reply.created_at }}</div>
        </v-card-title>
        <v-divider></v-divider>

        <edit-reply v-if="editing"
                    :reply="reply"
                    :question-slug="questionSlug"
                    @cancel="editing = false"
                    @updated="update"></edit-reply>

        <v-card-text v-else v-html="reply.body"></v-card-text>
        <template v-if="own && !editing">
            <v-card-actions>
                <v-btn icon small @click="editing = true">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon color="red" @click="destroy">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </template>
    </v-card>
</template>

<script>
    import EditReply from './Edit'

    export default {
        components: { EditReply },
        props: ['reply', 'index', 'questionSlug'],
        data() {
            return {
                editing: false
            }
        },
        computed: {
            own() {
                return User.own(this.reply.user.id)
            }
        },
        methods: {
            async destroy() {
                await axios.delete(`/api/question/${this.questionSlug}/reply/${this.reply.id}`)
                this.$emit('destroyed', this.index)
            },
            update(payload) {
                this.reply.body = payload
                this.editing = false
            }
        }
    }
</script>
