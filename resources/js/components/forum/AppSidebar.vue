<template>
    <v-card>
        <v-toolbar color="cyan" dark dense class="mt-2">
            <v-toolbar-title>Categories</v-toolbar-title>
        </v-toolbar>

        <v-list>
            <v-list-tile v-for="category in categories" :key="category.id">
                <v-list-tile-content>
                    <v-list-tile-title>{{ category.name }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        async created() {
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
