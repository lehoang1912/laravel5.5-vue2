<template src="./login.html"></template>

<script>
    export default {
        data() {
            return {
                email: null,
                password: null
            };
        },

        beforeCreate() {
            if (this.$cookie.get('token')) {
                this.$router.push('/');
            }
        },

        methods: {
            login() {
                let data = {email: this.email, password: this.password};
                Request.post('/api/login', data)
                    .then(
                        (response) => {
                            this.saveCookie(response.data);
                            this.$router.push('/');
                        }
                    ).catch(
                    (errorsResponse) => {
                        console.log(errorsResponse[0]);
                        for (let index in errorsResponse[0]) {
                            if (!errorsResponse[0].hasOwnProperty(index)) continue;
                            this.errors.items.unshift({field: index, msg: errorsResponse[0][index][0], scope:null});
                        }
                    }
                );
            },

            saveCookie(data) {
                this.$cookie.set('token', data.token);
                this.$cookie.set('user_info', JSON.stringify(data.user_info));
            }
        }
    }
</script>

<style>
    body {
        background: #d2d6de;
    }
</style>