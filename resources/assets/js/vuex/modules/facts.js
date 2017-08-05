import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  facts: [], //stores and organizes facts
  factsReady: false
}

// getters
const getters = {
  getFactById: (state, getters) => (id) => {
    return state.facts[id - 1]
  },
  checkFactsReady: (state) => state.factsReady
}

// actions
const actions = {
  setupFacts ({commit}) {
    axios.get('../api/student/facts')
    .then(function (response) {
      console.log("facts data is ", + response.data);
      //console.log(response.data[1])
      //console.log(response.data.length);
      let temp = response.data;
      let facts = [];
      //console.log(typeof(words));
      for(let i = 0; i < temp.length; i++ ) {
        facts.push(temp[i]);
      }
      //console.log(words);
      //console.log(typeof(words));
        commit(types.INITIALIZE_FACTS, facts);
    })
    .catch(function (error) {
        console.log(error);
    });
  }
}

// mutations
const mutations = {
  [types.INITIALIZE_FACTS] (state, facts) {
    //console.log("in mutation, words is: " + words);
    state.facts = facts;
    console.log('facts set');
    state.factsReady = true;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
