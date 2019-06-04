<template>
    <div>
        <toolbar></toolbar>
        <v-container fluid fill-height :class="classes">
            <router-view></router-view>
        </v-container>
        <app-footer></app-footer>
    </div>
</template>

<script>
    import Toolbar from './Toolbar'
    import AppFooter from './AppFooter'
    import Login from './auth/Login'

    export default {
        components: {
            Toolbar,
            AppFooter,
            Login
        },
        data() {
            return {
                classes: []
            }
        },
        methods: {
            setClasses(route) {
                this.classes = route.name === 'home' ? ['ma-0', 'pa-0'] : []
            }
        },
        created() {
            this.setClasses(this.$route)

            EventBus.$on('route-changed', (payload) => {
                this.setClasses(payload.to)
            })
        }
    }
</script>
