import Vue from 'vue';
import Vuex from 'vuex';
// import { getToken } from '../utils/utils.js';

Vue.use(Vuex);

const state = {
  me: null
};

export default new Vuex.Store({
  state,
  mutations: {
    UPDATE_ME (state, me) {
      state.me = me;
    }
  },
  actions: {
    updateMe ({ commit }) {
      Vue.prototype.$http.get('auth/me?include=collections,subcribe_collections', {
        params: {
          token: localStorage.getItem('jwt_token')
        }
      }).then(res => {
        commit('UPDATE_ME', res.data.data);
      });
    }
  }
});
