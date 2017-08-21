import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import actions from './actions'
import mutations from './mutations'
import facts from './modules/facts'
import states from './modules/states'
import words from './modules/words'
import session from './modules/session'
import elements from './modules/elements'

Vue.use(Vuex)

export default new Vuex.Store({
  mutations,
  getters,
  actions,
  modules: {
    words,
    facts,
    session,
    states,
    elements
  },
})
