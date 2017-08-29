import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  states: [], //stores and organizes facts
  skills: [],
  statesReady: false,
  skillsReady: false,
  currentIndex: 0,
  currentTypeID: 0,
  currentType: '',
  currentStage: 0,
  currentStateID: 0,
  currentSubtype: false,
  currentSkill: false,
  finished: false,
}
// getters
const getters = {
  checkStatesReady: (state) => state.statesReady,
  getCurrentStateID: (state) => state.currentStateID,
  getCurrent: (state) => {
    //console.log("called getCurrent");
    let curr = [state.currentIndex, state.currentTypeID, state.currentType,
      state.currentStage, state.currentStateID, state.currentSubtype, state.currentSkill];
    //console.log(curr, typeof(curr));
    return curr;
  },
  getStageData: () => {
    if (state.states.length !== 0) {
      let stage = state.states[state.currentIndex];
      //console.log('called getStageData, ', stage);
      let temp = {stage: stage.stage, priority: stage.priority,
        accs: stage.accs, rts: stage.rts, lastStudied: stage.lastStudied}
      return temp;
    }
    else return null;
  }

}

// actions
const actions = {
  setupStates ({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('../api/student/states/active')
      .then((response) => {
      console.log(response.data);
      let temp = response.data;
      let states = [];
      let thisState = {};
      for(let i = 0; i < temp.length; i++ ) {
        thisState = temp[i];
        if (thisState.rts === "") thisState.rts = [];
        else if (typeof(thisState.rts) === "string") {
          thisState.rts = JSON.parse(thisState.rts);
        }
        if (thisState.accs === "") thisState.accs = [];
        else if (typeof(thisState.accs) === "string") {
          thisState.accs = JSON.parse(thisState.accs);
        }
        states.push(thisState);
      }
      console.log(states);
      commit(types.INITIALIZE_STATES, states);
      commit(types.SET_QUESTION);
      resolve();
      }).catch(function (error) {
        console.log(error);
        reject();
      });
    })
  },

  setupSkills ({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('../api/student/skills')
      .then((response) => {
      //console.log(response.data);
      let temp = response.data;
      let skills = [];
      for(let i = 0; i < temp.length; i++ ) {
        skills.push(temp[i]);
      }
      console.log(skills);
      commit(types.INITIALIZE_SKILLS, skills);
      resolve();
      }).catch(function (error) {
        console.log(error);
        reject();
      });
    })
  },
  updateRtsAccs ({commit}, newState) {
    commit(types.UPDATE_RTS_ACCS, newState);
  },
  updateStage ({commit}, newState) {
    commit(types.UPDATE_STAGE, newState);
  },
  setQuestion ({commit}) {
    let prev = state.currentIndex;
    let state_id = state.currentStateID;
    console.log("prev is ", prev)
    let url = '../api/student/states/' + state_id;
    console.log(url)
    console.log("state for updating: ", state.states[prev]);
    axios.post(url, state.states[prev])
    .catch(function (error) {
      console.log(error);
    })
    commit(types.SET_QUESTION);
    //console.log('after SET_QUESTION, prev is ', prev)
  }
}

// mutations
const mutations = {
  [types.INITIALIZE_STATES] (state, states) {
    state.states = states;
    state.statesReady = true;
  },
  [types.INITIALIZE_SKILLS] (state, skills) {
    state.skills = skills;
    state.skillsReady = true;
  },
  [types.SET_QUESTION] (state) {
    console.log('before getNext index is ', state.currentIndex)
    state.currentIndex = getNext();
    console.log('after getNext index is ', state.currentIndex, state.states[state.currentIndex].type_id)
    state.currentTypeID = state.states[state.currentIndex].type_id;
    state.currentType = state.states[state.currentIndex].type;
    state.currentStage = state.states[state.currentIndex].stage;
    state.currentStateID = state.states[state.currentIndex].id;
    state.states[state.currentIndex].lastStudied = Date.now();
    if (state.currentType === 'skill') {
      console.log('before subtype')
      state.currentSubtype = state.skills[state.currentTypeID -1].subtype;
      console.log('after subtype')
      state.currentSkill = state.skills[state.currentTypeID -1].skill;
    }
    else {
      state.currentSubtype = false;
      state.currentSkill = false;
    }
  },
  [types.UPDATE_RTS_ACCS] (state, newState) {
    console.log("newState is ", newState);
    state.states[state.currentIndex].accs.push(newState.accs)
    state.states[state.currentIndex].rts.push(newState.rts)
    console.log("state is now ", state.states[state.currentIndex])
  },
  [types.UPDATE_STAGE] (state, newState) {
    console.log("newState is ", newState)
    state.states[state.currentIndex].priority = newState.priority;
    state.states[state.currentIndex].stage = newState.stage;
    console.log("state is now ", state.states[state.currentIndex])
  }
}

const getNext = () => {
    	//reduce studyArray to next value
    	let currentTime = Date.now();
    	//var nextQ;
    	var readiest = -1;
    	var readiestUnready = -1;

    	for (let i = 0; i < state.states.length; i++) {
        console.log('state.states[i] is: ', state.states[i]);
        //console.log('state.states[i -1] is: ', state.states[i-1]);
        if (state.states[i].priority === 1) {
    			if (readiest !== -1) { return readiest;}
    			else {return i;}
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
    	if (readiest !== -1) { return readiest;}
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
