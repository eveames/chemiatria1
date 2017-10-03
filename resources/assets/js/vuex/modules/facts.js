import * as types from '../mutation_types'

// initial state
// shape: [{ id, quantity }]
const state = {
  facts: [], //stores and organizes facts
  factsReady: false,
  anionsList: [{name: 'chloride', formula: 'Cl-1', charge: -1},
  {name: 'bromide', formula: 'Br-1', charge: -1},
  {name: 'fluoride', formula: 'F-1', charge: -1},
  {name: 'iodide', formula: 'I-1', charge: -1},
  {name: 'oxide', formula: 'O-2', charge: -2},
  {name: 'sulfide', formula: 'S-2', charge: -2},
  {name: 'nitride', formula: 'N-3', charge: -3}],

  cationsList: [{name: 'lithium', formula: 'Li', charge: 1, romNum: false},
  {name: 'sodium', formula: 'Na', charge: 1, romNum: false},
  {name: 'magnesium', formula: 'Mg', charge: 2, romNum: false},
  {name: 'potassium', formula: 'K', charge: 1, romNum: false},
  {name: 'calcium', formula: 'Ca', charge: 2, romNum: false},
  {name: 'strontium', formula: 'Sr', charge: 2, romNum: false},
  {name: 'cesium', formula: 'Cs', charge: 1, romNum: false},
  {name: 'barium', formula: 'Ba', charge: 2, romNum: false},
  {name: 'aluminum', formula: 'Al', charge: 3, romNum: false},
  {name: 'titanium', formula: 'Ti', charge: [3,4], romNum: true},
  {name: 'vanadium', formula: 'V', charge: [2,3,4,5], romNum: true},
  {name: 'chromium', formula: 'Cr', charge: [2,3,4,6], romNum: true},
  {name: 'manganese', formula: 'Mn', charge: [2,3,4,7], romNum: true},
  {name: 'iron', formula: 'Fe', charge: [2,3], romNum: true},
  {name: 'cobalt', formula: 'Co', charge: [2,3], romNum: true},
  {name: 'nickel', formula: 'Ni', charge: [2,3], romNum: true},
  {name: 'platinum', formula: 'Pt', charge: [2,4], romNum: true},
  {name: 'copper', formula: 'Cu', charge: [1,2], romNum: true},
  {name: 'silver', formula: 'Ag', charge: [1], romNum: true},
  {name: 'zinc', formula: 'Zn', charge: [2], romNum: false},
  {name: 'cadmium', formula: 'Cd', charge: [2], romNum: true},
  {name: 'mercury', formula: 'Hg', charge: [2], romNum: true},
  {name: 'uranium', formula: 'U', charge: [4,6], romNum: true},
  {name: 'tin', formula: 'Sn', charge: [2,4], romNum: true},
  {name: 'lead', formula: 'Pb', charge: [2,4], romNum: true},
  {name: 'mercury(I)', formula: 'Hg2+2', charge: 2, level: 2}],
  polyanionsList: [],
  polycationsList: []

}

// getters
const getters = {
  getFactById: (state, getters) => (id) => {
    return state.facts[id - 1]
  },
  checkFactsReady: (state) => state.factsReady,
  getFacts: (state) => state.facts,
  getIons: (state) => {
    return {cat: state.cationsList, an: state.anionsList,
    polycat: state.polycationsList, polyan: state.polyanionsList};
  }
}

// actions
const actions = {
  setupFacts ({commit}) {
    return new Promise((resolve, reject) => {
      axios.get('../api/student/facts')
      .then((response) => {
        //console.log("facts data is ", + response.data);
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
          resolve()
      }).catch((error) => {
          console.log(error);
          reject();
        });
      })
  },
  setupIons ({commit}) {
      return new Promise((resolve, reject) => {
        axios.get('../api/student/ions')
        .then((response) => {
          let temp = response.data;
          let polyan = [];
          let polycat = [];
          let ion = {};
          let charge = 0;
          //console.log(typeof(words));
          for(let i = 0; i < temp.length; i++ ) {
            charge = Number(/((?:\+|-)\d)/.exec(state.facts[temp[i]].key)[0]);
            if (charge > 0) ion = {name: state.facts[temp[i]].prop, formula: state.facts[temp[i]].key, charge: charge, romNum: false}
            else ion = {name: state.facts[temp[i]].prop, formula: state.facts[temp[i]].key, charge: charge}
            console.log(ion);
            if (charge < 0) polyan.push(ion);
            else polycat.push(ion);
          }
            commit(types.INITIALIZE_IONS, polyan, polycat);
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
    [types.INITIALIZE_FACTS] (state, facts) {
      //console.log("in mutation, words is: " + words);
      state.facts = facts;
      console.log('facts set');
      state.factsReady = true;
    },
    [types.INITIALIZE_IONS] (state, polyan, polycat) {
      console.log("in INITIALIZE_IONS");
      state.polyanionsList = polyan;
      state.polycationsList = polycat;
    }
  }

export default {
  state,
  getters,
  actions,
  mutations
}
