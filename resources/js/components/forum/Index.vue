<template>
    <h1>Forum</h1>
</template>

<script>
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({ name: 'login' })
            }
        }
    }
</script>
