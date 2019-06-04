<template>
    <v-toolbar color="indigo" dark>
<!--        <v-toolbar-side-icon></v-toolbar-side-icon>-->
        <v-toolbar-title>
            <router-link class="white--text link" to="/">
                Single Page Forum
            </router-link>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <app-notification v-if="loggedIn"></app-notification>
        <div class="hidden-sm-and-down">
            <router-link v-for="(item, i) in itemsByRole"
                         :key="i"
                         :to="item.to"
                         v-if="item.show"
                         class="link">
                <v-btn flat>{{ item.title }}</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>

<script>
    import AppNotification from './AppNotification'

    export default {
        components: { AppNotification },
        data() {
            return {
                items: [
                    { id: 'forum', title: 'Forum', to: '/forum', show: false, admin: false },
                    { id: 'ask', title: 'Ask question', to: '/ask', show: false, admin: false },
                    { id: 'category', title: 'Category', to: '/category', show: false, admin: true },
                    { id: 'login', title: 'Login', to: '/login', show: false, admin: false },
                    { id: 'logout', title: 'Logout', to: '/logout', show: false, admin: false }
                ]
            }
        },
        computed: {
            loggedIn() {
                return User.loggedIn()
            },
            itemsByRole() {
                return this.items.filter(item => {
                    if (item.admin && !User.isAdmin()) {
                        return false
                    }
                    return true
                })
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

<style scoped>
    .link {
        text-decoration: none;
    }
</style>