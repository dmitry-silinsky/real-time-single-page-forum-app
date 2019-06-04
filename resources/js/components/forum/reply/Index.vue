<template>
    <v-flex>
        <v-container>
            <reply v-for="(reply, index) in replies"
                   :key="index"
                   :questionSlug="question.slug"
                   :index="index"
                   :reply="reply"
                   @destroyed="removeReply"></reply>
        </v-container>
    </v-flex>
</template>

<script>
    import Reply from './Show'

    export default {
        components: { Reply },
        props: ['question'],
        data() {
            return {
                replies: this.question.replies
            }
        },
        methods: {
            removeReply(index) {
                this.question.replies.splice(index, 1)
                EventBus.$emit('reply-removed', { slug: this.question.slug })
            }
        },
        created() {
            Echo.private(`App.Models.User.${User.id()}`).notification((notification) => {
                this.replies.unshift(notification.reply)
            })

            Echo.channel('delete-reply-channel').listen('DeleteReplyEvent', (event) => {
                for (let i = 0; i < this.replies.length; i++) {
                    if (this.replies[i].id === event.id) {
                        this.replies.splice(i, 1)
                    }
                }
            })
        }
    }
</script>
