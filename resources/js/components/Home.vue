<template>
    <div>
        <toolbar></toolbar>
        <v-container fluid fill-height>
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
        }
    }
</script>
