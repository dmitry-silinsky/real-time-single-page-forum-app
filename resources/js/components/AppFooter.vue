<template>
    <v-footer class="pa-3" fixed height="auto">
        <v-layout justify-center row wrap>
            <v-flex text-xs-center>&copy; {{ new Date().getFullYear() }} - <strong>Single Page Forum</strong></v-flex>
        </v-layout>
    </v-footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>

</style>