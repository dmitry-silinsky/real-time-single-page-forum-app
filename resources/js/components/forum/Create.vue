<template>
    <v-flex>
        <v-form ref="form" @submit.prevent="create">
            <v-text-field
                    type="text"
                    v-model="form.title"
                    v-validate="'required'"
                    :error-messages="errors.collect('title')"
                    label="Title"
                    data-vv-name="title"
                    required
                    autofocus
            ></v-text-field>
            <v-autocomplete
                    v-model="form.category_id"
                    :items="categories"
                    v-validate="'required'"
                    :error-messages="errors.collect('category')"
                    item-text="name"
                    item-value="id"
                    :readonly="false"
                    data-vv-name="category"
                    label="Category"
            ></v-autocomplete>
            <v-textarea
                    name="body"
                    label="Text"
                    v-model="form.body"
                    v-validate="'required'"
                    :error-messages="errors.collect('body')"
                    data-vv-name="body"
                    hint="Your question"
            ></v-textarea>
            <v-btn color="green" type="submit">Create</v-btn>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: null,
                    category_id: null,
                    body: null
                },
                categories: [],
                creatingError: null
            }
        },
        methods: {
            async create() {
                try {
                    this.$validator.validateAll().then(result => {
                        if (result) {
                            axios.post('/api/question', this.form)
                                .then(response => {
                                    this.$router.push(response.data.data.path)
                                })
                                .catch(error => {
                                    if (error.response) {
                                        console.log(error.response.data)
                                    }
                                })
                        }
                    })
                } catch (e) {
                    this.creatingError = e.response.data.error
                }
            }
        },
        async created() {
            try {
                const response = await axios.get('/api/category')
                this.categories = response.data.data
            } catch (e) {
                console.log(e)
            }
        }
    }
</script>
