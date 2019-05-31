<template>
    <div>
        <edit v-if="editing" :question="question" @edited="update" @cancel="editing = false"></edit>
        <show v-else :question="question" @editing="editing = true"></show>
        <v-container v-if="question">
            <replies :question="question"></replies>
            <new-reply :question-slug="question.slug" @created="addReply"></new-reply>
        </v-container>
    </div>
</template>

<script>
    import Show from './Show'
    import Edit from './Edit'
    import Replies from './reply/Index'
    import NewReply from './reply/Create'

    export default {
        components: { Show, Edit, Replies, NewReply },
        data() {
            return {
                question: null,
                editing: false
            }
        },
        methods: {
            update(payload) {
                for(let prop in payload) {
                    if (payload.hasOwnProperty(prop) && this.question.hasOwnProperty(prop)) {
                        this.question[prop] = payload[prop]
                    }
                }
                this.editing = false
            },
            addReply(payload) {
                this.question.replies.unshift(payload)
            }
        },
        async created() {
            try {
                const response = await axios.get(`/api/question/${this.$route.params.slug}`)
                this.question = response.data.data
            } catch (e) {
                console.log(e)
            }
        }
    }
</script>
