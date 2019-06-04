<template>
    <v-flex>
        <v-card v-if="question">
            <v-card-title>
                <div>
                    <div class="headline">
                        {{ question.title }} <small class="grey--text">category: {{ question.category.name }}</small>
                    </div>
                    <span class="grey--text">{{ question.user.name }} said {{ question.created_at }}</span>
                </div>
                <v-spacer></v-spacer>
                <v-btn color="teal" dark>Replies: {{ repliesCount }}</v-btn>
            </v-card-title>
            <v-card-text v-html="question.body"></v-card-text>
            <v-card-actions v-if="own">
                <v-btn icon small @click="startEditing">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon small @click="destroy">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                repliesCount: 0
            }
        },
        computed: {
            own() {
                return User.own(this.question.user.id)
            }
        },
        methods: {
            startEditing() {
                this.$emit('editing')
            },
            async destroy() {
                try {
                    axios.delete(`/api/question/${this.question.slug}`)
                    this.$router.push({ name: 'forum.index' })
                } catch (e) {
                    console.log(e.response.data)
                }
            }
        },
        created() {
            EventBus.$on('reply-created', (payload) => {
                if (this.question.slug === payload.slug) {
                    this.repliesCount++
                }
            })

            Echo.private(`App.Models.User.${User.id()}`).notification((notification) => {
                this.repliesCount++
            })

            EventBus.$on('reply-removed', (payload) => {
                if (this.question.slug === payload.slug) {
                    this.repliesCount--
                }
            })

            Echo.channel('delete-reply-channel').listen('DeleteReplyEvent', (event) => {
                this.repliesCount--
            })
        },
        watch: {
            question(value) {
                this.repliesCount = value.replies.length
            }
        }
    }
</script>
