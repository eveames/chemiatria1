import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  user: "", //user name
  setupComplete: false, //true when everything is initialized
  currentQuestion: {}, //stores current question
  frustrationCount: 0, //counts how many times user indicates frustrationCount
  hintCount: 0, //counts how many times user requests hint
  errors: "" //collects session errors for display
}

// getters
const getters = {
  checkSetup: (state) => state.setupComplete
}

// actions
const actions = {
  setReady ({commit}) {
    console.log('setReady');
    commit(types.SET_READY);
  },
  setQuestion ({state, commit, rootState}, question) {
    console.log("in setQuestion, question is ", question)
    commit(types.SET_QUESTION, question);
  }
}

// mutations
const mutations = {
  [types.SET_READY] (state) {
    state.setupComplete = true;
  },
  [types.SET_QUESTION] (state, question) {
    console.log(question)
    state.currentQuestion = question;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
