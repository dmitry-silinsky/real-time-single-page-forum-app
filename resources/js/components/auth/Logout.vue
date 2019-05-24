<template></template>

<script>
    export default {
        created() {
            User.logout()
            EventBus.$emit('logout')
        }
    }
</script>
