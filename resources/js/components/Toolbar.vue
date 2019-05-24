<template>
    <v-toolbar>
<!--        <v-toolbar-side-icon></v-toolbar-side-icon>-->
        <v-toolbar-title>Single Page Forum</v-toolbar-title>
        <v-spacer></v-spacer>
        <div class="hidden-sm-and-down">
            <router-link v-for="(item, i) in items"
                         :key="i"
                         :to="item.to"
                         v-if="item.show">
                <v-btn flat>{{ item.title }}</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>

<script>
    export default {
        data() {
            return {
                items: [
                    { id: 'forum', title: 'Forum', to: '/forum', show: false },
                    { id: 'ask', title: 'Ask question', to: '/ask', show: false },
                    { id: 'category', title: 'Category', to: '/category', show: false },
                    { id: 'login', title: 'Login', to: '/login', show: false },
                    { id: 'logout', title: 'Logout', to: '/logout', show: false }
                ]
            }
        },
        methods: {
            updateItemsVisibility() {
                this.items.forEach(item => {
                    item.show = item.id === 'login' ? !User.loggedIn() : User.loggedIn()
                })
            }
        },
        created() {
            this.updateItemsVisibility()

            EventBus.$on('login', () => {
                this.updateItemsVisibility()
            })
            EventBus.$on('logout', () => {
                this.updateItemsVisibility()
                this.$router.push({ name: 'login' })
            })
        }
    }
</script>