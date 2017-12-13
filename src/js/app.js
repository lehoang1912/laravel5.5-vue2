import Vue from 'vue'
import './bootstrap';
import router from './routes';
import i18n from './lang';
import index from './store/index.js'

Vue.config.productionTip = false;

new Vue({
    el: '#app',

    store: index,

    router,

    i18n,

    created() {
        // Add a response interceptor
        axios.interceptors.response.use((response) => {
            return response;
        }, (error) => {
            this.$notify({
                group: 'notification',
                title: 'Error!',
                text: error.response.data.message,
                type: 'error',
                duration: 5000
            });

            if (error.response.status === 401) {
                this.$cookie.delete('token');
                this.$router.push('/login');
            }
            return Promise.reject(error);
        });

        this.$i18n.locale = this.$store.state.lang
    }
});
