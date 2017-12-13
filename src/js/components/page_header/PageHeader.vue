<template src="./page-header.html"></template>

<script>
    import Logout from '../logout/Logout';

    export default {
        data() {
            return {
                user: JSON.parse(this.$cookie.get('user_info'))
            }
        },

        components: {
            Logout
        }
    }
</script>

<style>
    .change-pw {
        margin-left: 5px;
    }
</style>