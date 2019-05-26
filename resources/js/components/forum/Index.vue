<template>
    <div>
        <v-flex xs8>
            <question v-for="question in questions"
                      :question="question"
                      :key="question.path"></question>
        </v-flex>
        <v-flex xs4>
            sidebar
        </v-flex>
    </div>
</template>

<script>
    import Question from './Question'

    export default {
        data() {
            return {
                questions: []
            }
        },
        components: {
            Question
        },
        methods: {
            async getAllQuestions() {
                try {
                    let response = await axios.get('/api/question')
                    this.questions = null
                    this.questions = response.data.data
                } catch (e) {
                    console.log(e)
                }
            }
        },
        created() {
            this.getAllQuestions()
        },
        mounted() {
        }
    }
</script>
