<template src="./logout.html"></template>

<script>
    export default {
        methods: {
            logout() {
                Request.get('/api/logout')
                    .then(
                        (response) => {
                            this.$cookie.delete('token');
                            this.$cookie.delete('user_info');
                            this.$router.push('/login');
                        }
                    );
            }
        }
    }
</script>