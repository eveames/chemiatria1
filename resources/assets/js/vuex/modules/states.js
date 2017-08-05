import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  states: [], //stores and organizes facts
  statesReady: false,
  currentIndex: 0,
  currentTypeID: 0,
  currentType: '',
  finished: false
}

// getters
const getters = {
  checkStatesReady: (state) => state.statesReady,
  getCurrent: (state) => {
    console.log("called getCurrent");
    let curr = [state.currentIndex, state.currentTypeID, state.currentType];
    console.log(curr, typeof(curr));
    return curr;
  }

}

// actions
const actions = {
  setupStates ({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('../api/student/states')
      .then((response) => {
      //console.log(response.data);
      let temp = response.data;
      let states = [];
      for(let i = 0; i < temp.length; i++ ) {
        states.push(temp[i]);
      }
      //console.log(states);
      commit(types.INITIALIZE_STATES, states);
      resolve();
      }).catch(function (error) {
        console.log(error);
        reject();
      });
    })
  }
}

// mutations
const mutations = {
  [types.INITIALIZE_STATES] (state, states) {
    state.states = states;
    console.log("state.states is ", state.states);
    state.currentIndex = getNext();
    console.log(typeof(state.currentIndex))
    state.currentTypeID = state.states[state.currentIndex].type_id;
    state.currentType = state.states[state.currentIndex].type;
    state.statesReady = true;
  }
}

const getNext = () => {
    	//reduce studyArray to next value
    	let currentTime = Date.now();
    	//var nextQ;
    	var readiest = -1;
    	var readiestUnready = -1;
        //console.log('in selectNextQuestion, ', studyArray);
    	for (let i = 0; i < state.states.length; i++) {
        //console.log('state.states[i] is: ', state.states[i]);
        //console.log('state.states[i -1] is: ', state.states[i-1]);
        if (state.states[i].priority === 1) {
    			if (readiest !== -1) {console.log("first:", readiest); return readiest;}
    			else {console.log(i); return i;}
    		}
    		else if (state.states[i].priority <= currentTime) {
    			if (readiest !== -1) {
    				if (state.states[readiest].priority > state.states[i].priority) {
    				readiest = i;
    				}
    			}
    			else {readiest = i;}
    		}
    		else {
    			if (readiestUnready !== -1) {
    				if (state.states[readiestUnready].priority > state.states[i].priority) {
    					readiestUnready = i;
    				}
    			}
    			else {readiestUnready = i;}
    		}
    	}
    	//console.log(readiest);
    	if (readiest !== -1) {console.log("readiest: ", readiest); return readiest;}
    	else {
            //console.log()
            if (state.states[readiestUnready].priority > currentTime + 1800000) {state.finished = true;}
            return readiestUnready;
        }
    };

export default {
  state,
  getters,
  actions,
  mutations
}
