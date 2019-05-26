<template>
    <v-footer class="mt-5 pa-3" inset app height="auto">
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
