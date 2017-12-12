import VueI18n from 'vue-i18n';
import vn from '../lang/vn.json';
import en from '../lang/en.json';

const locale = 'vn';
Vue.locale = locale;

const messages = {
    vn, en
};

const i18n = new VueI18n({
    locale,
    messages
});

export default i18n;