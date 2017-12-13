import { SET_LANG } from './mutation-types';

export default {
  [SET_LANG] (state, lang) {
    state.lang = lang;
  }
}