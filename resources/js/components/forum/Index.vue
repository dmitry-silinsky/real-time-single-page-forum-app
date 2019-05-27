<template>
    <v-layout>
        <v-flex xs8>
            <question v-for="question in questions"
                      :question="question"
                      :key="question.path"></question>
        </v-flex>
        <v-flex xs4 class="ml-4">
            <app-sidebar></app-sidebar>
        </v-flex>
    </v-layout>
</template>

<script>
    import Question from './Question'
    import AppSidebar from './AppSidebar'

    export default {
        data() {
            return {
                questions: []
            }
        },
        components: { Question, AppSidebar },
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
