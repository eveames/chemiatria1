import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  words: [], //stores and organizes facts
  wordsReady: false
}

// getters
const getters = {
  getWordById: (state, getters) => (id) => {
    return state.words[id - 1]
  },
  checkWordsReady: (state) => state.wordsReady
}

// actions
const actions = {
  setupWords ({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('../api/student/words')
      .then((response) => {
        let temp = response.data;
        let words = [];
        for(let i = 0; i < temp.length; i++ ) {
          let alts = temp[i].altwords;
          let prompts = JSON.parse(temp[i].prompts);
          //console.log(prompts);
          let word = {word: temp[i].word, type_id: temp[i].id, altwords: alts, prompts: prompts};
          words.push(word);
        }
        commit(types.INITIALIZE_WORDS, words);
        resolve()
      }).catch((error) => {
        console.log(error);
        reject();
      });
    })
  }
}

// mutations
const mutations = {
  [types.INITIALIZE_WORDS] (state, words) {
    console.log("in INITIALIZE_WORDS, words is: " + words);
    state.words = words;
    //console.log(state.words[1].altwords[0]);
    state.wordsReady = true;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
