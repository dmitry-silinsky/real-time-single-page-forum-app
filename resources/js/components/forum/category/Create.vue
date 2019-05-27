<template>
    <v-flex>
        <h3 v-text="editSlug ? 'Edit Category' : 'New Category'"></h3>
        <v-form ref="form" @submit.prevent="submit">
            <v-text-field
                    type="text"
                    v-model="form.name"
                    v-validate="'required'"
                    :error-messages="errors.collect('name')"
                    label="Name"
                    data-vv-name="name"
                    required
                    autofocus
            ></v-text-field>
            <v-btn color="pink" type="submit" v-if="editSlug">Update</v-btn>
            <v-btn color="teal" type="submit" v-else>Create</v-btn>
        </v-form>

        <v-card class="mt-4">
            <v-toolbar color="indigo" dark dense>
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>
            <v-list>
                <v-list-tile v-for="(category, i) in categories" :key="category.id">
                    <v-list-tile-action>
                        <v-btn icon small @click="edit(i)">
                            <v-icon color="orange">edit</v-icon>
                        </v-btn>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>{{ category.name }}</v-list-tile-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-btn icon small @click="destroy(category.slug, i)">
                            <v-icon color="red">delete</v-icon>
                        </v-btn>
                    </v-list-tile-action>
                </v-list-tile>
                <v-divider></v-divider>
            </v-list>
        </v-card>
    </v-flex>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: null
                },
                categories: [],
                editSlug: null
            }
        },
        methods: {
            submit() {
                if (this.editSlug) {
                    this.update()
                } else {
                    this.create()
                }
            },
            async create() {
                try {
                    const response = await axios.post('/api/category', this.form)
                    this.categories.unshift(response.data.data)
                    this.form.name = null
                    this.$validator.reset()
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            },
            edit(index) {
                this.form.name = this.categories[index].name
                this.editSlug = this.categories[index].slug
                this.categories.splice(index, 1)
            },
            async update() {
                try {
                    const response = await axios.put(`/api/category/${this.editSlug}`, this.form)
                    this.categories.unshift(response.data.data)
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            },
            async destroy(slug, index) {
                try {
                    const response = await axios.delete(`/api/category/${slug}`, this.form)
                    this.categories.splice(index, 1)
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            }
        },
        async created() {
            if (!User.isAdmin()) {
                this.$router.push('/forum')
            }
            try {
                const response = await axios.get('/api/category')
                this.categories = response.data.data
            } catch (e) {
                if (e.response) {
                    console.log(e.response.data)
                }
            }
        }
    }
</script>
