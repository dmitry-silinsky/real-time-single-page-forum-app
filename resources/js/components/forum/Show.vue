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
                <v-btn color="teal">5 Replies</v-btn>
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
        }
    }
</script>
