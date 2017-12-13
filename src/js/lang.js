import VueI18n from 'vue-i18n';
import vn from '../lang/vn.json';
import en from '../lang/en.json';

const i18n = new VueI18n({
    locale: 'vn',
    messages: {
        vn, en
    }
});

export default i18n;