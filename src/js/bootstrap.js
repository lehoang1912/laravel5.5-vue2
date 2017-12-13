import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueCookie from 'vue-cookie';
import VueI18n from 'vue-i18n';
import vi from 'vee-validate/dist/locale/vi';
import VeeValidate, { Validator } from 'vee-validate';
import Request from './utilities/Request';
import Notifications from 'vue-notification';

window.Vue = Vue;

Validator.localize('vi', vi);

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueCookie);
Vue.use(VueI18n);
Vue.use(VeeValidate, {
    locale: 'vi'
});
Vue.use(Notifications);

window.axios = axios;

window.Request = Request;
window.$baseUrl = process.env.MIX_URL;
