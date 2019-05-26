<template>
    <v-layout>
        <edit v-if="editing" :question="question" @edited="update" @cancel="editing = false"></edit>
        <show v-else :question="question" @editing="editing = true"></show>
    </v-layout>
</template>

<script>
    import Show from './Show'
    import Edit from './Edit'

    export default {
        components: { Show, Edit },
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
