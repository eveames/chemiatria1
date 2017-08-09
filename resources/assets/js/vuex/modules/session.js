import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  user: "", //user name
  setupComplete: false, //true when everything is initialized
  questionSetTime: 0,
  frustrationCount: 0, //counts how many times user indicates frustrationCount
  hintCount: 0, //counts how many times user requests hint
  errors: "", //collects session errors for display
  message: ''
}

// getters
const getters = {
  checkSetup: (state) => state.setupComplete,
  getQuestionSetTime: (state) => state.questionSetTime
}

// actions
const actions = {
  setReady ({commit}) {
    //console.log('setReady');
    commit(types.SET_READY);
  },
  setQuestionStart ({commit}) {
    commit(types.SET_QUESTION_START, Date.now())
  },
  setMessage ({commit}, message) {
    commit(types.SET_MESSAGE, message)
  }
}

// mutations
const mutations = {
  [types.SET_READY] (state) {
    state.setupComplete = true;
  },
  [types.SET_QUESTION_START] (state, time) {
    state.questionSetTime = time;
  },
  [types.SET_MESSAGE] (state, message) {
    state.message = message;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
