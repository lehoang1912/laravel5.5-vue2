<template src="./menu-sidebar.html"></template>

<script>
    export default {

        data() {
            return {
                is_bot_template: false
            }
        },

        mounted() {

            var user = JSON.parse(this.$cookie.get('user_info'));

            if (user.is_bot_template) {
                this.is_bot_template = true;
            }
        }
    }
</script>