<template>
    <div>
        <v-btn icon @click="likeIt">
            <v-icon :color="color">favorite</v-icon>
            <span class="ml-2">{{ count }}</span>
        </v-btn>
    </div>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                liked: this.reply.liked,
                count: this.reply.likes_count
            }
        },
        computed: {
            color() {
                return this.liked ? 'red' : 'red lighten-4'
            }
        },
        methods: {
            likeIt() {
                if (User.loggedIn()) {
                    this.liked ? this.decr() : this.incr()
                    this.liked = !this.liked
                }
            },
            async incr() {
                try {
                    await axios.post(`/api/question/${this.reply.question_slug}/reply/${this.reply.id}/like`)
                    this.count++
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            },
            async decr() {
                try {
                    await axios.delete(`/api/question/${this.reply.question_slug}/reply/${this.reply.id}/unlike`)
                    this.count--
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            }
        },
        created() {
            Echo.channel('like-channel').listen('LikeEvent', (e) => {
                if (this.reply.id === e.replyId) {
                    if (e.type === 'like') {
                        this.count++
                    } else {
                        this.count--
                    }
                }
            })
        }
    }
</script>
