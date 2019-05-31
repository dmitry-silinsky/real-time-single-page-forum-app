<template>
    <v-flex>
        <v-container>
            <reply v-for="(reply, index) in question.replies"
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
        methods: {
            removeReply(index) {
                this.question.replies.splice(index, 1)
            }
        }
    }
</script>
