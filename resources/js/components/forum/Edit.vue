<template>
    <v-flex>
        <v-form ref="form" @submit.prevent="update">
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
            <v-card-actions>
                <v-btn icon small type="submit">
                    <v-icon color="teal">save</v-icon>
                </v-btn>
                <v-btn icon small @click="cancel">
                    <v-icon>cancel</v-icon>
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-flex>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                form: {
                    title: null,
                    category_id: null,
                    body: null
                },
                categories: null
            }
        },
        methods: {
            async getCategories() {
                try {
                    const response = await axios.get('/api/category')
                    this.categories = response.data.data
                } catch (e) {
                    console.log(e)
                }
            },
            async update() {
                try {
                    const response = await axios.put(`/api${this.question.path}`, this.form)
                    this.$emit('edited', response.data.data)
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            },
            cancel() {
                this.$emit('cancel')
            }
        },
        created() {
            this.getCategories()

            this.form.title = this.question.title
            this.form.category_id = this.question.category.id
            this.form.body = this.question.body
        }
    }
</script>
