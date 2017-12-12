import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueCookie from 'vue-cookie';
import VueI18n from 'vue-i18n';
import VeeValidate from 'vee-validate';
import Request from './utilities/Request';
import Notifications from 'vue-notification';

window.Vue = Vue;

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(VueCookie);
Vue.use(VueI18n);
Vue.use(VeeValidate);
Vue.use(Notifications);

window.axios = axios;

window.Request = Request;
