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
  feedback: '',
  feedbackType: {
    "alert-success": true,
  },
  message: '',
  frustrated: false,
  bug: false,
  suggestion: false
}

// getters
const getters = {
  checkSetup: (state) => state.setupComplete,
  getQuestionSetTime: (state) => state.questionSetTime,
  getFeedback: (state) => state.feedback,
  getFeedbackType: (state) => state.feedbackType,
  isBug: (state) => state.bug,
  isFrustrated: (state) => state.frustrated,
  hasSuggestion: (state) => state.suggestion,
  getMessage: (state) => state.message
}

// actions
const actions = {
  setReady ({commit}) {
    //console.log('setReady');
    commit(types.SET_READY);
  },
  setQuestionStart ({commit}) {
    commit(types.SET_QUESTION_START, Date.now())
    commit(types.SET_MESSAGE, '')
  },
  setMessage ({commit}, message) {
    commit(types.SET_MESSAGE, message)
  },
  setFeedback ({commit}, feedback) {
    commit(types.SET_FEEDBACK, feedback)
  },
  setFeedbackType ({commit}, feedbackType) {
    commit(types.SET_FEEDBACK_TYPE, feedbackType)
  },
  toggleBug ({commit}) {
    commit(types.TOGGLE_BUG)
  },
  toggleFrustrated ({commit}) {
    commit(types.TOGGLE_FRUSTRATED)
  },
  toggleSuggestion ({commit}) {
    commit(types.TOGGLE_SUGGESTION)
  },
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
  },
  [types.SET_FEEDBACK] (state, feedback) {
    state.feedback = feedback;
  },
  [types.SET_FEEDBACK_TYPE] (state, feedbackType) {
    state.feedbackType = feedbackType;
  },
  [types.TOGGLE_BUG] (state) {
    state.bug = !state.bug;
  },
  [types.TOGGLE_FRUSTRATED] (state) {
    state.frustrated = !state.frustrated;
  },
  [types.TOGGLE_SUGGESTION] (state) {
    state.suggestion = !state.suggestion;
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
