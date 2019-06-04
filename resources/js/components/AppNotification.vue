<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on }">
            <v-btn icon>
                <v-icon :color="color" dark v-on="on">notification_important</v-icon>
                <span class="ml-1">{{ unreadCount }}</span>
            </v-btn>
        </template>
        <v-list v-for="notification in unread" :key="notification.id">
            <router-link :to="notification.path">
                <v-list-tile>
                    <v-list-tile-title @click="markAsRead(notification)">
                        {{ notification.question }}
                    </v-list-tile-title>
                </v-list-tile>
            </router-link>
        </v-list>
    </v-menu>
</template>

<script>
    export default {
        data() {
            return {
                read: {},
                unread: {},
                unreadCount: 0
            }
        },
        computed: {
            color() {
                return this.unreadCount !== 0 ? 'red' : 'red lighten-4'
            }
        },
        methods: {
            async getNotifications() {
                try {
                    const response = await axios.get('/api/notification')
                    this.read = response.data.read
                    this.unread = response.data.unread
                    this.unreadCount = response.data.unread.length
                } catch (e) {
                    Exception.handle(e)
                }
            },
            async markAsRead(notification) {
                try {
                    await axios.post(`/api/notification/${notification.id}/mark-as-read`)
                    this.unread.splice(notification, 1)
                    this.read.push(notification)
                    this.unreadCount--
                } catch (e) {
                    if (e.response) {
                        console.log(e.response.data)
                    }
                }
            }
        },
        created() {
            if (User.loggedIn()) {
                this.getNotifications()
            }

            Echo.private(`App.Models.User.${User.id()}`).notification((notification) => {
                this.unread.unshift(notification)
                this.unreadCount++
            })
        }
    }
</script>
