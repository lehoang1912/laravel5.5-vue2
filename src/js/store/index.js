import Vuex from 'vuex';
import mutations from './mutations';
import actions from './actions';

export default new Vuex.Store({
  state: {
    lang: 'vn'
  },

  mutations,
  actions
})